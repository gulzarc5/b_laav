<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Model\Question;
use App\Model\LikeHistory;
use App\Model\Answer;
// use App\Model\ChatDetails;

class ChatController extends Controller
{
    public function chatList($page)
    {
        $total_rows = Question::count();
        $limit = ($page*15)-15;
        $total_page = ceil($total_rows/15);

        $question = Question::with('answer','user')->orderBy('id','desc')->skip($limit)->take(10)->get();
        
        $response = [
            'status' => true,
            'message' => 'Question Answer List',
            'data' => $question,
        ];    	
        return response()->json($response, 200);        
    }

    public function addMessage(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'user_id' => 'required',
            'subject' => 'required',
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

        $chatDetails = new Question();
        $chatDetails->user_id = $request->input('user_id');
        $chatDetails->subject = $request->input('subject');
        $chatDetails->message = $request->input('message');
        $chatDetails->save();

        $response = [
            'status' => true,
            'message' => 'Message Sent Successfully',
            'error_code' => false,
            'error_message' => null,
        ];    	
        return response()->json($response, 200);

    }

    public function ansLike($user_id,$answer_id)
    {
        $chk_like = LikeHistory::where('user_id',$user_id)->where('answer_id',$answer_id)->count();
        if ($chk_like == 0) {
            $answer = Answer::find($answer_id);
            $answer->like_count = $answer->like_count+1;
            $answer->save();

            $like_history = new LikeHistory();
            $like_history->user_id = $user_id;
            $like_history->answer_id = $answer_id;
            $like_history->save();
        }
        $response = [
            'status' => true,
        ];    	
        return response()->json($response, 200);  
    }
}
