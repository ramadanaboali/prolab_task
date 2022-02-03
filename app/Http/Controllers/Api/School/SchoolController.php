<?php

namespace App\Http\Controllers\Api\School;

use App\Http\Controllers\Controller;

use App\Http\Repositories\Eloquent\School\SchoolRepo;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\Api\SchoolRequest;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\School\SchoolResource;
use App\Http\Resources\SearchResource;
use App\Models\School;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use File ;
use Illuminate\Support\Facades\File as FacadesFile;
class SchoolController extends Controller
{
    protected $repo;
    public function __construct(SchoolRepo $repo)
    {
        $this->repo = $repo;

    }

    public function index(PaginateRequest $request)
    {
        $input = $this->repo->inputs($request->all());
        $model = new School();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->repo->whereOptions($input, $columns);

        }
        $data = $this->repo->Paginate($input, $wheres);

        return responseSuccess([
            'data' => $input["resource"] == "all" ? SchoolResource::collection($data) : SearchResource::collection($data),
            'meta' => [
                'total' => $data->count(),
                'currentPage' => $input["offset"],
                'lastPage' => $input["paginate"] != "false" ? $data->lastPage() : 1,
            ],
        ], 'data returned successfully');
    }

    public function get($School)
    {
        $data = $this->repo->findOrFail($School);

        return responseSuccess([
            'data' => new SchoolResource($data),
        ], 'data returned successfully');
    }



    public function store(SchoolRequest $request)
    {
       

         $data = $this->repo->create($request->all());


        if ($data) {
            return responseSuccess(new SchoolResource($data), 'data saved successfully');
        } else {
            return responseFail('something went wrong');
        }

    }

    public function update($School, SchoolRequest $request)
    {
       
        $School = $this->repo->findOrFail($School);
        $input = [
            'name' => $request->name ??  $School->name,
            'status' => $request->status ??  $School->status,

        ];


            //here insert images

            

            $data = $this->repo->update($input, $School);

          if ($data) {
            
            return responseSuccess(new SchoolResource($School->refresh()), 'data Updated successfully');
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
