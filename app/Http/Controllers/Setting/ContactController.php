<?php
namespace App\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\Notification\NotificationRepo;
use App\Http\Repositories\Eloquent\Provider\ServiceRepo;
use App\Http\Requests\Dashboard\ServiceRequest ;
use App\Http\Requests\SettingRequest;
use App\Models\Contact;
use App\Models\Info;
use App\Models\Provider;
use App\Models\Notification;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use File;
use Illuminate\Support\Facades\File as FacadesFile;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $repo;

    public function __construct(NotificationRepo $repo)
    {

        $this->repo = $repo;

    }




    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $info=Info::firstOrCreate(
            [],
            [
                'name_ar' => 'سمارت',
                'name_en' => 'smart_home',
            ]
        );
        return view('settings.infos.index', compact('info'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(SettingRequest $request)
    {
        $item=Info::first();
        try {
            $data=[

                'name_ar' => $request->name_ar,
                'phone' => $request->phone,
                'email' => $request->email,
                'email_message' => $request->email_message,
                'phone_message' => $request->phone_message,
                'name_en' => $request->name_en,
                'appStore_link' => $request->appStore_link,
                'googlePlay_link' => $request->googlePlay_link,

            ];

            if(request()->hasFile('logo')) {
                $file = request()->file('logo');
                if ($file) {
                    FacadesFile::delete('public/infos/images/' . $item->logo);

                    $fileName = time() . rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('public/infos/images', $fileName);
                    $path = url('/storage') . '/' . str_replace('public/', '', $path);
                    $data['logo'] =  $fileName;


                }
            }

            $item->update($data);

            return redirect()->back()
                ->with('success',__('app.success_message'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error',__('app.some_thing_error'));
        }


    }


    public function contacts()
    {
        $data=Contact::get();

        return view('settings.infos.contact', compact('data'));
    }
    public function notifications()
    {
        $data=$this->repo->getAll();

        return view('settings.infos.notifications', compact('data'));
    }



}
