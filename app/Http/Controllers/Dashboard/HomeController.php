<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Banner;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Bouquet;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Category;

class HomeController extends Controller
{
    private $resource = [
        'route' => 'admin.home',
        'icon' => "home",
        'title' => "DASHBOARD",
        'action' => "",
        'header' => "home"
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statistics = [
            'admins'            => Admin::count(),
            'users'             => User::count(),
            'banners'           => Banner::count(),
            'categories'        => Category::count(),
            'subcategories'     => SubCategory::count(),
            'Bouquets'          => Bouquet::count(),
            'product'           => Product::where('status',2)->count(),
            'requestProducts'   => Product::where('status',1)->count(),
        ];
        $resource = $this->resource;

        return view('dashboard.home', compact('statistics', 'resource'));
    }
}
