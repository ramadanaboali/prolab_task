<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;

use App\Http\Repositories\Eloquent\Partner\PartnerRepo;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\Api\PartnerRequest;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Partner\PartnerResource;
use App\Http\Resources\SearchResource;
use App\Models\Partner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use File ;
use Illuminate\Support\Facades\File as FacadesFile;

class PartnerController extends Controller
{
    protected $repo;

    public function __construct(PartnerRepo $repo)
    {
        $this->repo = $repo;

    }

    public function index(PaginateRequest $request)
    {
        $input = $this->repo->inputs($request->all());
        $model = new Partner();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->repo->whereOptions($input, $columns);

        }
        $data = $this->repo->Paginate($input, $wheres);

        return responseSuccess([
            'data' => $input["resource"] == "all" ? PartnerResource::collection($data) : SearchResource::collection($data),
            'meta' => [
                'total' => $data->count(),
                'currentPage' => $input["offset"],
                'lastPage' => $input["paginate"] != "false" ? $data->lastPage() : 1,
            ],
        ], 'data returned successfully');
    }

    public function get($partner)
    {
        $data = $this->repo->findOrFail($partner);

        return responseSuccess([
            'data' => new PartnerResource($data),
        ], 'data returned successfully');
    }



    public function store(PartnerRequest $request)
    {

        $input = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'photo' => $request->photo,
            'url' => $request->url,
            ];

        if ($request->hasFile('photo')) {

            $destination_path = 'public/partner/images';
            $image = $request->file('photo');
            $input['photo'] = $this->repo->storeFile($image,$destination_path);

        }

         $data = $this->repo->create($input);


        if ($data) {
            return responseSuccess(new PartnerResource($data), 'data saved successfully');
        } else {
            return responseFail('something went wrong');
        }

    }

    public function update($partner, PartnerRequest $request)
    {

        $partner = $this->repo->findOrFail($partner);
        $input = [
            'name_ar' => $request->name_ar ??  $partner->name_ar,
            'name_en' => $request->name_en ??  $partner->name_en,
            'url' => $request->url ??  $partner->url,

        ];


            //here insert images

            $file=request()->file('photo');
            if( $file)
            {
              FacadesFile::delete('public/partner/images/'.$partner->photo);

                $destination_path = 'public/partner/images';
                $image = $request->file('photo');
                $input['photo'] = $this->repo->storeFile($image,$destination_path);

            }

            $data = $this->repo->update($input, $partner);

          if ($data) {
            return responseSuccess(new PartnerResource($partner->refresh()), 'data Updated successfully');
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
