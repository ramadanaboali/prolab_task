<?php

namespace App\Http\Controllers\Api\LookUp;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\StateRepo;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\Api\ProviderRequest;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Company\ProviderResource;
use App\Http\Resources\LookUps\StateResource as LookUpsStateResource;
use App\Http\Resources\StateResource;

use App\Http\Resources\SearchResource;
use App\Models\State;
use App\Models\Provider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use File ;

class StateController extends Controller
{
    protected $repo;

    public function __construct(StateRepo $repo)
    {
        $this->repo = $repo;

    }

    public function index(PaginateRequest $request)
    {
        $input = $this->repo->inputs($request->all());
        $model = new State();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->repo->whereOptions($input, $columns);

        }
        $data = $this->repo->Paginate($input, $wheres);

        return responseSuccess([
            'data' => $input["resource"] == "all" ? LookUpsStateResource::collection($data) : SearchResource::collection($data),
            'meta' => [
                'total' => $data->count(),
                'currentPage' => $input["offset"],
                'lastPage' => $input["paginate"] != "false" ? $data->lastPage() : 1,
            ],
        ], 'data returned successfully');
    }


}
