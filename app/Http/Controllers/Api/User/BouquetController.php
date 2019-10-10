<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\ApiController;
use App\Models\Bouquet;
use App\Models\User;
use App\Models\UserBouquet;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BouquetController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lang = $this->lang();

        $data = Bouquet::select('id','name','desc','normal','pinned','video','price')->get();

        return $this->successResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auth = $this->auth();

        $rules =  [
            'bouquet'=> 'required|exists:bouquets,id',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {
            return $this->errorResponse($errors);
        }

        $package = Bouquet::find(request('bouquet'));

        $user = User::find($auth);

        $user->normal_ads = $package->normal_ads;
        $user->pinned_ads = $package->pinned_ads;
        $user->video_ads = $package->video_ads;

        $user->save();


        $message = __('api.buy');
        return $this->successResponse($package, $message);
    }

}
