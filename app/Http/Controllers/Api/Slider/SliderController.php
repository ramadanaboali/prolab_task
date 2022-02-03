<?php

namespace App\Http\Controllers\Api\Slider;

use App\Http\Controllers\Controller;

use App\Http\Repositories\Eloquent\Slider\SliderRepo;
use App\Http\Repositories\Eloquent\SliderRepo as EloquentSliderRepo;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\Api\SliderRequest;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Slider\SliderResource;
use App\Http\Resources\SearchResource;
use App\Models\Slider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use File ;

class SliderController extends Controller
{
    protected $repo;

    public function __construct(EloquentSliderRepo $repo)
    {
        $this->repo = $repo;

    }

    public function index(PaginateRequest $request)
    {
        $input = $this->repo->inputs($request->all());
        $model = new Slider();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->repo->whereOptions($input, $columns);

        }
        $data = $this->repo->Paginate($input, $wheres);

        return responseSuccess([
            'data' => $input["resource"] == "all" ? SliderResource::collection($data) : SearchResource::collection($data),
            'meta' => [
                'total' => $data->count(),
                'currentPage' => $input["offset"],
                'lastPage' => $input["paginate"] != "false" ? $data->lastPage() : 1,
            ],
        ], 'data returned successfully');
    }


}
