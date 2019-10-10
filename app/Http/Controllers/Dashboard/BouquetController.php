<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Bouquet;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Validator;
use Auth;

class BouquetController extends Controller
{
    private $resources = 'bouquets';
    private $resource = [
        'route' => 'admin.bouquets',
        'view' => "bouquets",
        'icon' => "shopping-cart",
        'title' => "BOUQUETS",
        'action' => "",
        'header' => "Bouquets"
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($lang)
    {
        $data = Bouquet::orderBy('id')->paginate(10);
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
        return view('dashboard.views.'.$this->resources.'.create',compact( 'resource'));

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
            'name'      => 'required',
            'desc'      => 'required',
            'normal'    => 'required',
            'pinned'    => 'required',
            'video'     => 'required',
            'price'     => 'required',

        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }

        $inputs = $request->all();

        Bouquet::create($inputs);
        App::setLocale($lang);
        flashy(__('dashboard.created'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, $id)
    {
        $resource = $this->resource;
        $resource['action'] = 'Edit';
        $item = Bouquet::findOrFail($id);
        return view('dashboard.views.' .$this->resources. '.edit', compact('item', 'resource'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lang, $id)
    {
        $rules =  [
            'name'      => 'required',
            'desc'      => 'required',
            'normal'    => 'required',
            'pinned'    => 'required',
            'video'     => 'required',
            'price'     => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }

        $inputs = $request->all();
        Bouquet::find($id)->update($inputs);

        App::setLocale($lang);
        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $id)
    {
        Bouquet::findOrFail($id)->delete();
        App::setLocale($lang);

        flashy(__('dashboard.deleted'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function multiDelete($lang)
    {


        foreach (\request('checked') as $id)
        {
            Bouquet::findOrFail($id)->delete();
        }

        App::setLocale($lang);

        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function search(Request $request, $lang)
    {
        $resource = $this->resource;
        $data = Bouquet::where('name', 'LIKE', '%'.$request->text.'%')
            ->orWhere('desc', 'LIKE', '%'.$request->text.'%')
            ->orWhere('normal', 'LIKE', '%'.$request->text.'%')
            ->orWhere('pinned', 'LIKE', '%'.$request->text.'%')
            ->orWhere('video', 'LIKE', '%'.$request->text.'%')
            ->orWhere('price', 'LIKE', '%'.$request->text.'%')
            ->paginate(10);
        App::setLocale($lang);
        return view('dashboard.views.' .$this->resources. '.index', compact('data', 'resource'));
    }
}
