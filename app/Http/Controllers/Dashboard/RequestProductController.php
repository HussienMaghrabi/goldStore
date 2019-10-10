<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\FcmToken;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Validator;
use Auth;

class RequestProductController extends Controller
{
    private $resources = 'requestproducts';
    private $resource = [
        'route' => 'admin.requestProducts',
        'view' => "requestproducts",
        'icon' => "bookmark",
        'title' => "PRODUCTS_VENDOR",
        'action' => "",
        'header' => "products_Vendor"
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::where('status', 1)->orderBy('id')->paginate(10);
        $resource = $this->resource;
        return view('dashboard.views.'.$this->resources.'.index',compact('data', 'resource'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit($lang, $id)
    {
        $resource = $this->resource;
        $resource['action'] = 'Approve';
        $item = Product::findOrFail($id);

        return view('dashboard.views.' .$this->resources. '.edit', compact('item', 'resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $lang, $id)
    {
        $rules =  [
            "status" => "required"
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            flashy()->error($validator->errors()->all()[0]);
            return back();
        }
        $input = $request->all();
        $date = Carbon::now()->addMonths(3);
        $input['last'] = $date ;
        $item = Product::find($id);
        $item->update($input);

        $user = $item->user_id;
        $name = $item->name;
        $notification['title'] = 'تم اضافة الاعلان بنجاح';
        $notification['body'] = "تم اضافة اعلانك $name بنجاح";
        $notification['id'] = $id;
        $notification['fcm_token'] = FcmToken::Where('user_id', $user)->pluck('fcm_token');
        $this->pushNotification($notification);

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
