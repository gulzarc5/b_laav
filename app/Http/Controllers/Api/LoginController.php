<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Model\User;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function userLogin(Request $request)
    {
        $user_email = $request->input('email');
        $user_pass = $request->input('password');  
        if (!empty($user_email) && !empty($user_pass) ) {
            $user = User::where('email',$user_email)->first();
            if ($user) {
                if(Hash::check($user_pass, $user->password)){ 
                    $user_update = User::where('id',$user->id)
                        ->update([
                        'api_token' => Str::random(60),
                    ]);
    
                    $user = User::where('id',$user->id)->first();
                    $response = [
                        'status' => true,
                        'message' => 'User Logged In Successfully',    
                        'data' => $user,
                    ];    	
                    return response()->json($response, 200);
                }else{
                    $response = [
                        'status' => false,
                        'message' => 'Email Id or password Wrong',   
                        'data' => null,
                    ];    	
                    return response()->json($response, 200);
                }
            }else{
                $response = [
                    'status' => false,
                    'message' => 'Email Id or password Wrong',  
                    'data' => null,  
                ];    	
                return response()->json($response, 200);
            }
        }else{
            $response = [
                'status' => false,
                'message' => 'Required Field Can Not be Empty',  
                'data' => null,  
            ];    	
            return response()->json($response, 200);
        }       
    }

    public function userProfile($user_id)
    {
        $user =  User::where('id',$user_id)->first();
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'father_name' => $user->father_name,
            'email' => $user->email,
            'mobile' => $user->mobile,
            'dob' => $user->dob,
            'address' => $user->address,
            'state' => $user->state,
            'city' => $user->city,
            'pin' => $user->pin,
        ];
        $msg = [
            'status' => true,
            'data' => $data,
        ];
        return $msg;
    }

    public function userProfileUpdate(Request $request)
    {
        $validator =  Validator::make($request->all(),[
	        'id' => 'required',
	        'name' => 'required',
	        'father_name' => 'required',
	        'mobile' => 'required',
	        'dob' => 'required',
	        'address' => 'required',
	        'state' => 'required',
	        'city' => 'required',
	        'pin' => 'required',
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => 'Required Field Can not be Empty',
                'error_code' => true,
                'error_message' => $validator->errors(),
            ];    	
            return response()->json($response, 200);
        }

        $user = User::find($request->input('id'));
        $user->name = $request->input('name');
        $user->father_name = $request->input('father_name');
        $user->mobile = $request->input('mobile');
        $user->dob = $request->input('dob');
        $user->address = $request->input('address');
        $user->state = $request->input('state');
        $user->city = $request->input('city');
        $user->pin = $request->input('pin');
        $user->save();

        $data = [
            'status' => true,
            'message' => 'User Updated Successfully',
            'error_code' => false,
            'error_message' => null,            
        ];
        return $data;
    }

    public function userPasswordChange(Request $request)
    {
        $validator =  Validator::make($request->all(),[
	        'user_id' => 'required',
            'current_pass' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8', 'same:confirm_password'],
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

        $user = User::where('id',$request->input('user_id'))->first();
        if ($user) {
            if(Hash::check($request->input('current_pass'), $user->password)){           
                $password_change = User::where('id',$request->input('user_id'))
                ->update([
                    'password' => Hash::make($request->input('confirm_password')),
                ]);

                if ($password_change) {
                    $response = [
                        'status' => true,
                        'message' => 'Password Changed Successfully',
                        'error_code' => false,
                        'error_message' => null,    
                    ];    	
                    return response()->json($response, 200);
                }else{
                    $response = [
                        'status' => false,
                        'message' => 'Something Went Wrong Please Try Again',
                        'error_code' => false,
                        'error_message' => null,    
                    ];    	
                    return response()->json($response, 200);
                }
            }else{           
                $response = [
                    'status' => false,
                    'message' => 'Current Password Does Not Matched',
                    'error_code' => false,
                    'error_message' => null,    
                ];    	
                return response()->json($response, 200);
           }
        } else {
            $response = [
                'status' => false,
                'message' => 'User Not Found Please Try Again',
                'error_code' => false,
                'error_message' => null,    
            ];    	
            return response()->json($response, 200);
        }
    }
}
