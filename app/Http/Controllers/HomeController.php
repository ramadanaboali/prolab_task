<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\DeliveryRequest;
use App\Models\Donation;
use App\Models\Package;
use App\Models\Provider;
use App\Models\Service;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\Models;
use App\Models\UserModel;
use App\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session as FacadesSession;
use stdClass;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }
    public function dashboard(){
//        $donor=User::where("type","donor")->count();
//        $branch=User::where("type","branch")->count();
//        $charity=User::where("type","charity")->count();
//        $volunteer=User::where("type","volunteer")->count();
//        $pending_requests=DeliveryRequest::where("status","pending")->count();
//        $completed_requests=DeliveryRequest::where("status","accepted")->count();
//        $all_requests=DeliveryRequest::count();
//
//        $bestdonor=DB::table('donations')
//        ->join('users','users.id','=','donations.user_id')
//        ->select('donations.user_id as user',DB::raw('count(*) as donors'))
//        ->where('donations.status', 'completed')
//        ->groupBy('donations.user_id')
//        ->orderBy('donors','desc')
//        ->first();
//        if($bestdonor){
//            $bestdonor->user=new UserResource(User::find($bestdonor->user));
//        }else{
//            $bestdonor=new stdClass;
//            $bestdonor->user=new UserResource(User::where('type','donor')->first());
//        }
//
//        $bestcharity=DB::table('delivery_requests')
//        ->join('users','users.id','=','delivery_requests.charity_id')
//        ->select('delivery_requests.charity_id as charity',DB::raw('count(*) as requests'))
//        ->where('delivery_requests.status', 'accepted')
//        ->where('users.type', 'charity')
//        ->groupBy('delivery_requests.charity_id')
//        ->orderBy('requests','desc')
//        ->first();
//        if($bestcharity){
//            $bestcharity->charity=new UserResource(User::find($bestcharity->charity));
//        }else{
//            $bestcharity=new stdClass;
//            $bestcharity->charity=new UserResource(User::where('type','charity')->first());
//        }
//        $bestvolunteer=DB::table('delivery_requests')
//        ->join('users','users.id','=','delivery_requests.charity_id')
//        ->select('delivery_requests.charity_id as charity',DB::raw('count(*) as requests'))
//        ->where('delivery_requests.status', 'accepted')
//        ->where('users.type', 'volunteer')
//        ->groupBy('delivery_requests.charity_id')
//        ->orderBy('requests','desc')
//        ->first();
//        if($bestvolunteer){
//            $bestvolunteer->charity=new UserResource(User::find($bestvolunteer->charity));
//        }else{
//            $bestvolunteer=new stdClass;
//            $bestvolunteer->charity=new UserResource(User::where('type','volunteer')->first());
//        }

//        return view('home',compact('completed_requests','all_requests','bestdonor','bestcharity','bestvolunteer','charity','volunteer','donor','branch','pending_requests'));
        return view('home');
    }
    public function dashboard2()
    {

        $donor=User::where("type","donor")->count();
        $branch=User::where("type","branch")->count();
        $charity=User::where("type","charity")->count();
        $volunteer=User::where("type","volunteer")->count();
        $pending_requests=DeliveryRequest::where("status","pending")->count();
        $completed_requests=DeliveryRequest::where("status","accepted")->count();
        $all_requests=DeliveryRequest::count();
        $bestdonor_data=null;
        $bestcharity_data=null;
        $bestvolunteer_data=null;


        $bestdonor=DB::table('donations')
        ->join('users','users.id','=','donations.user_id')
        ->select('donations.user_id',DB::raw('count(*) as total'))
             ->where('donations.status', 'completed')
             ->groupBy('donations.user_id')
             ->orderBy('total','desc')
             ->first();
                if($bestdonor){
                    $bestdonor_data=User::find($bestdonor->user_id);
                }
        $bestcharity=DB::table('delivery_requests')
        ->join('users','users.id','=','delivery_requests.charity_id')
        ->select('delivery_requests.charity_id',DB::raw('count(*) as total'))
             ->where('delivery_requests.status', 'accepted')
             ->where('users.type', 'charity')
             ->groupBy('delivery_requests.charity_id')
             ->orderBy('total','desc')
             ->first();
                if($bestcharity){
                    $bestcharity_data=User::find($bestcharity->charity_id);
                }
        $bestvolunteer=DB::table('delivery_requests')
        ->join('users','users.id','=','delivery_requests.charity_id')
        ->select('delivery_requests.charity_id',DB::raw('count(*) as total'))
             ->where('delivery_requests.status', 'accepted')
             ->where('users.type', 'volunteer')
             ->groupBy('delivery_requests.charity_id')
             ->orderBy('total','desc')
             ->first();
                if($bestvolunteer){
                    $bestvolunteer_data=User::find($bestvolunteer->charity_id);
                }

            return view('home',compact('donor','branch','charity','volunteer','completed_requests','pending_requests','all_requests','bestdonor','bestdonor_data','bestcharity','bestcharity_data','bestvolunteer_data','bestvolunteer'));

    }

    public function select($lang)
    {
        if (!in_array($lang, ['en', 'ar'])) {
            abort(400);
        }
        FacadesSession::put('lang', $lang);
        App::setLocale(FacadesSession::get('lang', 'en'));
        return Redirect::back();
    }
    public function dark($code)
    {
        if (!in_array($code, ['on', 'off'])) {
            abort(400);
        }
        if($code=='on'){
            FacadesSession::put('darkMode', $code);
        }else{
            FacadesSession::forget('darkMode');
        }

        return Redirect::back();
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      return view('index');
    }
}
