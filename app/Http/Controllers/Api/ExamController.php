<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Model\User;
use App\Model\Exam;
use App\Model\StudentExam;
use App\Model\ExamQuestion;
use App\Model\QuestionOption;

use App\Model\StudentExamDetail;
use Auth;
use File;
use Response;

class ExamController extends Controller
{
    public function examList($subject_id,$user_id)
    {
        $user = User::where('id',$user_id)->first();
        if ($user->status == '1') {
            $exams = Exam::where('subject_id',$subject_id)->where('exam_type',1)->where('exam_status',2)->orderBy('id','desc')->get();
        } else { 
            $exams = Exam::where('subject_id',$subject_id)->where('exam_type',2)->where('exam_status',2)->orderBy('id','desc')->get();
        }
        $response = [
            'status' => true,
            'data' => $exams,
        ];    	
        return response()->json($response, 200);        
    }

    public function examStart($exam_id,$user_id)
    {
        //check exam already started or not
        $exam = Exam::where('id',$exam_id)->first();
        $check_s_exam = StudentExam::where('student_id',$user_id)->where('exam_id',$exam_id)->count();
        if ($check_s_exam > 0) {
            //check exam ended or not
            $question = ExamQuestion::with('options')->where('exam_id',$exam_id)->get();
            $appeared_exam = StudentExam::where('student_id',$user_id)->where('exam_id',$exam_id)->first();
            $appeared_question = StudentExamDetail::where('student_exam_id',$appeared_exam->id)->get();
            $data = [
                'exam_status'=>2,
                'student_exam_id' => $appeared_exam->id,
                'questions'=>$question,
                'appeared_question'=>$appeared_question,
            ];
        }else{
            $exam_start = new StudentExam();
            $exam_start->org_id = $exam->org_id;
            $exam_start->student_id = $user_id;
            $exam_start->exam_id = $exam_id;
            $exam_start->exam_status = 1;
            $exam_start->save();

            $question = ExamQuestion::with('options')->where('exam_id',$exam_id)->get();
            $data = [
                'exam_status'=>1,
                'student_exam_id' => $exam_start->id,
                'questions'=>$question,
                'appeared_question'=>[],
            ];
        }        
        
        $response = [
            'status' => true,
            'data' => $data,
        ];    	
        return response()->json($response, 200);
    }

    public function submitQuestion($student_exam_id,$question_id,$answer_id)
    {
        $check_question_exam = StudentExamDetail::where('student_exam_id',$student_exam_id)->where('question_id',$question_id);
        if ($check_question_exam->count() > 0) {
            $question = ExamQuestion::where('id',$question_id)->first();

            $question_submit = StudentExamDetail::where('student_exam_id',$student_exam_id)->where('question_id',$question_id)->first();
            $question_submit->answer_id = $answer_id;
            if ($question->correct_answer_id == $answer_id) {
                $question_submit->is_correct = 2;
                $question_submit->mark = $question->mark;
            }
            if($question_submit->save()){
                $response = [
                    'status' => true,
                ];    	
                return response()->json($response, 200);  
            }else{
                $response = [
                    'status' => false,
                ];    	
                return response()->json($response, 200);  
            }
        }else{
            $question = ExamQuestion::where('id',$question_id)->first();

            $question_submit = new StudentExamDetail();
            $question_submit->student_exam_id = $student_exam_id;
            $question_submit->question_id = $question_id;
            $question_submit->answer_id = $answer_id;
            if ($question->correct_answer_id == $answer_id) {
                $question_submit->is_correct = 2;
                $question_submit->mark = $question->mark;
            }
            if($question_submit->save()){
                $response = [
                    'status' => true,
                ];    	
                return response()->json($response, 200);  
            }else{
                $response = [
                    'status' => false,
                ];    	
                return response()->json($response, 200);  
            }
        }
    }

    public function endExam($student_exam_id,$question_id,$answer_id)
    {
        $check_question_exam = StudentExamDetail::where('student_exam_id',$student_exam_id)->where('question_id',$question_id)->count();
        if ($check_question_exam > 0) {
            $question = ExamQuestion::where('id',$question_id)->first();
            $question_submit = StudentExamDetail::where('student_exam_id',$student_exam_id)->where('question_id',$question_id)->first();
            $question_submit->answer_id = $answer_id;
            if ($question->correct_answer_id == $answer_id) {
                $question_submit->is_correct = 2;
                $question_submit->mark = $question->mark;
            }
            if($question_submit->save()){
                $total_mark_obtain = StudentExamDetail::where('student_exam_id',$student_exam_id)->where('is_correct',2)->sum('mark');
             
                $student_exam = StudentExam::find($student_exam_id);
                $student_exam->marks_obtain = $total_mark_obtain;
                $student_exam->exam_status = 2;
                $student_exam->save();
                $response = [
                    'status' => true,
                    'message' => 'Exam Ended Successfully',
                ];    	
                return response()->json($response, 200);  
            }else{
                $response = [
                    'status' => false,
                    'message'=>'something Went Wrong Please Try Again',
                ];    	
                return response()->json($response, 200);  
            }
        }else{
            $question = ExamQuestion::where('id',$question_id)->first();
            $question_submit = new StudentExamDetail();
            $question_submit->student_exam_id = $student_exam_id;
            $question_submit->question_id = $question_id;
            $question_submit->answer_id = $answer_id;
            if ($question->correct_answer_id == $answer_id) {
                $question_submit->is_correct = 2;
                $question_submit->mark = $question->mark;
            }
            if($question_submit->save()){
                $total_mark_obtain = StudentExamDetail::where('student_exam_id',$student_exam_id)->where('is_correct',2)->sum('mark');
               
                $student_exam = StudentExam::find($student_exam_id);
                $student_exam->marks_obtain = $total_mark_obtain;
                $student_exam->exam_status = 2;
                $student_exam->save();
                $response = [
                    'status' => true,
                    'message' => 'Exam Ended Successfully',
                ];    	
                return response()->json($response, 200);  
            }else{
                $response = [
                    'status' => false,
                    'message'=>'something Went Wrong Please Try Again',
                ];    	
                return response()->json($response, 200);  
            }
        }
    }

    public function viewQuestionFile($file_name)
    {
        $path = storage_path('/app/question_file/'.$file_name);
        if (!File::exists($path)) 
            $response = 404;

        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }
}
