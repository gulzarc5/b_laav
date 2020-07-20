<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Exam;
use App\Model\Stream;
use App\Model\Classes;
use App\Model\ExamQuestion;
use App\Model\QuestionOption;
use Auth;
use DataTables;
use File;
use Response;
use Storage;

class ExamController extends Controller
{
    public function listExams()
    {
        return view('admin.exam.exam_list');
    }
    public function addExamForm()
    {
        $stream = Stream::get();
        return view('admin.exam.add_new_exam',compact('stream'));
    }

    public function insertExam(Request $request)
    {
        $this->validate($request, [
            'exam_type'   => 'required',
            'stream' => 'required',
            'class' => 'required',
            'subject' => 'required',
            'title' => 'required',
            'total_mark' => 'required',
            'pass_mark' => 'required',
            'duration' => 'required',
        ]);
        if ($request->input('exam_type') == '2') {
            $this->validate($request, [
                's_date' => 'required',
                'e_date' => 'required',
            ]);
        }
        $org_id = Auth::guard('admin')->id();
        $exam = new Exam();
        $exam->class_id = $request->input('class');
        $exam->org_id = $org_id;
        $exam->subject_id = $request->input('subject');
        $exam->name = $request->input('title');
        if ($request->input('exam_type') == '2') {
            $exam->start_date = $request->input('s_date');
            $exam->end_date = $request->input('e_date');
        }
        $exam->exam_type = $request->input('exam_type');
        $exam->total_mark = $request->input('total_mark');
        $exam->pass_mark = $request->input('pass_mark');
        $exam->duration = $request->input('duration');
        $exam->exam_status = 1;
        if ($exam->save()) {
            return redirect()->back()->with('message','Exam Created Successfully Please Add Exam Question');
        } else {
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
        
    }

    public function listExamsAjax(Request $request)
    {
        $org_id = Auth::guard('admin')->id();
        $exams = Exam::where('org_id',$org_id)->orderBy('id','desc');
        return datatables()->of($exams->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn ='<a href="'.route('admin.edit_exam_form',['exam_id'=>encrypt($row->id)]).'" class="btn btn-warning btn-sm" target="_blank">Edit</a>
                <a href="'.route('admin.view_question',['exam_id'=>encrypt($row->id)]).'" class="btn btn-info btn-sm" target="_blank">View Questions</a>';
                
                return $btn;
            })->addColumn('stream', function($row){
                if (!empty($row->class_id)){
                    return $row->class->stream->name;
                }else{
                    return null;
                }
            })->addColumn('subject', function($row){
                if (!empty($row->subject_id)){
                    return $row->subject->name;
                }else{
                    return null;
                }
            })
            ->addColumn('class', function($row){
                if (!empty($row->class_id)){
                    return $row->class->name;
                }else{
                    return null;
                }
            })
            ->addColumn('stream', function($row){
                if (!empty($row->subject_id)){
                    return $row->subject->class->stream->name;
                }else{
                    return null;
                }
            })
            ->addColumn('exam_type', function($row){
                if ($row->exam_type == '1') {
                    return "<button class='btn btn-sm btn-warning'>Free</button>";
                } else {
                    return "<button class='btn btn-sm btn-primary'>Premium</button>";            
                }      
            }) ->addColumn('question_status', function($row){
                if ($row->exam_status == '1') {
                    return "<button class='btn btn-sm btn-warning'>Not Set</button>";
                } else {
                    return "<button class='btn btn-sm btn-primary'>Set</button>";            
                }      
            })
            ->rawColumns(['action','subject','class','stream','exam_type','question_status'])
            ->make(true);
    }

