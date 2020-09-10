<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Model\Question;
use App\Model\Answer;

class ChatController extends Controller
{
    public function list()
    {
        return view('admin.question_answer.question_list');
    }

    public function listAjax(Request $request)
    {
        return datatables()->of(Question::orderBy('id','desc')->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                if ($row->is_answered == '1') {
                    $btn ='<a href="'.route('admin.add_ans_form',['q_id'=>$row->id]).'" class="btn btn-warning btn-sm" target="_blank">Send Answer</a>';
                } else {
                    $btn ='<a href="'.route('admin.ans_view',['q_id'=>$row->id]).'" class="btn btn-warning btn-sm" target="_blank">View Answer</a>';
                } 
                return $btn;
            })->addColumn('status_tab', function($row){
                if ($row->is_answered == '1') {
                    return "<a class='btn btn-sm btn-warning'> No </a>";
                } else {                   
                    return "<a class='btn btn-sm btn-success'> Yes </a>";
                }
            })->addColumn('student_name', function($row){
                return $row->user->name;
            })
            ->rawColumns(['action','status_tab','student_name'])
            ->make(true);
    }

    public function addAnsForm($q_id)
    {
        $question = Question::find($q_id);
        return view('admin.question_answer.add_answer',compact('question'));
    }

    public function insertAnswer(Request $request)
    {
        $this->validate($request, [
            'q_id' => 'required',
            'answer' => 'required',
        ]);

        $answer = new Answer();
        $answer->question_id = $request->input('q_id');
        $answer->answer =  $request->input('answer');
        $answer->save();

        $question = Question::find($request->input('q_id'));
        $question->is_answered = 2;
        $question->save();
        return redirect()->route('admin.question_list');
    }

    public function viewAns($q_id)
    {
        $question = Question::find($q_id);
        $answer = Answer::where('question_id',$q_id)->first();
        return view('admin.question_answer.view_answer',compact('question','answer'));
        
    }
}
