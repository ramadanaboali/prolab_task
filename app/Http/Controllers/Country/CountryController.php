<?php
namespace App\Http\Controllers\Country;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\CountryRepo;
use App\Http\Requests\Dashboard\CountryRequest ;
use App\Models\Country;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use File;
use Illuminate\Support\Facades\File as FacadesFile;

class CountryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $repo;



    public function __construct(CountryRepo $repo)
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
       $data=$this->repo->getAll();
        $countries=Country::all();
        return view('saas.countries.index', compact('data','countries'));
    }


    public function create()
    {
        return view('saas.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(CountryRequest $request)
    {
       try {
                $data=[

                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en,

                ];
                if($request->active){
                    $data['active']=true;
                }else{
                    $data['active']=false;
                }
               $countries=$this->repo->create($data);
            return redirect()->back()
                ->with('success',__('app.success_message'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error',__('app.some_thing_error'));
        }
    }

    /**
     * update the Permission for dashboard.
     *
     * @param Request $request
     * @return Builder|Model|object
     */
    public function edit($Country)
    {
        $data=$this->repo->findOrFail($Country);
        return response()->json($data, 200);
    }





    /**
     * update a permission.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(CountryRequest $request,$id)
    {

        $item=$this->repo->findOrFail($id);
       try {
       $data=[

            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,

        ];
        if($request->active){
            $data['active']=true;
        }else{
            $data['active']=false;
        }

               $Country=$this->repo->update($data,$item);

            return redirect()->back()
                ->with('success',__('app.success_message'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error',__('app.some_thing_error'));
        }


    }


    /**
     * Delete more than one permission.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy($Country)
    {
        $countries=$this->repo->bulkDelete([$Country]);
        if (!$countries ) {
            return __('app.users.cannotdelete');
        }
        return 1;
    }



}
