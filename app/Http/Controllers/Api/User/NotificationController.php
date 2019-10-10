<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\ApiController;
use App\Models\Cart;
use App\Models\City;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderCart;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Vendor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NotificationController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lang = $this->lang();
        $auth = $this->auth();


        $data['current'] = Product::select('id','name')
            ->where('status', 2)
            ->Where('user_id',$auth)
            ->orderBy('id')
            ->paginate(10);
        $data['current']->map(function ($item) use ($lang)
        {
            $item->description = "تم اضافة الاعلان بنجاح. ";
            unset($item->Product);
        });
        return $this->successResponse($data);
    }


}
