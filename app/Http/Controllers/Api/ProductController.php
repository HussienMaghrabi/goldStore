<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Auth;

class ProductController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(){
         $lang = request()->header('lang');
         $auth = $this->auth();
         $date = date(Carbon::now());
             $data['product'] = Product::where('last', '>', $date)
                 ->where('sub_category_id',request('sub_category_id') )
                 ->where('status', 2)
                 ->select("id", "name", 'price', 'pinned', 'last')
                 ->orderByDesc('id')->paginate(10);

             $data['product']->map(function ($item) use ($auth) {
                 $item->has_favorite = $item->has_favorite($auth);
                 $item->img = $item->image()->pluck('image')->first();
                 $item->is_pinned = $item->pinned();
                 unset($item->sub_category_id);
             });

             return $this->successResponse($data);
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
     public function show($id)
     {
         // Show Product Details
         $auth = $this->auth();
         $lang = request()->header('lang');
         $date = date(Carbon::now());
         $data['product'] = Product::where('id', $id)
             ->where('last', '>', $date)
             ->where('status', 2)
             ->select("id", "name", 'price', 'desc', 'caliber', 'gram', 'bill', 'msg', 'type', 'price', 'money', 'video', 'price_statuse', 'pinned', 'repost', 'view', 'phone', 'longitude', 'latitude', 'last', 'user_id', 'sub_category_id')
             ->first();

         // Show Product Details Array
         $data['product']->img           = $data['product']->image()->select('image','img_type')->first();
         $data['product']->images        = $data['product']->image()->select('image','img_type')->get();
         $data['product']->category      = $data['product']->subcategory->category["name_$lang"];
         $data['product']->sub_category  = $data['product']->subcategory["name_$lang"];
         $data['product']->user          = $data['product']->user()->select('id', 'name')->first();
         $data['product']->has_favorite  = $data['product']->has_favorite($auth);
         $data['product']->is_pinned     = $data['product']->pinned();
         $data['product']->has_video     = $data['product']->video();
         $data['product']->is_repost     = $data['product']->repost();
         $data['product']->has_bill      = $data['product']->bill($auth);
         $data['product']->allow_msg     = $data['product']->msg($auth);

         // unset Product Details Array
         unset($data['product']->subcategory);
         unset($data['product']->pinned);
         unset($data['product']->video);
         unset($data['product']->sub_category_id);
         unset($data['product']->bill);
         unset($data['product']->msg);
         unset($data['product']->repost);


        // Similar Goods Product
         $data['product']['similar_goods'] = Product::where('user_id', $data['product']->user_id)
             ->where('last', '>', $date)
             ->where('id', '!=', $id)
             ->select("id", "name", 'price', 'pinned')
             ->orderBy('id')
             ->take(10)
             ->get();

         // Use map in Similar Goods Product
         $data['product']['similar_goods']->map(function ($item) use ($auth) {
             $item->has_favorite = $item->has_favorite($auth);
             $item->img = $item->image()->pluck('image')->first();
             $item->is_pinned = $item->pinned();

             unset($item->pinned);
         });

         $product = Product::find($id);
         $product->update(['view' => $product->view + 1]);


         return $this->successResponse($data);
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function stores(Request $request){

        $rules =  [
            'category_id'           => 'required',
            'sub_category_id'       => 'required',
            'name'                  => 'required',
            'desc'                  => 'required',
            'bill'                  => 'required',
            'price'                 => 'nullable',
            "longitude"             => 'nullable',
            "latitude"              => 'nullable',
            'phone'                 => 'required',
            'msg'                   => 'required',
            'video'                 => 'required',
            'repost'                => 'required',
            'media'                 => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        $auth = $this->auth();

        $user = User::where('id',$auth)->first();

        if ($user->free > 0){
            $user->update(['free'=> $user->free - 1]);
        }


        $inputs = $request->except('media','bill','pinned','msg','video','repost','img_type');
        $inputs['user_id'] = $auth ;




        if ($request->bill){
            if(request('bill') == true){
                $inputs['bill'] = 2;
            }elseif (request('bill') == false){
                $inputs['bill'] = 1;
            }else{
                $inputs['bill'] = null;
            }
        }

        if ($request->pinned){
            if(request('pinned') == true){
                $inputs['pinned'] = 2;
            }elseif (request('pinned') == false) {
                $inputs['pinned'] = 1;
            }
        }

        if ($request->msg){
            if(request('msg') == true){
                $inputs['msg'] = 2;
            }elseif (request('msg') == false) {
                $inputs['msg'] = 1;
            }else{
                $inputs['msg'] = null;
            }
        }

        if ($request->video){
            if(request('video') == true){
                $inputs['video'] = 2;
            }elseif (request('video') == false) {
                $inputs['video'] = 1;
            }else{
                $inputs['video'] = null;
            }
        }

        if ($request->repost){
            if(request('repost') == true){
                $inputs['repost'] = 2;
            }elseif (request('repost') == false){
                $inputs['repost'] = 1;
            }else{
                $inputs['repost'] = null;
            }
        }


        $item = Product::create($inputs);

        $item->status = 2;
        $item->last = Carbon::now()->addMonths(3);

        $item->save();

        if ($request->media) {
            foreach ($request->media as $image) {
                if ($image["img_type"] == 1){

                        ProductImage::create([
                            'image' => $this->uploadBase64($image['base'], 'product'),
                            'img_type' => 1,
                            'product_id' => $item->id
                        ]);

                }
            }
            foreach ($request->media as $image) {
                if ($image["img_type"] == 2) {

                        ProductImage::create([
                            'image' => $this->upload64($image['base'], 'product'),
                            'img_type' => 2,
                            'product_id' => $item->id
                        ]);
                }
            }
        }




        $message = __('dashboard.created');
        return $this->successResponse($item, $message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request,$id){

        $rules =  [
            'images' => 'nullable',

        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
         $auth = $this->auth();
         $inputs = $request->except('images');


             if($request->bill == true){
                 $inputs['bill'] = 2;
             }elseif($request->bill == false){
                 $inputs['bill'] = 1;
             }

             if($request->msg == true){
                 $inputs['msg'] = 2;
             }elseif($request->msg  == false) {
                 $inputs['msg'] = 1;
             }

             if($request->video == true){
                 $inputs['video'] = 2;
             }elseif($request->video == false) {
                 $inputs['video'] = 1;
             }

             if($request->repost == true){
                 $inputs['repost'] = 2;
             }elseif($request->repost == false){
                 $inputs['repost'] = 1;
             }

          $item = Product::find($id);

         if ($request->media) {

             foreach ($item->Image()->get() as $data)
             {
                 if (strpos($item->image, '/uploads/') !== false) {
                     $image = str_replace( asset('').'storage/', '', $data->image);
                     Storage::disk('public')->delete($image);
                 }
                 $data->delete();
             }


             foreach ($request->media as $image) {
                 if ($image["img_type"] == 1){
                     ProductImage::create([
                         'image' => $this->uploadBase64($image['base'], 'product'),
                         'img_type' => 1,
                         'product_id' => $item->id
                     ]);
                 }else{
                     ProductImage::create([
                         'image' => $this->upload64($image['base'], 'product'),
                         'img_type' => 2,
                         'product_id' => $item->id
                     ]);
                 }
             }
         }

        $data['Product'] = Product::find($id);
        $data['Product']->update($inputs);
        $message = __('dashboard.updated');
        return $this->successResponse($data, $message);
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
     public function destroy($id){

        $data = Product::findOrFail($id);
         if (strpos($data->image, '/uploads/') !== false) {
             $image = str_replace( asset('').'storage/', '', $data->image);
             Storage::disk('public')->delete($image);
         }
        $data->delete();
        $message = __('dashboard.deleted');
        return $this->successResponse(null, $message);
     }
}
