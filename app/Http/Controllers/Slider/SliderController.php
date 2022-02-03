<?php
namespace App\Http\Controllers\Slider;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Eloquent\SliderRepo;
use App\Http\Requests\Dashboard\SliderRequest ;
use App\Models\Slider;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use File;


class SliderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $repo;



    public function __construct(SliderRepo $repo)
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
        $sliders=Slider::all();
        return view('saas.sliders.index', compact('data','sliders'));
    }

    public function create()
    {
        return view('saas.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(SliderRequest $request)
    {
      try {
            $data=[
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
                'text_en' => $request->text_en,
                'text_ar' => $request->text_ar,

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
                   $path = $file->storeAs('public/slider/images', $fileName);
                   $path = url('/storage') . '/' . str_replace('public/', '', $path);
                   $data['photo']=   $fileName;


               }
               $sliders=$this->repo->create($data);
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
    public function edit($slider)
    {
        $data=$this->repo->findOrFail($slider);
        return response()->json($data, 200);
    }





    /**
     * update a permission.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(SliderRequest $request,$id)
    {

        $item=$this->repo->findOrFail($id);
        try {
       $data=[

            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'text_en' => $request->text_en,
            'text_ar' => $request->text_ar,
        ];

            if($request->active){
                $data['active']=1;
            }else{
                $data['active']=0;
            }
            if(request()->hasFile('photo')) {
                $file = request()->file('photo');
                if ($file) {
                    File::delete('public/slider/images/' . $item->photo);

                    $fileName = time() . rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('public/slider/images', $fileName);
                    $path = url('/storage') . '/' . str_replace('public/', '', $path);
                    $data['photo'] =  $fileName;

                }
            }

               $slider=$this->repo->update($data,$item);

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
    public function destroy($slider)
    {
        $sliders=$this->repo->bulkDelete([$slider]);
        if (!$sliders ) {
            return __('app.users.cannotdelete');
        }
        return 1;
    }



}


