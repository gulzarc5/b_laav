<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Model\Chat;
use App\Model\ChatDetails;

class ChatController extends Controller
{
    public function chatList($user_id)
    {
        $chat = Chat::where('user_id',$user_id);

        if ($chat->count() > 0) {
            $chat = $chat->first();            
            $chat->details = ChatDetails::where('chat_id',$chat->id)->orderBy('id','desc')->limit(50)->get();
        } else {
            $chat = new Chat();
            $chat->user_id = $user_id;
            $chat->save();
            $chat->details = ChatDetails::where('chat_id',$chat->id)->orderBy('id','desc')->limit(50)->get();
        }
        $response = [
            'status' => true,
            'message' => 'chat list of user',
            'data' => $chat,
        ];    	
        return response()->json($response, 200);        
    }

    public function addMessage(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'chat_id' => 'required',
            'message' => 'required',
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
        $is_liked = $request->input('is_liked');

        $chatDetails = new ChatDetails();
        $chatDetails->chat_id = $request->input('chat_id');
        $chatDetails->message = $request->input('message');
        $chatDetails->user_type = 1;
        $chatDetails->save();

        $response = [
            'status' => true,
            'message' => 'Message Sent Successfully',
            'error_code' => false,
            'error_message' => null,
        ];    	
        return response()->json($response, 200);

    }

    public function likeMessage($chat_details_id,$is_liked)
    {
        $chat_details = ChatDetails::find($chat_details_id);
        $chat_details->is_liked_user = $is_liked;
        $chat_details->save();
        $response = [
            'status' => true,
        ];    	
        return response()->json($response, 200);  
    }
}
