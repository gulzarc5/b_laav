<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\AppSetting;
use File;

class DashboardController extends Controller
{
    public function dashboardView()
    {
        return view('admin.dashboard');
    }

    public function changePasswordForm()
    {
        return view('admin.change_password');
    }

    public function ListData()
    {
        $data = AppSetting::get();
        return view('admin.app_setting.app_setting_list',compact('data'));
    }

    public function imageForm()
    {
        return view('admin.app_setting.add_image');
    }

    public function imageInsert(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1000',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $file_name = time().date('Y-M-d').'.'.$file->getClientOriginalExtension();
            $path =  base_path().'/public/org_image/';
            $file->move($path, $file_name);
            $app_setting = new AppSetting;
            $app_setting->type = 2;
            $app_setting->file = $file_name;
            $app_setting->save();
            
        }        
        return redirect()->back()->with('message','Slider Image Added Successfully');
    }

    public function imageDelete($id)
    {
        $image = AppSetting::where('id',$id)->first();
        $path = base_path().'/public/org_image/'.$image->file;
        if (File::exists($path)) {
            File::delete($path);
        }
        AppSetting::where('id',$id)->delete();
        return redirect()->back();
    }

    public function videoForm()
    {
        return view('admin.app_setting.change_video');
    }

    public function videoInsert(Request $request)
    {
        $this->validate($request, [
            'video' => 'required',
        ]);

        $app_setting = AppSetting::find(1);
        $app_setting->type = 1;
        $app_setting->file = $request->input('video');
        $app_setting->save();
        
        return redirect()->back()->with('message','Video Changed Successfully');
    }
}
