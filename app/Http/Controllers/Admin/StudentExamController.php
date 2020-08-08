<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\StudentExam;
use Auth;

class StudentExamController extends Controller
{
    public function listExams()
    {
        return view('admin.student_exam.exam_list');
    }

    public function listExamsAjax(Request $request)
    {
        $org_id = Auth::guard('admin')->id();
        $exams = StudentExam::where('org_id',$org_id)->orderBy('id','desc');
        return datatables()->of($exams->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn ='<a href="'.route('admin.edit_exam_form',['exam_id'=>encrypt($row->id)]).'" class="btn btn-warning btn-sm" target="_blank">View Paper</a>';
                
                return $btn;
            })->addColumn('stream', function($row){
                if (!empty($row->exam_id)){
                    return $row->exam->class->stream->name;
                }else{
                    return null;
                }
            })->addColumn('subject', function($row){
                if (!empty($row->exam_id)){
                    return $row->exam->subject->name;
                }else{
                    return null;
                }
            })
            ->addColumn('class', function($row){
                if (!empty($row->exam_id)){
                    return $row->exam->class->name;
                }else{
                    return null;
                }
            })
            ->addColumn('exam_type', function($row){
                if (!empty($row->exam_id)){
                    if ($row->exam->exam_type == '1') {
                        return "Free User";
                    } else {
                        return "Premium User";
                    }
                    
                }else{
                    return null;
                }
            })
            ->addColumn('pass_mark', function($row){
                if (!empty($row->exam_id)){                    
                    return $row->exam->pass_mark;                    
                }else{
                    return null;
                }
            })
            ->addColumn('exam_name', function($row){
                if (!empty($row->exam_id)){                    
                    return $row->exam->name;                    
                }else{
                    return null;
                }
            })
            ->addColumn('total_marks', function($row){
                if (!empty($row->exam_id)){                    
                    return $row->exam->total_mark;                    
                }else{
                    return null;
                }
            })
            ->addColumn('exam_status', function($row){
                if ($row->exam_status == '1') {
                    return "<button class='btn btn-sm btn-warning'>Running</button>";
                } else {
                    return "<button class='btn btn-sm btn-primary'>Ended</button>";            
                }      
            }) ->addColumn('result_status', function($row){
                if (!empty($row->exam_id)) {
                    if ($row->exam->pass_mark <= $row->marks_obtain) {                        
                        return "<button class='btn btn-sm btn-success'>Pass</button>";
                    }else {
                        return "<button class='btn btn-sm btn-danger'>Fail</button>";            
                    }   
                }    
            })
            ->rawColumns(['action','subject','class','stream','exam_type','exam_status','result_status','pass_mark','exam_name','total_marks'])
            ->make(true);
    }
}
