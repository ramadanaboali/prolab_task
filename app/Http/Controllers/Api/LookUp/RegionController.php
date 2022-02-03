<?php

namespace App\Http\Controllers\Api\LookUp;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\RegionRepo;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\Api\ProviderRequest;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Company\ProviderResource;
use App\Http\Resources\RegionResource;
use App\Http\Resources\JobRequest\SearchResource;
use App\Http\Resources\LookUps\RegionResource as LookUpsRegionResource;
use App\Http\Resources\SearchResource as ResourcesSearchResource;
use App\Models\Region;
use App\Models\Provider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use File ;

class RegionController extends Controller
{
    protected $repo;

    public function __construct(RegionRepo $repo)
    {
        $this->repo = $repo;

    }

    public function index(PaginateRequest $request)
    {
        $input = $this->repo->inputs($request->all());
        $model = new Region();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->repo->whereOptions($input, $columns);

        }
        $data = $this->repo->Paginate($input, $wheres);

        return responseSuccess([
            'data' => $input["resource"] == "all" ? LookUpsRegionResource::collection($data) : ResourcesSearchResource::collection($data),
            'meta' => [
                'total' => $data->count(),
                'currentPage' => $input["offset"],
                'lastPage' => $input["paginate"] != "false" ? $data->lastPage() : 1,
            ],
        ], 'data returned successfully');
    }


}
