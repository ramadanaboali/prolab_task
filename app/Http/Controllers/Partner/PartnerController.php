<?php
namespace App\Http\Controllers\Partner;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\Partner\PartnerRepo;
use App\Http\Requests\Dashboard\PartnerRequest ;
use App\Models\Partner;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use File;
use Illuminate\Support\Facades\File as FacadesFile;

class PartnerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $repo;



    public function __construct(PartnerRepo $repo)
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
        $partners=Partner::all();
        return view('saas.partners.index', compact('data','partners'));
    }

    public function create()
    {
        return view('saas.partners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(PartnerRequest $request)
    {
       try {
                $data=[

                    'name_ar' => $request->name_ar,
                    'name_en' => $request->name_en,
                    'url' => $request->url,
                ];
                if($request->active){
                    $data['active']=1;
                }else{
                    $data['active']=0;
                }
               $file=request()->file('photo');
               if($file)
               {
                   $fileName = time() . rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
                   $path = $file->storeAs('public/partner/images', $fileName);
                   $path = url('/storage') . '/' . str_replace('public/', '', $path);
                   $data['photo']=   $fileName;
               }
               $partners=$this->repo->create($data);
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
    public function edit($partner)
    {
        $data=$this->repo->findOrFail($partner);
        return response()->json($data, 200);
    }





    /**
     * update a permission.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(PartnerRequest $request,$id)
    {

        $item=$this->repo->findOrFail($id);
       try {
       $data=[

            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'url' => $request->url,
        ];
        if($request->active){
            $data['active']=1;
        }else{
            $data['active']=0;
        }
            if(request()->hasFile('photo')) {
                $file = request()->file('photo');
                if ($file) {
                    FacadesFile::delete('public/partner/images/' . $item->photo);

                    $fileName = time() . rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('public/partner/images', $fileName);
                    $path = url('/storage') . '/' . str_replace('public/', '', $path);
                    $data['photo'] =  $fileName;


                }
            }

               $partner=$this->repo->update($data,$item);

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
    public function destroy($partner)
    {
        $partners=$this->repo->bulkDelete([$partner]);
        if (!$partners ) {
            return __('app.users.cannotdelete');
        }
        return 1;
    }



}
