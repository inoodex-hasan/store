<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function index()
    {
        return view('frontend.pages.setting.index',[
            'Settings'  => Setting::all(),
        ]);
    }


    public function create_setting_button()
    {
        return view('frontend.pages.setting.create_setting_button');
    }


    public function store(Request $request)
    {


//        $request->validate([
//            'unit' => 'required|string|max:255',
//            'currency' => 'required|string|max:255',
//            'company_name' => 'required|string|max:255',
//            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
//            'address' => 'required|string|max:255',
//            'phone' => 'required|string|max:20|unique:settings,phone',
//            'email' => 'required|email|max:255|unique:settings,email',
//            'website' => 'nullable|url|max:255',
//        ]);


        Setting::newSetting($request);
        return back()->with('message', 'Setting info create successfully!');
    }



    public function edit($id)
    {
        return view('frontend.pages.setting.edit', [
            'setting' => Setting::find($id)
        ]);
    }

    public function update(Request $request, $id)
    {


//        $request->validate([
//            'unit' => 'required|string|max:255',
//            'currency' => 'required|string|max:255',
//            'company_name' => 'required|string|max:255',
//            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
//            'address' => 'required|string|max:255',
//            'phone' => 'required|string|max:20|unique:settings,phone',
//            'email' => 'required|email|max:255|unique:settings,email',
//            'website' => 'nullable|url|max:255',
//        ]);



        Setting::updateSetting($request, $id);
        return redirect('/setting')->with('message', 'Setting info update successfully!');
    }

    public function delete($id)
    {
        Setting::deleteSetting($id);
        return redirect('/setting');
    }

 


}
