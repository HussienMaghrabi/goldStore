<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\ApiController;
use App\Models\Favorite;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class RePostController extends ApiController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $rules =  [
            'product'  => 'required',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {return $this->errorResponse($errors);}

        $item = product::where('id', request('product'))->first();
        $date = Carbon::now()->addMonths(3);
        $item->update(['last' => $date]);
        return $this->successResponse(null, __('api.Re-posted'));

    }
}
