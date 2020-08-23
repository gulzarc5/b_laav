<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Validator;
use App\Model\User;
use App\Model\SubjectFile;
use App\Model\Classes;
use App\Model\Admin;
use File;
use Response;
use App\Model\RegRequest;
use App\Model\SubjectVideo;
use App\Model\StudentExam;
use App\Model\BidyaStudentExam;

class StudentController extends Controller
{
    public function orgList($user_id)
    {
        $user = User::where('id',$user_id)->first();
        $org = Admin::where('id','!=','1')->get(['id','name','image']);
        foreach ($org as $key => $value) {
            if ($value->id == $user->org_id) {
                $value->my_org = true;
            } else {
                $value->my_org = false;
            }            
        }
        $response = [
            'status' => true,
            'data' => $org,
        ];    	
        return response()->json($response, 200);
    }

    public function classList($org_id)
    {
        $class = Classes::with('subject')->where('org_id',$org_id)->get();
        $response = [
            'status' => true,
            'data' => $class,
        ];    	
        return response()->json($response, 200);
    }

    public function subjectFileList($user_id,$subject_id)
    {
        $user = User::where('id',$user_id)->first();

        $subject_file = SubjectFile::where('subject_id',$subject_id)->get();

        $response = [
            'status' => true,
            'data' => $subject_file,
        ];    	
        return response()->json($response, 200);
    }

    public function viewSubjectFile($file_name)
    {
        $path = storage_path('/app/subject_file/'.$file_name);
        if (!File::exists($path)) 
            $response = 404;

        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    public function subjectVideoList($user_id,$subject_id)
    {
        $user = User::where('id',$user_id)->first();
        $subject_video = SubjectVideo::where('subject_id',$subject_id)->orderBy('status','desc')->get();
        

        $response = [
            'status' => true,
            'data' => $subject_video,
        ];    	
        return response()->json($response, 200);
    }

    public function myExamList($user_id)
    {
       $data =  StudentExam::with('exam')->where('student_id',$user_id)->orderBy('id','desc')->limit(30)->get();
       $response = [
            'status' => true,
            'data' => $data,
        ];    	
        return response()->json($response, 200);
    }

    public function myBidyaExamList($user_id)
    {
       $data =  BidyaStudentExam::with('exam')->where('student_id',$user_id)->orderBy('id','desc')->limit(30)->get();
       $response = [
            'status' => true,
            'data' => $data,
        ];    	
        return response()->json($response, 200);
    }

}
