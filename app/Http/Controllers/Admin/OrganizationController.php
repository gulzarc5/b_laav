<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin;

class OrganizationController extends Controller
{
    public function addOrg()
    {
        return view('admin.organization.add_org');
    }

    public function insertOrg(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email'   => 'required|email|unique:admin,email',
            'password' => 'required|min:6',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pin' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1000',
        ]);
        $file_name = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $file_name = time().date('Y-M-d').'.'.$file->getClientOriginalExtension();
            $path =  base_path().'/public/org_image/';
            $file->move($path, $file_name);
        }
        $admin = new Admin();
        $admin->name = $request->input('name');
        $admin->image = $file_name;
        $admin->email = $request->input('email');
        $admin->password = bcrypt($request->input('password'));
        $admin->code = $request->input('password');
        $admin->address = $request->input('address');
        $admin->state = $request->input('state');
        $admin->city = $request->input('city');
        $admin->pin = $request->input('pin');
        $admin->save();
        return redirect()->back()->with('message','Organization Added Successfully');
    }

    public function listOrg()
    {
        $org = Admin::where('id','!=','1')->get();
        return view('admin.organization.org_list',compact('org'));
    }

    public function editOrg($id)
    {
        $org = Admin::find($id);
        return view('admin.organization.edit_org',compact('org'));
    }

    public function updateOrg(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email'   => 'required|email',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pin' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1000',
        ]);
       $check = Admin::where('id','!=',$id)->where('email',$request->input('email'))->count();
       if ($check > 0) {
        return redirect()->back()->with('error','Sorry Email Already Exist');
       }
        $admin = Admin::find($id);
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $file_name = time().date('Y-M-d').'.'.$file->getClientOriginalExtension();
            $path =  base_path().'/public/org_image/';
            $file->move($path, $file_name);
            
            $admin->image = $file_name;
        }
        $admin->address = $request->input('address');
        $admin->state = $request->input('state');
        $admin->city = $request->input('city');
        $admin->pin = $request->input('pin');
        $admin->save();
        return redirect()->back()->with('message','Organization Updated Successfully');
    }
}
