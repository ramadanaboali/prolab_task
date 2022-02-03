<?php

namespace App\Http\Controllers\Api;

use App\Http\Repositories\Eloquent\AuthRepo;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthSocialLoginRequest;
use App\Http\Requests\CarPhotoRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\CheckCodeRequest;
use App\Http\Requests\ResetCodeRequest;
use App\Http\Requests\ResetRequest;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AuthProfileImageRequest;
use App\Http\Requests\Api\AuthProfileRequest;
use App\Http\Requests\Api\FCMRequest;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\DeleteStateRegisterRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\StateRegisterRequest;
use App\Http\Resources\LookUps\RegionResource;
use App\Http\Resources\LookUps\StateResource;
use App\Http\Resources\SearchResource;
use App\Models\Region;
use App\Models\State;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Schema;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $repo;

    public function __construct(AuthRepo $repo) {
        $this->repo = $repo;
    }

    public function forgotEmail(ResetRequest $request) {
        try {
            $user=User::where('email',$request->email)->first();
            if($user){
 
 //               $otpCode=$this->repo->generateRandomString(4);
                $otpCode="1234";
                User::where("email",$request->email)->update([
                    "reset_code" => $otpCode
                    ]);
                    $message = "Your Reset Password OTP Code is " . $otpCode;
                    return responseSuccess([], 'We Send you Code at your email please copy and paste it here', 200);
 
 //                   $smsResult = $this->repo->sendSMS($request->phone,$message);
 //                   if ($smsResult->getStatusCode() != 200 || $smsResult["code"] != 1901) {
 //                     return responseFail("Cannot send reset code please try again later",400);
 //                    }else{
 //                      return responseSuccess([], 'We Send you Code at your phone please copy and paste it here', 200);
 //                    }
                    //$smsResult = $this->repo->smsTwillio($request->phone,$message);
                 //    if($smsResult->errorCode){
                 //        return responseFail("Cannot send reset code please try again later",400);
                 //     }else{
                 //         return responseSuccess([], 'We Send you Code at your phone please copy and paste it here', 200);
 
                 //     }
                 }else{
 
              return responseFail("Your number not found please register first",400);
              }
        } catch (\Exception $ex) {
             return responseFail($ex->getMessage(),400);
         }
        // try {
        //     $response = Password::sendResetLink($request->only('email'), function (Message $message) {
        //         $message->subject($this->getEmailSubject());
        //     });
        //     switch ($response) {
        //         case Password::RESET_LINK_SENT:
        //             return responseSuccess([],'Reset password link sent on your email id.');
        //         case Password::INVALID_USER:
        //             return responseFail($response,400);
        //     }
        // } catch (\Swift_TransportException $ex) {
        //     return responseFail($ex->getMessage(),400);
        // } catch (\Exception $ex) {
        //     return responseFail($ex->getMessage(),400);
        // }
    }

    public function forgot(ResetRequest $request) {
      try {
           $user=User::where('phone',$request->phone)->first();
           if($user){

//               $otpCode=$this->repo->generateRandomString(4);
               $otpCode="1234";
               User::where("phone",$request->phone)->update([
                   "reset_code" => $otpCode
                   ]);
                   $message = "Your Reset Password OTP Code is " . $otpCode;
                   return responseSuccess([], 'We Send you Code at your phone please copy and paste it here', 200);

//                   $smsResult = $this->repo->sendSMS($request->phone,$message);
//                   if ($smsResult->getStatusCode() != 200 || $smsResult["code"] != 1901) {
//                     return responseFail("Cannot send reset code please try again later",400);
//                    }else{
//                      return responseSuccess([], 'We Send you Code at your phone please copy and paste it here', 200);
//                    }
                   //$smsResult = $this->repo->smsTwillio($request->phone,$message);
                //    if($smsResult->errorCode){
                //        return responseFail("Cannot send reset code please try again later",400);
                //     }else{
                //         return responseSuccess([], 'We Send you Code at your phone please copy and paste it here', 200);

                //     }
                }else{

             return responseFail("Your number not found please register first",400);
             }
       } catch (\Exception $ex) {
            return responseFail($ex->getMessage(),400);
        }
    }

    public function checkcode(CheckCodeRequest $request) {
        try {

           $found= User::where("email",$request->email)->where("reset_code",$request->code)->first();

           if($found){
            return responseSuccess([], 'Success code is correct', 200);
            }
                return responseFail("Error Code you enter not correct",400);
       } catch (\Exception $ex) {
            return responseFail($ex->getMessage(),400);
        }
    }

    public function reset(ResetCodeRequest $request) {
        try {

            $user=User::where("reset_code",$request->reset_code)->update([
                'password' => Hash::make($request->password),
            ]);

            if ($user) {
                $user=User::where("reset_code",$request->reset_code)->update([
                    'reset_code' => null,
                ]);
                return responseSuccess([], 'Data Updated Successfully', 200);
            }else{
                return responseFail("Cannot reset  password please try again later",400);
            }


        } catch (\Exception $ex) {
            return responseFail($ex->getMessage(),400);
        }
    }

    public function login(AuthLoginRequest $request) {

        return $this->repo->login($request->all());

    }

    public function social_login(AuthSocialLoginRequest $request) {

        return $this->repo->social_login($request->all());

    }

    public function register(AuthRegisterRequest $request) {
        return $this->repo->register($request->all());
//        if($data){
//            return responseSuccess(['id'=>$data->id,'name'=>$data->name],' data inserted successfully');
//        }else{
//            return responseFail("Cannot Add user",401);
//        }
    }

    public function updateFcmToken(FCMRequest $token) {
        $user=User::find(auth()->user()->id);
        if($user){
            $user->update(['fcm_token'=>$token->token]);
            return responseSuccess([],' data updated successfully');

        }
        return responseFail("Cannot send Notification",401);
    }

    public function assign_state_region(StateRegisterRequest $request) {
        $data=$this->repo->assign_state_region($request->all());

        if($data){
            return responseSuccess([],' data inserted successfully');
        }else{
            return responseFail("Cannot Add state and region",401);
        }

    }

    public function delete_state_region(DeleteStateRegisterRequest $request) {
        $data=$this->repo->delete_state_region($request->all());

        if($data){
            return responseSuccess([],' data deleted successfully');
        }else{
            return responseFail("Cannot Add state and region",401);
        }
    }

    public function enableNotification(Request $request) {
        if($request->enable !=null)
        {
            $user=User::find($request->user_id);
            if($user){
                $user->update(['enable_notification'=>$request->enable]);

                return responseSuccess([],' data updated successfully');
            }else{
                return responseFail("user id invalied",401);
            }

        }else{
            return responseFail("enable field required",401);
        }
        return responseFail("Cannot update_notification",401);


    }



    public function profile($user,AuthProfileRequest $request) {

        $currentUser = $this->repo->findOrFail($user);

        $data=$this->repo->update($request->all(),$currentUser);

        if($data){
            return responseSuccess(new UserResource($currentUser->refresh()),' data Updated successfully');
        }else{
            return responseFail("Cannot Update user",401);
        }
    }
    public function profileImage($user,AuthProfileImageRequest $request) {

        $currentUser = $this->repo->findOrFail($user);
        $file=request()->file('photo');
            $fileName = time() . rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('public/user/images', $fileName);
            $path = url('/storage') . '/' . str_replace('public/', '', $path);
            $input['photo']=   $fileName;

            $data=$this->repo->update($input,$currentUser);

        if($data){
            return responseSuccess(new UserResource($currentUser->refresh()),' data Updated successfully');
        }else{
            return responseFail("Cannot Update user",401);
        }
    }

    public function states(PaginateRequest $request) {
        $input = State::all();
        $model = new State();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->repo->whereOptions($input, $columns);

        }
        $data = $this->repo->Paginate($input, $wheres);

        return responseSuccess([
            'data' => $input["resource"] == "all" ? StateResource::collection($data) : SearchResource::collection($data),
            'meta' => [
                'total' => $data->count(),
                'currentPage' => $input["offset"],
                'lastPage' => $input["paginate"] != "false" ? $data->lastPage() : 1,
            ],
        ], 'data returned successfully');
    }

    public function regions() {
        $regions = Region::all();

        return responseSuccess(new RegionResource($regions),' success');

    }

    public function changePassword($user,ChangePasswordRequest $request) {
        $currentUser = $this->repo->findOrFail($user);
        $data=$this->repo->update(['password' => Hash::make($request->password)],$currentUser);
        if($data){
            return responseSuccess([],' data Updated successfully');
        }else{
            return responseFail("Cannot Update user",401);
        }

    }

    public function me() {
        return response()->json(auth('api')->user());
    }

    public function user() {
        $data=$this->repo->currentUser();
        if($data){
            return responseSuccess(new UserResource($data),'retrieved data successfully');
        }else{
            return responseFail("Cannot find user",401);
        }
    }

    public function logout() {
        try {
                JWTAuth::invalidate();
            return responseSuccess([],'User logged out successfully', 200);
        } catch (JWTException $exception) {
            return responseFail('Sorry, the user cannot be logged out', 400);
        }

    }

    public function refresh() {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithToken($token) {
        return response()->json([
            'success' => true,
            'message' => 'Retrieved successfully',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL()
        ]);
    }

    public function guard() {
        return auth('api')->guard();
    }


}
