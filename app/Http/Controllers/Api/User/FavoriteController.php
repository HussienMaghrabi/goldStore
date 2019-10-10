<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\ApiController;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class FavoriteController extends ApiController
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
        $data['products'] = Product::select('id', "name", 'price','pinned')
                        ->whereIn('id', Favorite::where('user_id', $auth)->select('product_id')->get())
                        ->get();

        $data['products']->map(function ($item) use ($lang)
        {
            $item->is_pinned = $item->pinned();
            $item->img = $item->image()->pluck('image')->first();
        });
        return $this->successResponse($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $lang = $this->lang();
        $auth = $this->auth();
        $rules =  [
            'product'  => 'required|exists:products,id',
        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) {return $this->errorResponse($errors);}

        $item = Favorite::where('user_id', $auth)->where('product_id', request('product'))->first();
        if ($item)
        {
            $item->delete();
            return $this->successResponse(null, __('api.UnLike'));
        }
        else
        {
            Favorite::create([
                'user_id' => $auth,
                'product_id' => request('product')
            ]);
            return $this->successResponse(null, __('api.Like'));
        }
    }
}
