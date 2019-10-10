<?php

namespace App\Http\Controllers\Api;


use App\Models\City;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Validator;
use Auth;

class CityController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(){
         $lang = request()->header('lang');
         $data['cities'] = City::select(
             "id" ,
             "name_$lang as name"
         )->orderBy('sort')->get();
         return $this->successResponse($data);
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
     public function show($id){
         $lang = request()->header('lang');
         $data['cities'] = City::where('id', $id)->select(
             "id",
             "name_$lang as name"
        )->first();
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
         ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }

        $data['city'] = City::create($request->all());
         $message = __('dashboard.created');
        return $this->successResponse($data, $message);
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request,$id){

         $rules =  [

             'name_ar' => 'required',
             'name_en' => 'required',
         ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }

        $data['city'] = City::find($id);
        $data['city']->update($request->all());
        $message = __('dashboard.updated');
        return $this->successResponse($data, $message);
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
     public function destroy($id){

        $data = City::findOrFail($id);
        $data->delete();
        $message = __('dashboard.deleted');
        return $this->successResponse(null, $message);
     }
}
