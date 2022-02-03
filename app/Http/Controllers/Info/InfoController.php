<?php

namespace App\Http\Controllers\Info;

use App\Http\Controllers\Controller;

use App\Http\Repositories\Eloquent\Info\InfoRepo;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\Dashboard\InfoRequest;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Info\InfoResource;
use App\Http\Resources\SearchResource;
use App\Models\Info;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use File ;

class InfoController extends Controller
{
    protected $repo;

    public function __construct(InfoRepo $repo)
    {
        $this->repo = $repo;

    }

    public function index()
    {
        return view('settings.website.index');
    }

    public function get($info)
    {
        $data = $this->repo->findOrFail($info);

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
            'bio_en' => $request->bio_en,
            'bio_ar' => $request->bio_ar,
            'privacy_en' => $request->privacy_en,
            'privacy_ar' => $request->privacy_ar,
            'agreement_en' => $request->agreement_en,
            'agreement_ar' => $request->agreement_ar,
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

    public function update($info, InfoRequest $request)
    {
       try{
              $info = $this->repo->findOrFail($info);
        $input = [
            'name_ar' => $request->name_ar ??  $info->name_ar,
            'name_en' => $request->name_en ??  $info->name_en,
            'main_color' => $request->main_color ??  $info->main_color,
            'secondary_color' => $request->secondary_color ??  $info->secondary_color,
            'appStore_link' => $request->appStore_link ??  $info->appStore_link,
            'googlePlay_link' => $request->googlePlay_link ??  $info->googlePlay_link,
            'phone' => $request->phone ??  $info->phone,
            'bio_ar' => $request->bio_ar ??  $info->bio_ar,
            'bio_en' => $request->bio_en ??  $info->bio_en,
            'privacy_en' => $request->privacy_en ??  $info->privacy_en,
            'privacy_ar' => $request->privacy_ar ??  $info->privacy_ar,
            'agreement_en' => $request->agreement_en ??  $info->agreement_en,
            'agreement_ar' => $request->agreement_ar ??  $info->agreement_ar,
            'icon' => $request->icon ??  $info->icon,
            'fb_link' => $request->fb_link ??  $info->fb_link,
            'tw_link' => $request->tw_link ??  $info->tw_link,
            'in_link' => $request->in_link ??  $info->in_link,
            'insta_link' => $request->insta_link ??  $info->insta_link,
            'website_link' => $request->website_link ??  $info->website_link,
            'address' => $request->address ??  $info->address,
            'email' => $request->email ??  $info->email,
            'phone_message' => $request->phone_message ??  $info->phone_message,
            'email_message' => $request->email_message ??  $info->email_message,
            'main_font_color' => $request->main_font_color ??  $info->main_font_color,
            'secondary_font_color' => $request->secondary_font_color ??  $info->secondary_font_color,
            'app_version' => $request->app_version ??  $info->app_version,
        ];

        ;            //here insert images

        if ($request->hasFile('logo_en')) {
            File::delete('public/info/images'.$info->logo_en);
            $destination_path = 'public/info/images';
            $image = $request->file('logo_en');

            $input['logo_en'] = $this->repo->storeFile($image,$destination_path);
        }


        if ($request->hasFile('logo_ar')) {
            File::delete('public/info/images'.$info->logo_ar);
            $destination_path = 'public/info/images';
            $image = $request->file('logo_ar');
            $input['logo_ar'] = $this->repo->storeFile($image,$destination_path);
        }


        if ($request->hasFile('icon')) {
            File::delete('public/info/images'.$info->icon);
            $destination_path = 'public/info/images';
            $image = $request->file('icon');
            $input['icon'] = $this->repo->storeFile($image,$destination_path);
        }

        $data = $this->repo->update($input, $info);
        if ($data) {
            return redirect()->back()
            ->with('success',__('app.success_message'));
        }
    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()
            ->with('error',__('app.some_thing_error'));
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
