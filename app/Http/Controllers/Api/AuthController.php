<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Auth;

class AuthController extends Controller
{

    public function email()
    {
        $lang = $this->lang();
        $rules =  [
            'email'  => 'required',

        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {return $this->errorResponse($errors);}

        $code = rand(1000, 9999);

        $auth = User::where('email', request('email'))->first();
        if ($auth) {
            $data['code'] = $code;
            return $this->successResponse($data);
        }
        else
        {
            return $this->errorResponse(__('api.EmailNotFount'));
        }


    }

    public function resetPassword()
    {
        $lang = $this->lang();
        $rules =  [
            'email'  => 'required',
            'password'  => 'required'
        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {return $this->errorResponse($errors);}



            $auth = User::where('email', request('email'))->first();
            if ($auth)
            {
                $auth->update(['password' => request('password')]);
                return $this->successResponse(null, __('api.PasswordReset'));
            }


        return $this->errorResponse(__('api.NotFount'));
    }

    public function changePassword()
    {
        $lang = $this->lang();
        $auth = $this->auth();
        $rules =  [
            'password'  => 'required',
            'new_password'  => 'required'
        ];
        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {return $this->errorResponse($errors);}



        if((Auth::guard('apiUser')->attempt([ 'password'=>request('password')])))
            {
                $pass = User::where('id', $auth)->first();
                $pass->update(['password' => request('new_password')]);
                return $this->successResponse(null, __('api.PasswordReset'));
            }


        return $this->errorResponse(__('api.passwordInvalid'));
    }
}
