<?php

namespace App\Http\Controllers\Api\User;


use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Validator;
use Auth;

class UserController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(){
        $data['user'] = User::all();
        return $this->successResponse($data);
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
     public function show($id){

        $data['user'] = User::findOrFail($id);
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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'min:6',
            'image' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }

        $input = $request->except('image');
        $input['api_token'] = str_random(60);
        if( $request->image) {
            $input['image'] = $this->uploadBase64($request['image']);
        }
        $data['user'] = User::create($input);

        return $this->successResponse($data);
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
     public function update(Request $request,$id){

        $rules =  [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|min:6',
            'image' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }
        $input = $request->except('image');
        $input['api_token'] = str_random(60);
        if( $request->image) {
            $user = User::findOrFail($id);
            $path = parse_url($user->image);
            unlink(public_path($path['path']));

            $input['image'] = $this->uploadBase64($request['image']);
        }
        $data['user'] = User::find($id);
        $data['user']->update($input);
        $message = __('dashboard.updated');
        return $this->successResponse($data, $message);
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
     public function destroy($id){

        $data = User::findOrFail($id);
        if($data->image){
            $path = parse_url($data->image);
            unlink(public_path($path['path']));
        }
        $data->delete();
        $message = __('dashboard.deleted');
        return $this->successResponse(null, $message);
     }
}
