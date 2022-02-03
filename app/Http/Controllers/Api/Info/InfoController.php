<?php

namespace App\Http\Controllers\Api\Info;

use App\Http\Controllers\Controller;

use App\Http\Repositories\Eloquent\Info\InfoRepo;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\Api\InfoRequest;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Info\InfoResource;
use App\Http\Resources\SearchResource;
use App\Models\Info;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

class InfoController extends Controller
{
    protected $repo;

    public function __construct(InfoRepo $repo)
    {
        $this->repo = $repo;

    }

    public function index(PaginateRequest $request)
    {
        $input = $this->repo->inputs($request->all());
        $model = new Info();
        $columns = Schema::getColumnListing($model->getTable());

        if (count($input["columns"]) < 1 || (count($input["columns"]) != count($input["column_values"])) || (count($input["columns"]) != count($input["operand"]))) {
            $wheres = [];
        } else {
            $wheres = $this->repo->whereOptions($input, $columns);

        }
        $data = $this->repo->Paginate($input, $wheres);

        return responseSuccess([
            'data' => $input["resource"] == "all" ? InfoResource::collection($data) : SearchResource::collection($data),
            'meta' => [
                'total' => $data->count(),
                'currentPage' => $input["offset"],
                'lastPage' => $input["paginate"] != "false" ? $data->lastPage() : 1,
            ],
        ], 'data returned successfully');
    }

    public function get($Info)
    {
        $data = $this->repo->findOrFail($Info);

        return responseSuccess([
            'data' => new InfoResource($data),
        ], 'data returned successfully');
    }



    public function store(InfoRequest $request)
    {

        $input = [
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'main_color' => $request->main_color,
            'secondary_color' => $request->secondary_color,
            'appStore_link' => $request->appStore_link,
            'googlePlay_link' => $request->googlePlay_link,
            'phone' => $request->phone,
            'bio' => $request->bio,
            'icon' => $request->icon,
            'fb_link' => $request->fb_link,
            'tw_link' => $request->tw_link,
            'in_link' => $request->in_link,
            'insta_link' => $request->insta_link,
            'website_link' => $request->website_link,
            'address' => $request->address,
            'email' => $request->email,
            'phone_message' => $request->phone_message,
            'email_message' => $request->email_message,
            'main_font_color' => $request->main_font_color,
            'secondary_font_color' => $request->secondary_font_color,
            'app_version' => $request->app_version,
        ];


        if ($request->hasFile('logo_en')) {
            $destination_path = 'public/info/images';
            $image = $request->file('logo_en');
            $input['logo_en'] = $this->repo->storeFile($image,$destination_path);
        }
        if ($request->hasFile('logo_ar')) {
            $destination_path = 'public/info/images';
            $image = $request->file('logo_ar');
            $input['logo_ar'] = $this->repo->storeFile($image,$destination_path);
        }


        if ($request->hasFile('icon')) {
            $destination_path = 'public/info/images';
            $image = $request->file('icon');
            $input['icon'] = $this->repo->storeFile($image,$destination_path);
        }



         $data = $this->repo->create($input);


        if ($data) {
            return responseSuccess(new InfoResource($data), 'data saved successfully');
        } else {
            return responseFail('something went wrong');
        }

    }

    public function update($Info, InfoRequest $request)
    {

        $Info = $this->repo->findOrFail($Info);
        $input = [
            'name_ar' => $request->name_ar ??  $Info->name_ar,
            'name_en' => $request->name_en ??  $Info->name_en,
            'main_color' => $request->main_color ??  $Info->main_color,
            'secondary_color' => $request->secondary_color ??  $Info->secondary_color,
            'appStore_link' => $request->appStore_link ??  $Info->appStore_link,
            'googlePlay_link' => $request->googlePlay_link ??  $Info->googlePlay_link,
            'phone' => $request->phone ??  $Info->phone,
            'bio' => $request->bio ??  $Info->bio,
            'icon' => $request->icon ??  $Info->icon,
            'fb_link' => $request->fb_link ??  $Info->fb_link,
            'tw_link' => $request->tw_link ??  $Info->tw_link,
            'in_link' => $request->in_link ??  $Info->in_link,
            'insta_link' => $request->insta_link ??  $Info->insta_link,
            'website_link' => $request->website_link ??  $Info->website_link,
            'address' => $request->address ??  $Info->address,
            'email' => $request->email ??  $Info->email,
            'phone_message' => $request->phone_message ??  $Info->phone_message,
            'email_message' => $request->email_message ??  $Info->email_message,
        ];


            //here insert images

            if ($request->hasFile('logo_en')) {
                File::delete('public/info/images'.$Info->logo_en);
                $destination_path = 'public/info/images';
                $image = $request->file('logo_en');
                $input['logo_en'] = $this->repo->storeFile($image,$destination_path);
            }
            if ($request->hasFile('logo_ar')) {
                File::delete('public/info/images'.$Info->logo_ar);
                $destination_path = 'public/info/images';
                $image = $request->file('logo_ar');
                $input['logo_ar'] = $this->repo->storeFile($image,$destination_path);
            }


            if ($request->hasFile('icon')) {
                File::delete('public/info/images'.$Info->icon);
                $destination_path = 'public/info/images';
                $image = $request->file('icon');
                $input['icon'] = $this->repo->storeFile($image,$destination_path);
            }

            $data = $this->repo->update($input, $Info);

          if ($data) {
            return responseSuccess(new InfoResource($Info->refresh()), 'data Updated successfully');
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
