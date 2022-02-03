<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\UsersRepo;
use App\Http\Requests\Dashboard\UserRequest;
use App\Role;
use App\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller

{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $repo;


    public function __construct(UsersRepo $repo)
    {
//        $this->middleware('permission:list-users|edit-users|delete-users|create-users', ['only' => ['index', 'store']]);
//        $this->middleware('permission:create-users', ['only' => ['create','store']]);
//        $this->middleware('permission:edit-users', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:delete-users', ['only' => ['destroy', 'delete_all']]);
        $this->repo = $repo;
    }



    public function roles($id)
    {
        return User::find($id)->roles ?? null;
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $roles = Role::all();

        $data=$this->repo->getWhereOperand("type","!=","admin");

        return view('auth.managements.users.index', compact('roles','data'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('auth.managements.users.create',compact('roles'));
    }


    public function store(UserRequest $request)
    {
        try {
            $data=[

                'name' => $request->name,
                'email' => $request->email,
                'type' => $request->type,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'parent_id' => $request->parent_id
            ];


            $item=$this->repo->create($data);
            return redirect()->back()
                ->with('success',__('app.success_message'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error',__('app.some_thing_error'));
        }


    }
    public function update(Request $request,$id)
    {

        $item=$this->repo->findOrFail($id);
       try {
            $data['active']=0;
            if($request->active){
                $data['active']=1;
            }


            $item=$this->repo->update($data,$item);

            return redirect()->back()
                ->with('success',__('app.success_message'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error',__('app.some_thing_error'));
        }


    }

    /**
     * update the Permission for dashboard.
     *
     * @param Request $request
     * @return Builder|Model|object
     */
    public function edit($id)
    {
        $roles = Role::all();
        $user = User::with('roles')->where('id', $id)->first();
        return view('auth.managements.users.edit',compact('id','user','roles'));

    }

    public function show()
    {
        $user = User::where('id', auth()->user()->id)->first();
        return view('auth.managements.users.profile',compact('user'));

    }
    public function changepassword($id)
    {
        $user = User::where('id', auth()->user()->id)->first();
        return view('auth.managements.users.changepassword',compact('user'));

    }
    public function editchangepassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldpassword' => ['required', 'min:8', new MatchOldPassword],
            'password' => 'required|min:8|confirmed'
        ]);
        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors());
        }
           User::find(auth()->user()->id)->update(['password' => Hash::make($request->password)]);

            return redirect('/auth/users/changepassword/'.auth()->user()->id)->with('success', __('app.change_success_message'));

    }
    public function updateprofile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'nullable|email|regex:/^\S+@\S+\.\S+$/|unique:users,email,' . auth()->user()->id,
            'name' => 'required|min:2|unique:users,name,' . auth()->user()->id,
            'phone' => 'required|regex:/^[0-9\-\(\)\/\+\s]*$/|unique:users,phone,' . auth()->user()->id,
        ]);

        if ($validator->errors()->count()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $user = User::where('id', auth()->user()->id)->first();
        if ($user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone
            ]);
        }

        return redirect()->route('users.profile')->with('success',__('app.profile_success_message'));
    }




    /**
     * Delete more than one permission.
     *
     * @param Request $request
     * @return JsonResponse
     */


    public function destroy($user)
    {
        $user=$this->repo->bulkDelete([$user]);
        if (!$user ) {
            return __('app.users.cannotdelete');
        }
        return 1;
    }




}
