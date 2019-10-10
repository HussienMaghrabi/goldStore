<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Banner;
use App\Models\Category;
use Auth;

class HomeController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $lang = $this->lang();
        $data['home']['category'] = Category::select(
            "id",
            "name_$lang as name"
        )->get();
        $data['home']['category']->map(function ($item) use ($lang) {
            $item->Subcategory = $item->category()->select("id","name_$lang as name","image")->take(6)->get();
            $item->banner = Banner::pluck('image')->random();
        });

        return $this->successResponse($data);
    }

}
