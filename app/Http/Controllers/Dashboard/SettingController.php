<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App;
use Hash;
use Flashy;
use Validator;
use App\Models\Setting;

class SettingController extends Controller
{
    private $resources = 'settings';
    private $resource = [
        'route' => 'admin.settings',
        'view' => "settings",
        'icon' => "cogs",
        'title' => "SETTINGS",
        'action' => "",
        'header' => "Settings"
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resource = $this->resource;
        $resource['action'] = 'Edit';
        $item = Setting::first();

        return view('dashboard.views.' .$this->resources. '.edit', compact('item', 'resource'));
    }

    public function update(Request $request, $lang, $id)
    {
        \Illuminate\Support\Facades\App::setLocale($lang);

        $input = $request->except('image');

        if ($request->image)
        {
            $input['image'] = $this->uploadFile($request->image, 'settings');
        }

        Setting::first()->update($input);
        flashy(__('dashboard.updated'));
        return redirect()->route($this->resource['route'].'.index', $lang);
    }
}
