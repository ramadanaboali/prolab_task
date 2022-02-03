<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;

use App\Http\Repositories\Eloquent\Student\StudentRepo;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\Api\StudentRequest;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Student\StudentResource;
use App\Http\Resources\SearchResource;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use File ;
use Illuminate\Support\Facades\File as FacadesFile;
class StudentController extends Controller
{
    protected $repo;
    public function __construct(StudentRepo $repo)
    {
        $this->repo = $repo;

    }

    public function index(PaginateRequest $request)
    {
        $input = $this->repo->inputs($request->all());
        $model = new Student();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->repo->whereOptions($input, $columns);

        }
        $data = $this->repo->Paginate($input, $wheres);

        return responseSuccess([
            'data' => $input["resource"] == "all" ? StudentResource::collection($data) : SearchResource::collection($data),
            'meta' => [
                'total' => $data->count(),
                'currentPage' => $input["offset"],
                'lastPage' => $input["paginate"] != "false" ? $data->lastPage() : 1,
            ],
        ], 'data returned successfully');
    }

    public function get($Student)
    {
        $data = $this->repo->findOrFail($Student);

        return responseSuccess([
            'data' => new StudentResource($data),
        ], 'data returned successfully');
    }



    public function store(StudentRequest $request)
    {
       

         $data = $this->repo->create($request->all());


        if ($data) {
            return responseSuccess(new StudentResource($data), 'data saved successfully');
        } else {
            return responseFail('something went wrong');
        }

    }

    public function update($Student, StudentRequest $request)
    {
       
        $Student = $this->repo->findOrFail($Student);
        $input = [
            'name' => $request->name ??  $Student->name,
            'order' => $request->order ??  $Student->order,
            'school_id' => $request->school_id ??  $Student->school_id,
            'status' => $request->status ??  $Student->status,

        ];


            //here insert images

            

            $data = $this->repo->update($input, $Student);

          if ($data) {
            
            return responseSuccess(new StudentResource($Student->refresh()), 'data Updated successfully');
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
