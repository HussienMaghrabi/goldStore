<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Validator;
use Auth;

class ProductController extends Controller
{
    private $resources = 'products';
    private $resource = [
        'route' => 'admin.product',
        'view' => "products",
        'icon' => "bookmark",
        'title' => "PRODUCT",
        'action' => "",
        'header' => "Products"
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::where('status', 2)->orderBy('id')->paginate(10);
        $resource = $this->resource;
        return view('dashboard.views.'.$this->resources.'.index',compact('data', 'resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lang, $id)
    {
        $rules =  [

        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }

        $category = Product::findOrFail($id);
        $input = $request->except('image');
        if( $request->image){
            unlink(str_replace( asset(''), '', $category->image));
            $file =$request->image;
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $input['image'] = $name;
        }

        Product::find($id)->update($input);

        App::setLocale($lang);
        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $admin
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy($lang, $id)
    {
        $item = Product::findOrFail($id);
        if (strpos($item->image, '/uploads/') !== false) {
            $image = str_replace( asset('').'storage/', '', $item->image);
            Storage::disk('public')->delete($image);
        }
        $item->delete();
        App::setLocale($lang);
        flashy(__('dashboard.deleted'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function multiDelete($lang)
    {
        foreach (\request('checked') as $id)
        {
            $item = Product::findOrFail($id);
            if (strpos($item->image, '/uploads/') !== false) {
                $image = str_replace( asset('').'storage/', '', $item->image);
                Storage::disk('public')->delete($image);
            }
            $item->delete();

        }
        App::setLocale($lang);
        flashy(__('dashboard.deleted'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }

    public function search(Request $request, $lang)
    {
        $resource = $this->resource;
        $data = Product::select
        ('products.name_ar',
            'products.name_en',
            'products.desc_ar',
            'products.desc_en',
            'products.image',
            'products.price',
            'products.view',
            'products.caliber',
            'products.gram',
            'products.sub_category_id'
        )
            ->join('sub_categories', 'sub_categories.id', '=', 'products.sub_category_id')
            ->Where('sub_categories.name_en', 'LIKE', '%'.$request->text.'%')
            ->orWhere('sub_categories.name_ar', 'LIKE', '%'.$request->text.'%')
            ->orWhere('products.name_en', 'LIKE', '%'.$request->text.'%')
            ->orWhere('products.name_ar', 'LIKE', '%'.$request->text.'%')
            ->orWhere('products.desc_ar', 'LIKE', '%'.$request->text.'%')
            ->orWhere('products.desc_en', 'LIKE', '%'.$request->text.'%')
            ->orWhere('products.price', 'LIKE', '%'.$request->text.'%')
            ->orWhere('products.view', 'LIKE', '%'.$request->text.'%')
            ->orWhere('products.caliber', 'LIKE', '%'.$request->text.'%')
            ->orWhere('products.gram', 'LIKE', '%'.$request->text.'%')
            ->paginate(10);
        App::setLocale($lang);
        return view('dashboard.views.' .$this->resources. '.index', compact('data', 'resource'));
    }
}