    public function editExamForm($exam_id)
    {
        try {
            $exam_id = decrypt($exam_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $stream = Stream::get();
        $exam = Exam::find($exam_id);
        $classes = null;
        if (isset($exam->class_id) && !empty($exam->class_id)) {
            
            $stream_id = $exam->class->stream_id;
            if ($stream_id) {
                $classes = Classes::where('stream_id',$stream_id)->get();
            }
        }
        return view('admin.exam.exam_edit',compact('exam','stream','classes'));
    }

    public function updateExamForm(Request $request,$exam_id)
    {
        $this->validate($request, [
            'exam_type'   => 'required',
            'stream' => 'required',
            'class' => 'required',
            'subject' => 'required',
            'title' => 'required',
            'total_mark' => 'required',
            'pass_mark' => 'required',
            'duration' => 'required',
        ]);
        if ($request->input('exam_type') == '2') {
            $this->validate($request, [
                's_date' => 'required',
                'e_date' => 'required',
            ]);
        }
        try {
            $exam_id = decrypt($exam_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $org_id = Auth::guard('admin')->id();
        $exam = Exam::find($exam_id);
        $exam->class_id = $request->input('class');
        $exam->org_id = $org_id;
        $exam->subject_id = $request->input('subject');
        $exam->name = $request->input('title');
        if ($request->input('exam_type') == '2') {
            $exam->start_date = $request->input('s_date');
            $exam->end_date = $request->input('e_date');
        }
        $exam->exam_type = $request->input('exam_type');
        $exam->total_mark = $request->input('total_mark');
        $exam->pass_mark = $request->input('pass_mark');
        $exam->duration = $request->input('duration');
        $exam->exam_status = 1;
        if ($exam->save()) {
            return redirect()->back()->with('message','Exam Data Updated Successfully ');
        } else {
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
    }

    public function viewQuestion($exam_id)
    {
        try {
            $exam_id = decrypt($exam_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $org_id = Auth::guard('admin')->id();
        $exam = Exam::find($exam_id);
        return view('admin.exam.question_details',compact('exam'));
    }

    public function addQuestionForm($exam_id)
    {
        try {
            $exam_id = decrypt($exam_id);
        }catch(DecryptException $e) {
            return redirect()->back();
        }
        $total_question = ExamQuestion::where('exam_id',$exam_id)->count();
        $total_question_mark = ExamQuestion::where('exam_id',$exam_id)->sum('mark');
        $exam = Exam::where('id',$exam_id)->first();
        return view('admin.exam.add_question',compact('exam','total_question','total_question_mark'));
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
        $total_question_mark = ExamQuestion::where('exam_id',$request->input('exam_id'))->sum('mark');
        $exam = Exam::where('id',$request->input('exam_id'))->first();
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

        $question_insert = new ExamQuestion();
        $question_insert->exam_id = $exam_id;
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
                            
                            $answer_insert = new QuestionOption();
                            $answer_insert->exam_question_list_id = $question_insert->id;
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
                            $answer_insert = new QuestionOption();
                            $answer_insert->exam_question_list_id = $question_insert->id;
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
            $question_update = ExamQuestion::find($question_insert->id);
            $question_update->correct_answer_id = $correct_answer_id;
            $question_update->save();    
            
            if ($exam->total_mark == ($total_question_mark+$question_mark) ) {
                $exam = Exam::find($request->input('exam_id'));
                $exam->exam_status = '2';
                $exam->save();
            }
    

            return redirect()->back()->with('message','Question Added Successfully');
        }else{
            return redirect()->back()->with('error','Something Went Wrong Please Try Again');
        }
        
        
    }
    
    public function viewQuestionFile($file_name)
    {
        $path = storage_path('app\question_file\\'.$file_name);
        if (!File::exists($path)) 
            $response = 404;

            $file = File::get($path);
            $type = File::mimeType($path);
            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
    }

    public function editQuestionForm($question_id)
    {
        $question =  ExamQuestion::where('id',$question_id)->first();
        return view('admin.exam.edit_question',compact('question'));
    }
    public function updateQuestion(Request $request)
    {
        $this->validate($request, [
            'question_type'   => 'required',
            'question_mark' => 'required',
            'question_id'=>'required',
            'exam_id'=>'required',
        ]);

        $question_type = $request->input('question_type'); 
        $question_mark = $request->input('question_mark'); 
        $question_id = $request->input('question_id');
        $exam_id = $request->input('exam_id');
        //Validation of exam mark 
        $total_question_mark = ExamQuestion::where('exam_id',$request->input('exam_id'))->where('id','!=',$question_id)->sum('mark');
        $exam = Exam::where('id',$request->input('exam_id'))->first();
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
        $total_options = QuestionOption::where('exam_question_list_id',$question_id)->count();
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
            
            $question_update = ExamQuestion::find($question_id);
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
            $question_update = ExamQuestion::find($question_id);
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
                    $answer_update = QuestionOption::find($option_id);                    
                    $answer_update->option_type = $answer_type;

                    if($request->hasfile('option'.$i)) {

                        $file = $request->file('option'.$i);  
                        $file_name = $i.time().date('Y-M-d').'.'.$file->getClientOriginalExtension();
                        $file->storeAs('question_file/', $file_name);
                        
                        $answer_update->option = $file_name;                        
                    }     
                    $answer_update->save();

                }else{
                    $answer_update = QuestionOption::find($option_id);                    
                    $answer_update->option_type = $answer_type;
                    $answer_update->option = $request->input('option'.$i);
                    $answer_update->save();
                }
            }
        }
        return redirect()->back()->with('message','Question Updated Successfully');

    }
}
