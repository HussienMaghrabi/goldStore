<?php

namespace App\Http\Controllers\Api\User;


use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Validator;
use Auth;

class UpdateController extends ApiController
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

        $user = User::where('id', $auth)->select(
            "id",
            "name",
            "longitude",
            "latitude",
            "phone",
            "email",
            "image",
            'free_ads',
            'normal_ads',
            'pinned_ads',
            'video_ads'
        )->first();

        $data['profile']['user'] = $user;


        $data['profile']['user']->product_number =  __('api.YouHave').' '.$user->free_ads.' '.__('api.FreeAds').' '.__('api.And').' '.$user->normal_ads.' '.__('api.PremiumAds').' '.__('api.And').' '.$user->pinned_ads.' '.__('api.PinnedAds').' '.__('api.And').' '.$user->video_ads.' '.__('api.VideoAds');

        $data['profile']['product'] = Product::where('user_id',$auth)->select("id","name","price","pinned")->get();
        $data['profile']['product']->map(function ($item) use ($auth) {
            $item->has_favorite = $item->has_favorite($auth);
            $item->is_pinned = $item->pinned();
            $item->img = $item->image()->pluck('image')->first();
            unset($item->pinned);
        });

        return $this->successResponse($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
     public function show($id){

        $data['user'] = User::findOrFail($id);
        return $this->successResponse($data);
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function create(Request $request){

        $rules =  [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'min:6',
            'image' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return $this->errorResponse($validator->errors()->all()[0]);
        }

        $input = $request->except('image');

        $input['api_token'] = str_random(60);

        if( $request->image) {
            $input['image'] = $this->uploadBase64($request['image']);
        }
        $data['user'] = User::create($input);

        return $this->successResponse($data);
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $this->lang();
        $auth = $this->auth();
        $rules =  [
            'name'      => 'required',
            'phone'     => 'required|unique:users,phone,'.$auth,
            'email'     => 'required|unique:users,email,'.$auth,
            "longitude" => 'required',
            "latitude"  => 'required',
            'image'     => 'nullable'
        ];

        $validator = Validator::make(request()->all(), $rules);
        $errors = $this->formatErrors($validator->errors());
        if($validator->fails()) return $this->errorResponse($errors);

        $input = request()->except('image');
        $item = User::find($auth);

        if (request('image'))
        {
            if (strpos($item->image, '/uploads/') !== false) {
                $image = str_replace( asset('').'storage/', '', $item->image);
                Storage::disk('public')->delete($image);
            }
            $input['image'] = $this->uploadBase64(request('image'), 'users/'.$auth);
        }
        $item->update($input);

        $data['user'] = User::where('id', $auth)->select('id', 'name', 'image', 'phone', 'email',"longitude",'latitude')->first();
        $data['user']->api_token = request()->header('Authorization');

        return $this->successResponse($data, __('api.ProfileUpdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
     public function destroy($id){

        $data = User::findOrFail($id);
        if($data->image){
            $path = parse_url($data->image);
            unlink(public_path($path['path']));
        }
        $data->delete();
        $message = __('dashboard.deleted');
        return $this->successResponse(null, $message);
     }
}
