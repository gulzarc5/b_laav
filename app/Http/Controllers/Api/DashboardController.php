<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Model\User;
use App\Model\Admin;
use App\Model\Classes;
use App\Model\RegRequest;

class DashboardController extends Controller
{
    public function userDashboard($user_id)
    {
        $user = User::where('id',$user_id)->first();
        $org_id = $user->org_id;

        $org = Admin::where('id',$org_id)->first();

        $class = Classes::with('subject')->where('org_id',$org_id)->get();
        $classes = [];
        foreach ($class as $key => $value) {
            if ($value->id == $user->class_id) {
                $classes[] = $value;
            }
        }
        $org_images = Admin::where('id','!=','1')->get(['image','name']);
        $data = [
            'org_image' => $org->image,
            'class' => $classes,
            'org_images' => $org_images,
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
            'mobile' => 'required',
            'dob' => 'required',
            'address' => 'required',
            'city' => 'required',
            'pin' => 'required',

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

        $reg_request = new RegRequest();
        $reg_request->name = $request->input('name');
        $reg_request->father_name = $request->input('father_name');
        $reg_request->email = $request->input('email');
        $reg_request->mobile = $request->input('mobile');
        $reg_request->dob = $request->input('dob');
        $reg_request->address = $request->input('address');
        $reg_request->city = $request->input('city');
        $reg_request->pin = $request->input('pin');
        
        if ($reg_request->save()) {
             $response = [
                'status' => true,
                'message' => 'Request Sent Successfully',
                'error_code' => false,
                'error_message' => $validator->errors(),
            ];    	
            return response()->json($response, 200);
        } else {
             $response = [
                'status' => false,
                'message' => 'Something Went Wrong Please Try Again',
                'error_code' => true,
                'error_message' => $validator->errors(),
            ];    	
            return response()->json($response, 200);
        }
        

    }
}
