<?php

namespace App\Http\Controllers\Api;



use App\Models\Banner;
use App\Http\Controllers\ApiController;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Validator;
use Auth;

class BannerController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lang = request()->header('lang');
        $data['banner'] = Setting::select("image")->get()->pluck("image");
        return $this->successResponse($data);
    }

}