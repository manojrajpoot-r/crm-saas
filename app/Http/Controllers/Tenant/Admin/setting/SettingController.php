<?php

namespace App\Http\Controllers\Tenant\Admin\setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Setting;
use Illuminate\Support\Facades\Cache;
use App\FormDefinitions\SettingForm;
use App\Traits\UniversalCrud;
class SettingController extends Controller
{

 use UniversalCrud;

public function index()
{
    $settings = Setting::latest()->paginate(10);
    return view('tenant.admin.settings.index', compact('settings'));
 }

    public function create()
    {
        $item = null;
        $fields = SettingForm::fields();

        return view('tenant.admin.settings.addEdit', compact('fields','item'));
    }

    public function edit()
    {
        $item = Setting::first();
        $fields = SettingForm::fields($item);
        return view('tenant.admin.settings.addEdit', compact('fields','item'));
    }


    public function store(Request $request)
    {

        return $this->saveData($request, Setting::class);
    }

    public function update(Request $request, $id)
    {

         return $this->saveData($request, Setting::class, $id);

    }


    public function delete($id)
    {
        return $this->deleteData(Setting::class,$id);
    }


    public function status($id)
    {
        return $this->toggleStatus(Setting::class, $id);
    }


}
