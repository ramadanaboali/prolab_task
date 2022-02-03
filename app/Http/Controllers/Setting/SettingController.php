<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-settings|edit-settings|delete-settings|create-settings', ['only' => ['index', 'settingSave']]);
        $this->middleware('permission:create-settings', ['only' => ['store']]);
        $this->middleware('permission:edit-settings', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-settings', ['only' => ['destroy', 'delete_all']]);
    }

    public function index()
    {

        return view('settings.website.index');
    }

    public function settingSave(Request $request)
    {
        if (setting()) {
            $logoPath = setting()->logo;
            $iconPath = setting()->icon;
        }

        // check if user upload icon
        if ($request->hasFile('icon')) {
            if (setting()->icon)
                unlink('media/settings/' . setting()->icon); // unlink old icon
            $iconPath = uploadImage('media', $request->icon, 'settings');

        }
        // chick if user upload logo
        if ($request->hasFile('logo')) {
            if (setting()->logo)
                unlink('media/settings/' . setting()->logo); // unlink old logo
            $logoPath = uploadImage('media', $request->logo, 'settings');
        }

        //  Create new setting element if not exist else update it
        Setting::updateOrCreate(
            [
                'primary_id' => primaryID()
            ],
            [
                'name' => $request->name,
                'email' => $request->email,
                'whats_num' => $request->whats_num,
                'contact_phone' => $request->contact_phone,
                'country' => $request->country,
                'fb_link' => $request->fb_link,
                'address' => $request->address,
                'tw_link' => $request->tw_link,
                'in_link' => $request->in_link,
                'insta_link' => $request->insta_link,
                'website_link' => $request->website_link,
                'appStore_link' => $request->appStore_link,
                'googlePlay_link' => $request->googlePlay_link,
                'lang_id' => $request->lang_id,
                'icon' => $iconPath,
                'logo' => $logoPath,
                'user_id' => auth()->id()
            ]);

        session()->put('success', __('app.settings.success_message'));
        return response()->json(['message' => __('app.settings.success_message')], '200');
    }


}
