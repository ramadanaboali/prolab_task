<?php

namespace App\Http\Controllers\Api\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\UserManagement\UserRepo;
use App\Http\Requests\Api\UserRequest;
use App\Http\Requests\BulkDeleteRequest;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\SearchResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\File as FileFile;

class UserController extends Controller
{
    protected $repo;

    public function __construct(UserRepo $repo)
    {

        $this->repo = $repo;

    }

    public function index(PaginateRequest $request)
    {
        $input = $this->repo->inputs($request->all());
        $model = new User();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->repo->whereOptions($input, $columns);

        }
        $data = $this->repo->Paginate($input, $wheres);

        return responseSuccess([
            'data' => $input["resource"] == "all" ? UserResource::collection($data) : SearchResource::collection($data),
            'meta' => [
                'total' => $data->count(),
                'currentPage' => $input["offset"],
                'lastPage' => $input["paginate"] != "false" ? $data->lastPage() : 1,
            ],
        ], 'data returned successfully');
    }

    public function get($User)
    {
        $data = $this->repo->findOrFail($User);

        return responseSuccess([
            'data' => new UserResource($data),
        ], 'data returned successfully');
    }



    public function store(UserRequest $request)
    {

        $input = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'priceBeforeDiscount' => $request->priceBeforeDiscount,
            'priceAfterDiscount' => $request->priceAfterDiscount,
            'discountPercentage' => $request->discountPercentage,
            'first_headline_ar' => $request->first_headline_ar,
            'first_headline_en' => $request->first_headline_en,
            'second_headline_ar' => $request->second_headline_ar,
            'second_headline_en' => $request->second_headline_en,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'points' => $request->points,
            'permitDays' => $request->permitDays,
            'couponValue' => $request->couponValue,
            'type' => $request->type,
            'service_id' => $request->service_id,
        ];

         //here insert images

        if ($request->hasFile('logo')) {

            $destination_path = 'User/images';
            $image = $request->file('logo');
            $input['logo'] = $this->repo->storeFile($image,$destination_path);

        }

         $data = $this->repo->create($input);


        if ($data) {
            return responseSuccess(new UserResource($data), 'data saved successfully');
        } else {
            return responseFail('something went wrong');
        }

    }


    public function update($User, UserRequest $request)
    {

        $User = $this->repo->findOrFail($User);
        $input = [
            'name_ar' => $request->name_ar ??  $User->name_ar,
            'name_en' => $request->name_en ??  $User->name_en,
            'service_id' => $request->service_id ?? $User->service_id,
            'priceBeforeDiscount' => $request->priceBeforeDiscount ?? $User->priceBeforeDiscount,
            'priceAfterDiscount' => $request->priceAfterDiscount ?? $User->priceAfterDiscount,
            'discountPercentage' => $request->discountPercentage ?? $User->discountPercentage,
            'points' => $request->points ?? $User->points,
            'first_headline_ar' => $request->first_headline_ar ?? $User->first_headline_ar,
            'first_headline_en' => $request->first_headline_en ?? $User->first_headline_en,
            'second_headline_ar' => $request->second_headline_ar ?? $User->second_headline_ar,
            'second_headline_en' => $request->second_headline_en ?? $User->second_headline_en,
            'description_ar' => $request->description_ar ?? $User->description_ar,
            'description_en' => $request->description_en ?? $User->description_en,
            'couponValue' => $request->couponValue ?? $User->couponValue,
            'permitDays' => $request->permitDays ?? $User->permitDays,
            'type' => $request->type ?? $User->type,
        ];

            $file=request()->file('logo');
            if( $file)
            {



              File::delete('User/images/'.$User->logo);

                $destination_path = 'User/images';
                $image = $request->file('logo');
                $input['logo'] = $this->repo->storeFile($image,$destination_path);

            }

            $data = $this->repo->update($input, $User);

          if ($data) {
            return responseSuccess(new UserResource($User->refresh()), 'data Updated successfully');
          } else {
            return responseFail('something went wrong');
          }
    }



    public function bulkDelete(BulkDeleteRequest $request)
    {
        DB::beginTransaction();
        try {

            $data = $this->repo->bulkDelete($request->ids);
            if ($data) {

                DB::commit();
                return responseSuccess([], 'data deleted successfully');
            } else {
                return responseFail('something went wrong');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return responseFail('something went wrong');
        }
    }

    public function bulkRestore(BulkDeleteRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $this->repo->bulkRestore($request->ids);
            if ($data) {
                DB::commit();
                return responseSuccess([], 'data restored successfully');
            } else {
                return responseFail('something went wrong');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return responseFail('something went wrong');
        }
    }

}
