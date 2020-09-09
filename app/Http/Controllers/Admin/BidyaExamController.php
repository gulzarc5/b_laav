<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\BidyaExam;
use App\Model\BidyaExamClass;
use App\Model\Stream;
use App\Model\Classes;
use App\Model\BidyaExamQuestion;
use App\Model\BidyaQuestionOption;
use App\Model\BidyaExamPermission;
use App\Model\User;
use Auth;
use DataTables;
use File;
use Response;
use Storage;


class BidyaExamController extends Controller
{
    public function listExams()
    {
        return view('admin.bidya_exam.exam_list');
    }
    public function addExamForm()
    {
        $class = Classes::Where('org_id',1)->get();
        return view('admin.bidya_exam.add_new_exam',compact('class'));
    }

    public function insertExam(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'total_mark' => 'required',
            'pass_mark' => 'required',
            'duration' => 'required',
            's_date' => 'required',
            'e_date' => 'required',
            'exam_type' => 'required',
        ]);
        $class = $request->input('class'); //class array
        $org_id = Auth::guard('admin')->id();
        $exam = new BidyaExam();
        $exam->org_id = $org_id;
        $exam->name = $request->input('title');
        $exam->start_date = $request->input('s_date');
        $exam->end_date = $request->input('e_date');
        $exam->exam_type = $request->input('exam_type');
        $exam->total_mark = $request->input('total_mark');
        $exam->pass_mark = $request->input('pass_mark');
        $exam->duration = $request->input('duration');
        $exam->exam_status = 1;
        if ($exam->save()) {
            
            if (isset($class) && !empty($class)) {
                foreach ($class as $key => $value) {
                    $exam_class = New BidyaExamClass();
                    $exam_class->exam_id = $exam->id;
                    $exam_class->class_id = $value;
                    $exam_class->save();
                }
            }
            return redirect()->back()->with('message','Exam Created Successfully Please Add Exam Question');
        } else {
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
        
    }

    public function listExamsAjax(Request $request)
    {
        // $org_id = Auth::guard('admin')->id();
        $exams = BidyaExam::where('org_id',1)->orderBy('id','desc');
        return datatables()->of($exams->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn ='<a href="'.route('admin.edit_exam_form',['exam_id'=>encrypt($row->id)]).'" class="btn btn-warning btn-sm" target="_blank">Edit</a>
                <a href="'.route('admin.view_bidya_question',['exam_id'=>encrypt($row->id)]).'" class="btn btn-info btn-sm" target="_blank">View Questions</a>
                <a href="'.route('admin.add_other_org_student',['exam_id'=>encrypt($row->id)]).'" class="btn btn-info btn-sm" target="_blank">View Other Org Students</a>';
                
                return $btn;
            })
            ->addColumn('exam_type', function($row){
                if ($row->exam_type == '1') {
                    return "<button class='btn btn-sm btn-warning'>Free</button>";
                } else {
                    return "<button class='btn btn-sm btn-primary'>Premium</button>";            
                }      
            })->addColumn('question_status', function($row){
                if ($row->exam_status == '1') {
                    return "<button class='btn btn-sm btn-warning'>Not Set</button>";
                } else {
                    return "<button class='btn btn-sm btn-primary'>Set</button>";            
                }      
            })
            ->rawColumns(['action','subject','class','stream','exam_type','question_status'])
            ->make(true);
    }

    // public function editExamForm($exam_id)
    // {
    //     try {
    //         $exam_id = decrypt($exam_id);
    //     }catch(DecryptException $e) {
    //         return redirect()->back();
    //     }
    //     $stream = Stream::get();
    //     $exam = Exam::find($exam_id);
    //     $classes = null;
    //     if (isset($exam->class_id) && !empty($exam->class_id)) {
            
    //         $stream_id = $exam->class->stream_id;
    //         if ($stream_id) {
    //             $classes = Classes::where('stream_id',$stream_id)->get();
    //         }
    //     }
    //     return view('admin.exam.exam_edit',compact('exam','stream','classes'));
    // }

    // public function updateExamForm(Request $request,$exam_id)
    // {
    //     $this->validate($request, [
    //         'exam_type'   => 'required',
    //         'stream' => 'required',
    //         'class' => 'required',
    //         'subject' => 'required',
    //         'title' => 'required',
    //         'total_mark' => 'required',
    //         'pass_mark' => 'required',
    //         'duration' => 'required',
    //     ]);
    //     if ($request->input('exam_type') == '2') {
    //         $this->validate($request, [
    //             's_date' => 'required',
    //             'e_date' => 'required',
    //         ]);
    //     }
    //     try {
    //         $exam_id = decrypt($exam_id);
    //     }catch(DecryptException $e) {
    //         return redirect()->back();
    //     }
    //     $org_id = Auth::guard('admin')->id();
    //     $exam = Exam::find($exam_id);
    //     $exam->class_id = $request->input('class');
    //     $exam->org_id = $org_id;
    //     $exam->subject_id = $request->input('subject');
    //     $exam->name = $request->input('title');
    //     if ($request->input('exam_type') == '2') {
    //         $exam->start_date = $request->input('s_date');
    //         $exam->end_date = $request->input('e_date');
    //     }
    //     $exam->exam_type = $request->input('exam_type');
    //     $exam->total_mark = $request->input('total_mark');
    //     $exam->pass_mark = $request->input('pass_mark');
    //     $exam->duration = $request->input('duration');
    //     $exam->exam_status = 1;
    //     if ($exam->save()) {
    //         return redirect()->back()->with('message','Exam Data Updated Successfully ');
    //     } else {
    //         return redirect()->back()->with('error','Something Went Wrong Please Try Again');
    //     }
    // }

    public function viewQuestion($exam_id)
    {
        try {
            $exam_id = decrypt($exam_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        // $org_id = Auth::guard('admin')->id();
        $exam = BidyaExam::find($exam_id);
        return view('admin.bidya_exam.question_details',compact('exam'));
    }

    public function addQuestionForm($exam_id)
    {
        try {
            $exam_id = decrypt($exam_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $total_question = BidyaExamQuestion::where('bidya_exam_id',$exam_id)->count();
        $total_question_mark = BidyaExamQuestion::where('bidya_exam_id',$exam_id)->sum('mark');
        $exam = BidyaExam::where('id',$exam_id)->first();
        return view('admin.bidya_exam.add_question',compact('exam','total_question','total_question_mark'));
    }

    public function insertQuestion(Request $request)
    {
        $this->validate($request, [
            'question_type'   => 'required',
            'question_mark' => 'required',
            'exam_id'=>'required',
        ]);

        $question_type = $request->input('question_type'); 
        $question_mark = $request->input('question_mark'); 
        
        //Validation of exam mark 
        $total_question_mark = BidyaExamQuestion::where('bidya_exam_id',$request->input('exam_id'))->sum('mark');
        $exam = BidyaExam::where('id',$request->input('exam_id'))->first();
      
        if ($exam->total_mark < ($total_question_mark+$question_mark) ) {
            return redirect()->back()->with('error','Mark of question Can Not be greater Then Exam Mark');
        }

        if ($question_type == '1') {
            $this->validate($request, [
                'question'   => 'required',
            ]);
            $question = $request->input('question');
        } else {
            $this->validate($request, [
                'question' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:200',
            ]);
            $question = $request->file('question');
           
        }
        $is_correct = $request->input('is_correct');
        
        for ($i=1 ; $i <= 4 ; $i++ ) { 
            if ($i <= 2) {
                $this->validate($request, [
                    'answer_type'.$i   => 'required',
                ]);
            } 
           $answer_type = $request->input('answer_type'.$i);
            if (isset($answer_type) && !empty($answer_type)) {
                if ($answer_type == '2') {
                    if ($i <= 2) {
                        $this->validate($request, [
                            'option'.$i   => 'required',
                        ]);
                    } 
                    $this->validate($request, [
                        'option'.$i   => 'image|mimes:jpeg,png,jpg,gif,svg|max:200',
                    ]);                    
                    $answer = $request->file('option');                    
                }else{
                    if ($i <= 2) {
                        $this->validate($request, [
                            'option'.$i   => 'required',
                        ]);
                    } 
                }
            }
        }
        $org_id = Auth::guard('admin')->id();
        $exam_id = $request->input('exam_id');

        $question_insert = new BidyaExamQuestion();
        $question_insert->bidya_exam_id = $exam_id;
        $question_insert->question_type = $question_type;
        if ($question_type == 2) {
            $file = $question;  
            $file_name = $i.time().date('Y-M-d').'.'.$file->getClientOriginalExtension();
            $file->storeAs('question_file/', $file_name);
            $question_insert->question = $file_name;
        } else {
            $question_insert->question = $question;
        }        
        $question_insert->mark = $question_mark;
        if ($question_insert->save()) {
            $correct_answer_id = null;
            
            for ($i=1 ; $i <= 4 ; $i++ ) {

               $answer_type = $request->input('answer_type'.$i);
                if (isset($answer_type) && !empty($answer_type)) {
                    if ($answer_type == '2') {      
                        if($request->hasfile('option'.$i)) {

                            $file = $request->file('option'.$i);  
                            $file_name = $i.time().date('Y-M-d').'.'.$file->getClientOriginalExtension();
                            $file->storeAs('question_file/', $file_name);
                            
                            $answer_insert = new BidyaQuestionOption();
                            $answer_insert->bidya_exam_question_list_id = $question_insert->id;
                            $answer_insert->option = $file_name;
                            $answer_insert->option_type = $answer_type;
                            if ($answer_insert->save()) {
                                if ($is_correct == $i) {
                                    
                                    $correct_answer_id = $answer_insert->id;
                                }
                            }
                        }                                                    
                    }else{
                        $answer = $request->input('option'.$i);
                        if (!empty($answer)) {
                            $answer_insert = new BidyaQuestionOption();
                            $answer_insert->bidya_exam_question_list_id = $question_insert->id;
                            $answer_insert->option = $answer;
                            $answer_insert->option_type = $answer_type;
                            if ($answer_insert->save()) {
                                if ($is_correct == $i) {
                                    $correct_answer_id = $answer_insert->id;

                                }
                            }
                        }  
                    }
                }
            }
            $question_update = BidyaExamQuestion::find($question_insert->id);
            $question_update->correct_answer_id = $correct_answer_id;
            $question_update->save();    
            
            if ($exam->total_mark == ($total_question_mark+$question_mark) ) {
                $exam = BidyaExam::find($request->input('exam_id'));
                $exam->exam_status = '2';
                $exam->save();
            }
    

            return redirect()->back()->with('message','Question Added Successfully');
        }else{
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
        
        
    }
    

    public function editQuestionForm($question_id)
    {
        $question =  BidyaExamQuestion::where('id',$question_id)->first();
        return view('admin.bidya_exam.edit_question',compact('question'));
    }
    public function updateQuestion(Request $request)
    {
        
        $this->validate($request, [
            'question_type'   => 'required',
            'question_mark' => 'required',
            'question_id'=>'required',
            'exam_id'=>'required',
        ]);
        // dd(1);
        $question_type = $request->input('question_type'); 
        $question_mark = $request->input('question_mark'); 
        $question_id = $request->input('question_id');
        $exam_id = $request->input('exam_id');
        //Validation of exam mark 
        $total_question_mark = BidyaExamQuestion::where('bidya_exam_id',$request->input('exam_id'))->where('id','!=',$question_id)->sum('mark');
        
        $exam = BidyaExam::where('id',$request->input('exam_id'))->first();
        if ($exam->total_mark < ($total_question_mark+$question_mark) ) {
            return redirect()->back()->with('error','Total Count Mark of question Can Not be greater Then Exam Mark');
        }

        if ($question_type == '1') {
            $this->validate($request, [
                'question'   => 'required',
            ]);
            $question = $request->input('question');

        } else {
            $this->validate($request, [
                'question' => 'image|mimes:jpeg,png,jpg,gif,svg|max:200',
            ]);  
            $question = $request->file('question');         
        }
        $is_correct = $request->input('is_correct');
        $total_options = BidyaQuestionOption::where('bidya_exam_question_list_id',$question_id)->count();
        for ($i=1 ; $i <= $total_options ; $i++ ) { 
            $this->validate($request, [
                'answer_type'.$i   => 'required',
                'option_id'.$i   => 'required',
            ]);

           $answer_type = $request->input('answer_type'.$i);
            if (isset($answer_type) && !empty($answer_type)) {
                if ($answer_type == '2') { 
                    $this->validate($request, [
                        'option'.$i   => 'image|mimes:jpeg,png,jpg,gif,svg|max:200',
                    ]);                                        
                }else{
                    $this->validate($request, [
                        'option'.$i   => 'required',
                    ]);
                }
            }
        }

        
        if ($question_type == 2) {
            
            $question_update = BidyaExamQuestion::find($question_id);
            if ($request->hasFile('question')) {
                $file = $question;  
                $file_name = $i.time().date('Y-M-d').'.'.$file->getClientOriginalExtension();
                $file->storeAs('question_file/', $file_name);
                $question_update->question = $file_name;
            }
            $question_update->question_type = $question_type;
            $question_update->correct_answer_id = $is_correct;
            $question_update->mark = $question_mark;
            $question_update->save();
            
        } else {
            $question_update = BidyaExamQuestion::find($question_id);
            $question_update->question = $question;
            $question_update->question_type = $question_type;
            $question_update->correct_answer_id = $is_correct;
            $question_update->mark = $question_mark;
            $question_update->save();
        }  
        
        for ($i=1 ; $i <= $total_options ; $i++ ) { 

            $option_id = $request->input('option_id'.$i);
            $answer_type = $request->input('answer_type'.$i);
            if (isset($answer_type) && !empty($answer_type) && isset($option_id) && !empty($option_id)) {
                if ($answer_type == '2') { 
                    $answer_update = BidyaQuestionOption::find($option_id);                    
                    $answer_update->option_type = $answer_type;

                    if($request->hasfile('option'.$i)) {

                        $file = $request->file('option'.$i);  
                        $file_name = $i.time().date('Y-M-d').'.'.$file->getClientOriginalExtension();
                        $file->storeAs('question_file/', $file_name);
                        
                        $answer_update->option = $file_name;                        
                    }     
                    $answer_update->save();

                }else{
                    $answer_update = BidyaQuestionOption::find($option_id);                    
                    $answer_update->option_type = $answer_type;
                    $answer_update->option = $request->input('option'.$i);
                    $answer_update->save();
                }
            }
        }
        return redirect()->back()->with('message','Question Updated Successfully');

    }

    public function addOtherOrgStudent($exam_id)
    {
        try {
            $exam_id = decrypt($exam_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        // $org_id = Auth::guard('admin')->id();
        $exam = BidyaExam::find($exam_id);
        $other_org_student = BidyaExamPermission::where('exam_id',$exam_id)->orderBy('id','desc')->get();

        return view('admin.bidya_exam.other_org_student_add',compact('exam','other_org_student'));
    }

    public function addOtherOrgStudentForm($exam_id)
    {
        try {
            $exam_id = decrypt($exam_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $exam = BidyaExam::find($exam_id);
        return view('admin.bidya_exam.add_other_org_student',compact('exam'));
    }

    public function checkOtherOrgStudent($exam_id,$login_id)
    { 
        $student = null;
        
        if (BidyaExamPermission::where('login_id',$login_id)->where('exam_id',$exam_id)->count() > 0) {
           return 1;
        }else{
            return 2; //means No student Found
        } 
    }

    public function insertOtherOrgStudent(Request $request)
    {
        $this->validate($request, [
            'exam_id'   => 'required',
            'student_id' => 'required',
            'password' => 'required',
            'name' => 'required',
        ]);

        $student_id = $request->input('student_id'); 
        $exam_id = $request->input('exam_id'); 

        $permission_check = BidyaExamPermission::where('exam_id',$exam_id)->where('login_id',$student_id)->count();
        if ($permission_check == 0) {
            $permission = new BidyaExamPermission();        
            $permission->exam_id = $exam_id;
            $permission->login_id = strtolower(trim($student_id));
            $permission->password = strtolower(trim($request->input('password')));
            $permission->name = $request->input('name');
            $permission->email = $request->input('email');
            $permission->mobile = $request->input('mobile');
            $permission->father_name = $request->input('father_name');
            $permission->school_name = $request->input('school_name');
            $permission->class_name = $request->input('class_name');
            $permission->dob = $request->input('dob');
            $permission->gender = $request->input('gender');
            $permission->address = $request->input('address');
            $permission->save();
        }
        return redirect()->back()->with('message','Permission Of Exam Set Successfully');
        
    }

    
}

