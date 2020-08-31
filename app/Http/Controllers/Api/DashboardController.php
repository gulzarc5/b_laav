<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Model\User;
use App\Model\Classes;
use App\Model\AppSetting;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function userDashboard($user_id)
    {        
        $video = AppSetting::find(1);
        $data = [
            'video' => $video,
        ];
        $response = [
            'status' => true,
            'data' => $data,
        ];    	
        return response()->json($response, 200);
    }

    public function regRequest(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'name' => 'required',
            'father_name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|digits:10',
            'dob' => 'required',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'pin' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => 'Validation Error',
                'data' => null,
                'error_code' => true,
                'error_message' => $validator->errors(),
            ];    	
            return response()->json($response, 200);
        }

        $reg_request = new User();
        $reg_request->name = $request->input('name');
        $reg_request->father_name = $request->input('father_name');
        $reg_request->email = $request->input('email');
        $reg_request->mobile = $request->input('mobile');
        $reg_request->dob = $request->input('dob');
        $reg_request->address = $request->input('address');
        $reg_request->state = $request->input('state');
        $reg_request->city = $request->input('city');
        $reg_request->pin = $request->input('pin');
        $reg_request->api_token = Str::random(60);
        
        if ($reg_request->save()) {

             $response = [
                'status' => true,
                'message' => 'Request Sent Successfully',
                'data' => $reg_request,
                'error_code' => false,
                'error_message' => $validator->errors(),
            ];    	
            return response()->json($response, 200);
        } else {
             $response = [
                'status' => false,
                'message' => 'Something Went Wrong Please Try Again',
                'data' => null,
                'error_code' => true,
                'error_message' => $validator->errors(),
            ];    	
            return response()->json($response, 200);
        }
        

    }
}
