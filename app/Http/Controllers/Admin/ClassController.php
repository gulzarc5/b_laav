<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Stream;
use App\Model\Classes;
use Auth;


class ClassController extends Controller
{
    public function addClass()
    {
        $stream = Stream::get();
        return view('admin.class.add_class',compact('stream'));
    }

    public function listClass()
    {
        $org_id = Auth::guard('admin')->id();
        $class = Classes::where('org_id',$org_id)->orderBy('id','desc')->get();
        return view('admin.class.class_list',compact('class'));
    }

    public function insertClass(Request $request)
    {
        $this->validate($request, [
            'stream'   => 'required',
            'name' => 'required'
        ]);

        $class = new Classes();
        $class->stream_id = $request->input('stream');
        $class->name = $request->input('name');
        $class->org_id = Auth::guard('admin')->id();
        $class->save();
        return redirect()->back()->with('message','Class Added Successfully');
    }

    public function listClassAjax($stream_id)
    {
        $org_id = Auth::guard('admin')->id();
        $class = Classes::where('org_id',$org_id)->where('stream_id',$stream_id)->orderBy('id','asc')->get();
        return $class;
    }

}
