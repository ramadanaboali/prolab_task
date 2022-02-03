<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;

use App\Http\Repositories\Eloquent\Provider\NotificationRepo;
use App\Http\Requests\Api\ContactRequest;
use App\Http\Requests\Api\UserFavRequest;
use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Info\InfoResource;
use App\Http\Resources\Company\NotificationResource;
use App\Http\Resources\Company\PackageResource;
use App\Http\Resources\Company\UserFavoriteResource;
use App\Http\Resources\SearchResource;
use App\Models\Contact;
use App\Models\Info;
use App\Models\Notification;
use App\Models\Package;
use App\Models\UserFavorite;
use File ;
use Illuminate\Support\Facades\Schema;

class ContactController extends Controller
{


    protected $repo;

    public function __construct(NotificationRepo $repo)
    {

        $this->repo = $repo;

    }


    public function index(PaginateRequest $request)
    {
        $input = $this->repo->inputs($request->all());
        $model = new Notification();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->repo->whereOptions($input, $columns);

        }
        $data = $this->repo->Paginate($input, $wheres);

        return responseSuccess([
            'data' => $input["resource"] == "all" ? NotificationResource::collection($data) : SearchResource::collection($data),
            'meta' => [
                'total' => $data->count(),
                'currentPage' => $input["offset"],
                'lastPage' => $input["paginate"] != "false" ? $data->lastPage() : 1,
            ],
        ], 'data returned successfully');
    }


    public function contactInfo()
    {
        $info=Info::firstOrCreate(
            [],
            [
                'name_ar' => 'سمارت',
                'name_en' => 'smart_home',

            ]
        );
        return responseSuccess([
            'data' =>  new InfoResource($info),

        ], 'data returned successfully');
    }

    public function store(ContactRequest $request)
    {

        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'user_id' => auth()->user()->id,
        ];

        $data = Contact::create($input);



        if ($data) {
            return responseSuccess([], 'message sent successfully');
        } else {
            return responseFail('something went wrong');
        }

    }






}
