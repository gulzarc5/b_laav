<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Model\User;
use App\Model\BidyaExam;
use App\Model\BidyaStudentExam;
use App\Model\BidyaStudentExamDetail;
use App\Model\BidyaExamPermission;
use App\Model\BidyaExamQuestion;
use App\Model\BidyaQuestionOption;

use Auth;
use File;
use Response;

class BidyaExamController extends Controller
{
    public function examList($user_id)
    {
        $user = User::where('id',$user_id)->first();
        $exam = [];

        $exams = BidyaExam::where('exam_status',2)->orderBy('id','desc')->orderBy('exam_type', 'ASC')->limit(20);
        if ($exams->count() > 0) {
            $exams = $exams->get();
            foreach ($exams as $item) {
                $item->student_exam_status = 3; // 1 = exam started, 2 = ended, 3 = not started yet
                if (isset($item->student_exam->exam_status)) {
                    $item->student_exam_status = $item->student_exam->exam_status;
                }
                foreach ($item->examClass as $class) {
                    $class->class;
                    if ($class->class_id == $user->class_id) {
                        $exam[] = $item;
                       
                    }
                    
                }
            }
        }

        $response = [
            'status' => true,
            'data' => $exam,
        ];    	
        return response()->json($response, 200);        
    }

    public function examStart($exam_id,$user_id)
    {
        $org_id = 1;
        //check exam already started or not
        $exam = BidyaExam::where('id',$exam_id)->first();
        $user = BidyaExamPermission::where('id',$user_id)->first();

        $check_exam_end = BidyaStudentExam::where('student_id',$user_id)->where('bidya_exam_id',$exam_id)->first();
        if ($check_exam_end) {
            if ($check_exam_end->exam_status == '2') {
                $response = [
                    'status' => false,
                    'message' => 'Sorry Ypu Already Appeared The Exam',
                    'data' => null,
                ]; 
                return response()->json($response, 200);  
            }
        }

        //exam_type 1 = free user, 2 = premium user
        if ($exam->exam_type == '1') {
            $check_s_exam = BidyaStudentExam::where('student_id',$user_id)->where('bidya_exam_id',$exam_id)->count();
            if ($check_s_exam > 0) {
                //check exam ended or not
                $question = BidyaExamQuestion::with('options')->where('bidya_exam_id',$exam_id)->get();
                $appeared_exam = BidyaStudentExam::where('student_id',$user_id)->where('bidya_exam_id',$exam_id)->first();
                $appeared_question = BidyaStudentExamDetail::where('student_exam_id',$appeared_exam->id)->get();
                $data = [
                    'exam_status'=>2,
                    'student_exam_id' => $appeared_exam->id,
                    'questions'=>$question,
                    'appeared_question'=>$appeared_question,
                ];
                $response = [
                    'status' => true,
                    'message' => 'Exam Started',
                    'data' => $data,
                ]; 
                return response()->json($response, 200);  
            }else{
                $exam_start = new BidyaStudentExam();
                $exam_start->student_id = $user_id;
                $exam_start->bidya_exam_id = $exam_id;
                $exam_start->exam_status = 1;
                $exam_start->save();

                $question = BidyaExamQuestion::with('options')->where('bidya_exam_id',$exam_id)->get();
                $data = [
                    'exam_status'=>1,
                    'student_exam_id' => $exam_start->id,
                    'questions'=>$question,
                    'appeared_question'=>[],
                ];
                $response = [
                    'status' => true,
                    'message' => 'Exam Started',
                    'data' => $data,
                ]; 
                return response()->json($response, 200);  
            }
        } elseif($exam->exam_type == '2') {
            if (!$user) {
                $response = [
                    'status' => false,
                    'message' => 'Sorry Yor are not authorize to start Exam42',
                    'data' => null,
                ];             
                return response()->json($response, 200);  
            }
            $check_s_exam = BidyaStudentExam::where('student_id',$user_id)->where('bidya_exam_id',$exam_id)->count();
            if ($check_s_exam > 0) {
                //check exam ended or not
                $question = BidyaExamQuestion::with('options')->where('bidya_exam_id',$exam_id)->get();
                $appeared_exam = BidyaStudentExam::where('student_id',$user_id)->where('bidya_exam_id',$exam_id)->first();
                $appeared_question = BidyaStudentExamDetail::where('student_exam_id',$appeared_exam->id)->get();
                $data = [
                    'exam_status'=>2,
                    'student_exam_id' => $appeared_exam->id,
                    'questions'=>$question,
                    'appeared_question'=>$appeared_question,
                ];
                $response = [
                    'status' => true,
                    'message' => 'Exam Started',
                    'data' => $data,
                ]; 
                return response()->json($response, 200);  
            }else{
                $exam_start = new BidyaStudentExam();
                $exam_start->student_id = $user_id;
                $exam_start->bidya_exam_id = $exam_id;
                $exam_start->exam_status = 1;
                $exam_start->save();

                $question = BidyaExamQuestion::with('options')->where('bidya_exam_id',$exam_id)->get();
                $data = [
                    'exam_status'=>1,
                    'student_exam_id' => $exam_start->id,
                    'questions'=>$question,
                    'appeared_question'=>[],
                ];
                $response = [
                    'status' => true,
                    'message' => 'Exam Started',
                    'data' => $data,
                ]; 
                return response()->json($response, 200);  
            }
        }
        
    }

