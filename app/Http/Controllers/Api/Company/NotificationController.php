<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\Notification\NotificationRepo ;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\Api\NotificationRequest;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Company\NotificationResource;
use App\Http\Resources\SearchResource;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use File ;

class NotificationController extends Controller
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


    public function store(NotificationRequest $request)
    {

        $input = [
            'type' => $request->type,
            'message' => $request->message,
            'sender_id' => $request->sender_id,
            'user_id' => $request->user_id,
        ];



         $data = $this->repo->create($input);


        if ($data) {
            return responseSuccess(new NotificationResource($data), 'data saved successfully');
        } else {
            return responseFail('something went wrong');
        }

    }



}
