<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\ApiController;
use App\Models\Favorite;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class PinnedController extends ApiController
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
        if ($item->pinned == 1){
            $item->update(['pinned' => 2]);
            return $this->successResponse(null, __('api.pinned'));
        }else {
            $item->update(['pinned' => 1]);
            return $this->successResponse(null, __('api.UnPinned'));
        }

    }
}
