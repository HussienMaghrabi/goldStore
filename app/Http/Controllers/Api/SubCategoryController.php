<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\ApiController;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Validator;
use Auth;

class SubCategoryController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(){
         $lang = request()->header('lang');
         $data['subcategory'] = SubCategory::where('category_id',request('category_id') )->select(
             "id",
             "name_$lang as name",
             "category_id",
             "image"
         )->paginate(10);
         $data['subcategory']->map(function ($item) use ($lang) {
             $item->category_name = $item->category["name_$lang"];
             unset($item->category);
             unset($item->category_id);
             unset($item->product);
         });
        return $this->successResponse($data);
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
     public function show($id){
         $lang = request()->header('lang');
         $data['category'] = Category::where('id', $id)->select(
             "id",
             "name_$lang as name"
         )->first();
         $data['category']->subcategory = $data['category']->Category()->select(
             'id',
             "name_$lang as name",
             "image")->paginate(10);
         $data['category']->subcategory->map(function ($item) use ($lang) {
             unset($item->sub_category);
         });
         return $this->successResponse($data);
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function create(Request $request){

        $rules =  [
            'name_ar' => 'required',
            'name_en' => 'required',
            'image'   => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
         $input = $request->except('image');
         if( $request->image) {
             $input['image'] = $this->uploadBase64($request['image']);
         }

        $data['category'] = Category::create($input);
         $message = __('dashboard.created');
        return $this->successResponse($data, $message);
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
            'name_ar' => 'required',
            'name_en' => 'required',
            'image'   => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
         $input = $request->except('image');
         if( $request->image) {
             $user = Category::findOrFail($id);
             $path = parse_url($user->image);
             unlink(public_path($path['path']));

             $input['image'] = $this->uploadBase64($request['image']);
         }

        $data['category'] = Category::find($id);
        $data['category']->update($input);
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

        $data = Category::findOrFail($id);
         if($data->image){
             $path = parse_url($data->image);
             unlink(public_path($path['path']));
         }
        $data->delete();
        $message = __('dashboard.deleted');
        return $this->successResponse(null, $message);
     }
}
