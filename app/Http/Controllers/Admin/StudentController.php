<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Model\Classes;
use App\Model\Stream;
use App\Model\User;
use DataTables;

class StudentController extends Controller
{
    public function addStudent()
    {
        $org_id = Auth::guard('admin')->id();
        $stream = Stream::get();
        return view('admin.users.add_student',compact('stream'));
    }

    public function insertStudent(Request $request)
    {
        $this->validate($request, [
            'stream'   => 'required',
            'user_type' => 'required',
            'class' => 'required',
            'mobile' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
            's_name' => 'required',
            'dob' => 'required',
        ]);
        $org_id = Auth::guard('admin')->id();

        $student = new User();
        $student->name = $request->input('s_name');
        $student->email = $request->input('email');
        $student->password = bcrypt($request->input('password'));
        $student->class_id = $request->input('class');
        $student->father_name = $request->input('father_name');
        $student->mobile = $request->input('mobile');
        $student->dob = $request->input('dob');
        $student->address = $request->input('address');
        $student->state = $request->input('state');
        $student->city = $request->input('city');
        $student->pin = $request->input('pin');
        $student->org_id = $org_id;
        $student->status = $request->input('user_type');
        $student->save();
        return redirect()->back()->with('message','Student Added Successfully');
    }

    public function listFreeStudent()
    {
        return view('admin.users.free_student_list');
    }

    public function listFreeStudentAjax(Request $request)
    {
        $org_id = Auth::guard('admin')->id();
        $student = User::where('status',1);
        return datatables()->of($student->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn ='<a href="#" class="btn btn-warning btn-sm" target="_blank">Edit</a>';
                
                return $btn;
            })->addColumn('class_name', function($row){
                if (!empty($row->class)) {
                    return $row->class->name;
                } else {
                    return null;
                }
            })
            ->rawColumns(['action','class_name'])
            ->make(true);
    }
    
    public function listPreStudent()
    {
        return view('admin.users.premium_student_list');
    }

    public function listPreStudentAjax(Request $request)
    {
        $org_id = Auth::guard('admin')->id();
        $student = User::where('status',2);
        return datatables()->of($student->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn ='<a href="#" class="btn btn-warning btn-sm" target="_blank">Edit</a>';
                
                return $btn;
            })->addColumn('class_name', function($row){
                if (!empty($row->class)) {
                    return $row->class->name;
                } else {
                    return null;
                }
            })
            ->rawColumns(['action','class_name'])
            ->make(true);
    }
}
