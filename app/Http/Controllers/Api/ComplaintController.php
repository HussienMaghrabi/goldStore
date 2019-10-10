<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Complaint;
use Illuminate\Support\Facades\Validator;

class ComplaintController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->lang();
        $rules =  [
            'name'  => 'required',
            'email'  => 'required|email',
            'status'  => 'required',
            'msg'  => 'required',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {return $this->errorResponse($errors);}

        Complaint::create(request()->all());
        return $this->successResponse(null, __('api.Complaint'));
    }
}
