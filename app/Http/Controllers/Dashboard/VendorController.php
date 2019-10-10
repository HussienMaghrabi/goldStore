<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Admin;
use App\Models\Category;
use App\Models\City;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Validator;
use Auth;

class VendorController extends Controller
{
    private $resources = 'vendors';
    private $resource = [
        'route' => 'admin.vendors',
        'view' => "vendors",
        'icon' => "server",
        'title' => "VENDORS",
        'action' => "",
        'header' => "Vendors"
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Vendor::orderBy('id', 'DESC')->paginate(10);
        $resource = $this->resource;
        return view('dashboard.views.'.$this->resources.'.index',compact('data', 'resource'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resource = $this->resource;
        $resource['action'] = 'Create';
        $city = City::pluck('name_'.App::getLocale(), 'id')->all();
        $categories = Category::pluck('name_'.App::getLocale(), 'id')->all();
        return view('dashboard.views.'.$this->resources.'.create',compact( 'resource', 'city', 'categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $lang)
    {
        $rules =  [

            'name_ar' => 'required',
            'name_en' => 'required',
            'email' => 'required',
            'city_id'=> 'required',
            'password' => 'required|min:6',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }

        Vendor::create($request->all());
        App::setLocale($lang);
        flashy(__('dashboard.created'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function show($lang, $id)
    {

        $data = Product::where('vendor_id',$id)
            ->paginate(10);
        $resource = $this->resource;
        $resource['action'] = 'Show';
        return view('dashboard.views.'.$this->resources.'.show',compact('data', 'resource'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $id)
    {

        Vendor::findOrFail($id)->delete();

        App::setLocale($lang);
        flashy(__('dashboard.deleted'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }
    public function multiDelete($lang)
    {
        foreach (\request('checked') as $id)
        {
            Vendor::findOrFail($id)->delete();

        }
        App::setLocale($lang);
        flashy(__('dashboard.deleted'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }
    public function  search (Request $request, $lang)
    {
        $resource = $this->resource;//
        $data = vendor::select(
            'vendors.name_ar',
            'vendors.name_en',
            'vendors.email',
            'vendors.category_id',
            'vendors.city_id',
            'vendors.category_id'
        )
            ->join('categories', 'categories.id', '=', 'vendors.category_id')
            ->join('cities', 'cities.id', '=', 'vendors.city_id')
            ->Where('categories.name_en', 'LIKE', '%'.$request->text.'%')
            ->orWhere('categories.name_ar', 'LIKE', '%'.$request->text.'%')
            ->orWhere('cities.name_ar', 'LIKE', '%'.$request->text.'%')
            ->orWhere('cities.name_en', 'LIKE', '%'.$request->text.'%')
            ->orWhere('vendors.name_ar', 'LIKE', '%'.$request->text.'%')
            ->orWhere('vendors.name_en', 'LIKE', '%'.$request->text.'%')
            ->orWhere('vendors.email', 'LIKE', '%'.$request->text.'%')
            ->paginate(10);


        App::setLocale($lang);
        return view('dashboard.views.' .$this->resources. '.index', compact('data', 'resource'));
    }

   }
