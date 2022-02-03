<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;

use App\Http\Repositories\Eloquent\Donation\DonationRepo;
use App\Http\Requests\BulkDeleteRequest;
use App\Http\Requests\Api\DonationRequest;

use App\Http\Requests\PaginateRequest;
use App\Http\Resources\Donation\DonationResource;
use App\Http\Resources\SearchResource;
use App\Http\Resources\UserResource;
use App\Models\DeliveryRequest;
use App\Models\Donation;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use stdClass;

class HomeController extends Controller
{
    protected $repo;

    public function __construct(DonationRepo $repo)
    {
        $this->repo = $repo;

    }

    public function index(Request $request)
    {
        $user_id=auth()->user()->id;
        $alldonations=Donation::count();
        $donor=User::where("type","donor")->count();
        $branch=User::where("type","branch")->count();
        $charity=User::where("type","charity")->count();
        $volunteer=User::where("type","volunteer")->count();
        $pending_requests=DeliveryRequest::where("delivery_requests.status","pending")->join('donations','donations.id','=','delivery_requests.donation_id')->where('donations.user_id',auth()->user()->id)->count();
        $pending_requests_details=DeliveryRequest::with('charity')->with(['donation' => function ($query) use($user_id)
        {
            $query->where('user_id', $user_id);

        }])->where("delivery_requests.status","pending")->get();
        $pending=[];
        foreach($pending_requests_details as $pending_requests_detail){
            if($pending_requests_detail->donation){
                $pending[]=$pending_requests_detail;
            }
        }

        $completed_requests=DeliveryRequest::where("status","accepted")->count();
        $all_requests=DeliveryRequest::count();

        $bestdonor=DB::table('donations')
        ->join('users','users.id','=','donations.user_id')
        ->select('donations.user_id as user',DB::raw('count(*) as donors'))
        ->where('donations.status', 'completed')
        ->groupBy('donations.user_id')
        ->orderBy('donors','desc')
        ->first();
        if($bestdonor){
            $bestdonor->user=new UserResource(User::find($bestdonor->user));
        }else{
            $bestdonor=new stdClass;
            $bestdonor->user=new UserResource(User::where('type','donor')->first());
        }

        $bestcharity=DB::table('delivery_requests')
        ->join('users','users.id','=','delivery_requests.charity_id')
        ->select('delivery_requests.charity_id as charity',DB::raw('count(*) as requests'))
        ->where('delivery_requests.status', 'accepted')
        ->where('users.type', 'charity')
        ->groupBy('delivery_requests.charity_id')
        ->orderBy('requests','desc')
        ->first();
        if($bestcharity){
            $bestcharity->charity=new UserResource(User::find($bestcharity->charity));
        }else{
            $bestcharity=new stdClass;
            $bestcharity->charity=new UserResource(User::where('type','charity')->first());
        }
        $bestvolunteer=DB::table('delivery_requests')
        ->join('users','users.id','=','delivery_requests.charity_id')
        ->select('delivery_requests.charity_id as charity',DB::raw('count(*) as requests'))
        ->where('delivery_requests.status', 'accepted')
        ->where('users.type', 'volunteer')
        ->groupBy('delivery_requests.charity_id')
        ->orderBy('requests','desc')
        ->first();
        if($bestvolunteer){
            $bestvolunteer->charity=new UserResource(User::find($bestvolunteer->charity));
        }else{
            $bestvolunteer=new stdClass;
            $bestvolunteer->charity=new UserResource(User::where('type','volunteer')->first());
        }
        $data=array(
            'donors'=>$donor,
            'alldonations'=>$alldonations,
            'branchs'=>$branch,
            'charitys'=>$charity,
            'volunteers'=>$volunteer,
            'completed_requests'=>$completed_requests,
            'all_requests'=>$all_requests,
            'bestdonors'=>!empty($bestdonor)?$bestdonor:0,
            'bestcharitys'=>!empty($bestcharity)?$bestcharity:0,
            'bestvolunteer'=>!empty($bestvolunteer)?$bestvolunteer:0,
            'pending_requests'=>$pending_requests,
            'pending_requests_details'=>$pending,
        );

        return responseSuccess($data, 'data saved successfully');
    }

    public function allCharity(){
        $data=[];
        $charities=User::where('type','charity')->where('active',1)->get();
        foreach($charities as $charity){
            $obj=new stdClass();
            $obj->id=$charity->id;
            $obj->naem=$charity->name;
            $data[]=$obj;
        }
        return responseSuccess($data, 'data saved successfully');
    }

}

