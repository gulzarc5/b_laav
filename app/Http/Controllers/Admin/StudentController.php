<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Model\Classes;
use App\Model\Stream;
use App\Model\User;
use App\Model\Admin;
use App\Model\OrgClass;
use App\Model\RegRequest;
use DataTables;
use Illuminate\Validation\Rule; 

class StudentController extends Controller
{
    public function addStudent()
    {
        $stream = Stream::get();
        $organization = Admin::orderBy('id','asc')->get();
        return view('admin.users.add_student',compact('stream','organization'));
    }

    public function insertStudent(Request $request)
    {
        $this->validate($request, [
            'stream'   => 'required',
            'organization' => 'required',
            'class' => 'required',
            'mobile' => 'required',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->where(function($query) {
                  $query->where('status', 2);
                })
            ],
            'password' => 'required|min:8',
            's_name' => 'required',
            'dob' => 'required',
        ]);


        $student = new User();
        $student->name = $request->input('s_name');
        $student->email = $request->input('email');
        $student->password = bcrypt($request->input('password'));
        $student->class_id = $request->input('class');
        $student->father_name = $request->input('father_name');
        $student->mother_name = $request->input('mother_name');
        $student->mobile = $request->input('mobile');
        $student->dob = $request->input('dob');
        $student->address = $request->input('address');
        $student->state = $request->input('state');
        $student->city = $request->input('city');
        $student->pin = $request->input('pin');
        $student->org_id = $request->input('organization');
        $student->status = 2;
        if($student->save()){
            $id = $student->id;
            $org = Admin::where('id',$request->input('organization'))->first();
            $student_id =  strtoupper(substr($org->name, 0, 2));
            $length = 5 - strlen((string)$id);
            for ($i=0; $i < $length; $i++) { 
                $student_id.="0";
            }
            $student_id.=$id;
            $student->student_id = $student_id;
            $student->save();
        }
        return redirect()->back()->with('message','Student Added Successfully');
    }

    public function updateStudent(Request $request,$id)
    {
        $this->validate($request, [
            'stream'   => 'required',
            'organization' => 'required',
            'class' => 'required',
            'mobile' => 'required',
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            's_name' => 'required',
            'dob' => 'required',
        ]);

        $chk_validation = User::where('id','!=',$id)->where('status',2)->where('email',$request->input('email'))->count();
        if ($chk_validation > 0) {
            return redirect()->back()->with('error','Email Already Exist Please Try With Another One');
        }

        $student = User::find($id);
        $student->name = $request->input('s_name');
        $student->email = $request->input('email');
        $student->class_id = $request->input('class');
        $student->father_name = $request->input('father_name');
        $student->mother_name = $request->input('mother_name');
        $student->mobile = $request->input('mobile');
        $student->dob = $request->input('dob');
        $student->address = $request->input('address');
        $student->state = $request->input('state');
        $student->city = $request->input('city');
        $student->pin = $request->input('pin');
        $student->org_id = $request->input('organization');
        $student->save();
            
        return redirect()->back()->with('message','Student Details Updated Successfully');
    }

    public function editStudent($id)
    {
        $stream = Stream::get();
        $organization = Admin::orderBy('id','asc')->get();
        $student = User::find($id);
        $class = Classes::where('stream_id',$student->class->stream->id)->get();
        return view('admin.users.edit_student',compact('stream','organization','student','class'));
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
                $btn ='<a href="'.route('admin.student_edit',['id'=>$row->id]).'" class="btn btn-warning btn-sm" target="_blank">Edit</a>';
                
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

    public function listOrgStudent()
    {
        return view('admin.users.organization_student_list');
    }

    public function listOrgStudentAjax(Request $request)
    {
        $student = User::where('status',2)->where('org_id','!=','1');
        return datatables()->of($student->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn ='<a href="'.route('admin.student_edit',['id'=>$row->id]).'" class="btn btn-warning btn-sm" target="_blank">Edit</a>';
                
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

    public function listRequestStudent()
    {
        return view('admin.users.student_request_list');
    }

    public function listRequestStudentAjax()
    {
        $student = User::where('status',1);
        return datatables()->of($student->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn ='<a href="'.route('admin.request_student_delete',['id'=>$row->id]).'" class="btn btn-danger btn-sm">Delete</a>';
                
                return $btn;
            })
            ->addColumn('class_name', function($row){
                if (!empty($row->class)) {
                    return $row->class->name;
                } else {
                    return null;
                }
            })
            ->rawColumns(['class_name','action'])
            ->make(true);
    }

    public function deleteRequestStudent($id)
    {
        User::where('id',$id)->where('status',1)->delete();
        return redirect()->back();
    }
}