    public function submitQuestion($student_exam_id,$question_id,$answer_id)
    {
        $check_question_exam = BidyaStudentExamDetail::where('student_exam_id',$student_exam_id)->where('question_id',$question_id);
        if ($check_question_exam->count() > 0) {
            $question = BidyaExamQuestion::where('id',$question_id)->first();

            $question_submit = BidyaStudentExamDetail::where('student_exam_id',$student_exam_id)->where('question_id',$question_id)->first();
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
            $question = BidyaExamQuestion::where('id',$question_id)->first();

            $question_submit = new BidyaStudentExamDetail();
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
        $check_question_exam = BidyaStudentExamDetail::where('student_exam_id',$student_exam_id)->where('question_id',$question_id)->count();
        if ($check_question_exam > 0) {
            $question = BidyaExamQuestion::where('id',$question_id)->first();
            $question_submit = BidyaStudentExamDetail::where('student_exam_id',$student_exam_id)->where('question_id',$question_id)->first();
            $question_submit->answer_id = $answer_id;
            if ($question->correct_answer_id == $answer_id) {
                $question_submit->is_correct = 2;
                $question_submit->mark = $question->mark;
            }
            if($question_submit->save()){
                $total_mark_obtain = BidyaStudentExamDetail::where('student_exam_id',$student_exam_id)->where('is_correct',2)->sum('mark');
             
                $student_exam = BidyaStudentExam::find($student_exam_id);
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
            $question = BidyaExamQuestion::where('id',$question_id)->first();
            $question_submit = new BidyaStudentExamDetail();
            $question_submit->student_exam_id = $student_exam_id;
            $question_submit->question_id = $question_id;
            $question_submit->answer_id = $answer_id;
            if ($question->correct_answer_id == $answer_id) {
                $question_submit->is_correct = 2;
                $question_submit->mark = $question->mark;
            }
            if($question_submit->save()){
                $total_mark_obtain = BidyaStudentExamDetail::where('student_exam_id',$student_exam_id)->where('is_correct',2)->sum('mark');
               
                $student_exam = BidyaStudentExam::find($student_exam_id);
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

    public function examLoginCheck(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'exam_id' => 'required',
            'login_id' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => 'Validation Error',
                'error_code' => true,
                'error_message' => $validator->errors(),
            ];    	
            return response()->json($response, 200);
        }
        $login_id = strtolower(trim($request->input('login_id')));
        $password = strtolower(trim($request->input('password')));
        $exam_id = $request->input('exam_id');
        $check = BidyaExamPermission::where('exam_id',$exam_id)->where('login_id',$login_id)->where('password',$password);
        if ($check->count() > 0) {
            $user = $check->first();
            $response = [
                'status' => true,
                'message' => 'Login Success',
                'data' => [
                    'exam_user_id' => $user->id,
                ],
                'error_code' => false,
                'error_message' => null,
            ];    	
            return response()->json($response, 200);
        } else {
            $response = [
                'status' => false,
                'message' => 'User Id or Password Wrong',
                'error_code' => false,
                'error_message' => null,
            ];    	
            return response()->json($response, 200);
        }
        
    }
}
