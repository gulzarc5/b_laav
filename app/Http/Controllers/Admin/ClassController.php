<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Stream;
use App\Model\Classes;
use App\Model\OrgClass;
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

    public function listClassAjax($stream_id,$org_id=null)
    {
        if (empty($org_id) ) {          
            $class = Classes::where('org_id',1)->where('stream_id',$stream_id)->orderBy('id','asc')->get();
        }elseif($org_id=='1'){        
            $class = Classes::where('org_id',1)->where('stream_id',$stream_id)->orderBy('id','asc')->get();
        }else{
            $class = OrgClass::select('classes.*')
            ->join('classes', 'classes.id', '=', 'org_class.class_id')
            ->get();
        }
        return $class;
    }

    public function editClass($id)
    {
        $class = Classes::find($id);
        $stream = Stream::get();
        return view('admin.class.edit_class',compact('class','stream'));
    }

    public function updateClass(Request $request,$class_id)
    {
        $this->validate($request, [
            'stream'   => 'required',
            'name' => 'required'
        ]);
        $class = Classes::find($class_id);
        $class->stream_id = $request->input('stream');
        $class->name = $request->input('name');
        $class->save();
        return redirect()->back()->with('message','Class Updated Successfully');
    }

}
