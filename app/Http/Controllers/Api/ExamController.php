<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Model\User;
use App\Model\Exam;
use Carbon\Carbon;

class ExamController extends Controller
{
    public function examList($subject_id,$user_id)
    {
        $user = User::where('id',$user_id)->first();
        if ($user->status == '1') {
            $exams = Exam::where('subject_id',$subject_id)->where('exam_type',1)->where('exam_status',2)->orderBy('id','desc')->get();
        } else { 
            $date = Carbon::now()->setTimezone('Asia/Kolkata')->toDateTimeString();
            $expired_exam = Exam::where('subject_id',$subject_id)->where('end_date','<',$date)->where('exam_type',2)->where('exam_status',2)->orderBy('id','desc')->limit(3)->get();

            $exams = Exam::where('subject_id',$subject_id)->where('end_date','>',$date)->where('exam_type',2)->where('exam_status',2)->orderBy('id','desc')->get();

            if ($expired_exam->count() > 0) {
                $exams = array_merge($expired_exam, $exams);
            }
        }
        $response = [
            'status' => true,
            'data' => $exams,
        ];    	
        return response()->json($response, 200);
        
    }
}
