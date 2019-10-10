<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\ApiController;
use App\Models\FcmToken;
use App\Models\Setting;
use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Auth;


class AuthController extends ApiController
{

    public function login_verification()
    {
        $this->lang();
        $rules = [
            'phone' => 'required|exists:users,phone',
        ];


        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if ($validator->fails()) {
            return $this->errorResponse($errors);
        }

        $code = rand(1000, 9999);

        $phone = '965'.request('phone');

        $this->sendSMS($phone, $code);

        $data['code'] = $code;
        $auth = User::where('phone',request('phone'))->first();
        $auth->update(['code' => $code]);
        return $this->successResponse($data);

    }

    public function login(){

        $this->lang();
        $rules =  [
            'code'  => 'required|exists:users,code',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {return $this->errorResponse($errors);}

        $auth = User::where('code',request('code'))->first();
        $token = str_random(70);
        Token::create(['api_token'=>$token, 'user_id' => $auth->id]);
        $auth->update(['code' => null]);

        if (request('fcm_token'))
        {
            $fcm = FcmToken::where('fcm_token',request('fcm_token'))->first() ;
            if ($fcm){
                $fcm->update(['user_id' => $auth->id]);
            }else{
                FcmToken::create(['fcm_token'=>request('fcm_token'), 'user_id' => $auth->id]);
            }
        }

        $data['user'] = User::where('id', $auth->id)->select('id', 'name', 'image', 'phone', 'email', 'longitude', 'latitude')->first();
        $data['user']->api_token = $token;
        $auth->code = null;
        $auth->save();
        return $this->successResponse($data,  __('api.loginSuccess'));

    }


    public function register_verification()
    {
        $this->lang();
        $rules =  [
            'phone'  => 'required|unique:users'
        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {return $this->errorResponse($errors);}

        $code = rand(1000, 9999);

        $phone = '965'.request('phone');

        $this->sendSMS($phone, $code);

        $data['code'] = $code;
        return $this->successResponse($data);

    }

    public function register(){
        $this->lang();
        $rules =  [
            'name'      => 'required',
            'phone'     => 'required|unique:users',
            'email'     => 'nullable|unique:users',
            'image'     => 'nullable',
            'longitude' => 'nullable',
            'latitude'  => 'nullable',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {return $this->errorResponse($errors);}

        $input = request()->except('image', 'fcm_token');

        if (request('image'))
        {
            $input['image'] = $this->uploadBase64(request('image'), 'users');
        }

        $auth = User::create($input);

        $settings = Setting::select('free_ads')->first();

        $auth->free_ads = $settings->free_ads;

        $auth->save();

        $token = str_random(70);
        Token::create(['api_token' => $token, 'user_id' => $auth->id]);

        if (request('fcm_token'))
        {
            $fcm = FcmToken::where('fcm_token',request('fcm_token'))->first() ;
            if ($fcm){
                $fcm->update(['user_id' => $auth->id]);
            }else{
                FcmToken::create(['fcm_token' => request('fcm_token'), 'user_id' => $auth->id]);
            }
        }

        $data['user'] = User::where('id', $auth->id)->select('id', 'name', 'image', 'phone', 'email', 'longitude', 'latitude')->first();
        $data['user']->api_token = $token;

        return $this->successResponse($data, __('api.RegisterSuccess'));
    }



    public function logout()
    {
        $this->lang();
        $auth = $this->auth();
        User::find($auth)->update(['api_token' => null]);
        return $this->successResponse(null, __('api.Logout'));
    }


}
