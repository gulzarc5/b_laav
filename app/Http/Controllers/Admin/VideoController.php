<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\SubjectVideo;
use App\Model\Stream;
use Auth;
use DataTables;

class VideoController extends Controller
{
    public function listSubjectVideo()
    {
        return view('admin.subject_video.subject_video_list');
    }

    public function listSubjectVideoAjax(Request $request)
    {
        $org_id = Auth::guard('admin')->id();
        $subject_file = SubjectVideo::where('org_id',$org_id)->orderBy('id','desc');
        return datatables()->of($subject_file->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn ='<a href="#" class="btn btn-warning btn-sm" target="_blank">Edit</a>';
                
                return $btn;
            })->addColumn('subject', function($row){
                if (!empty($row->subject_id)){
                    return $row->subject->name;
                }else{
                    return null;
                }
            })
            ->addColumn('class', function($row){
                if (!empty($row->subject_id)){
                    return $row->subject->class->name;
                }else{
                    return null;
                }
            })
            ->addColumn('stream', function($row){
                if (!empty($row->subject_id)){
                    return $row->subject->class->stream->name;
                }else{
                    return null;
                }
            })->addColumn('video', function($row){
                return '<iframe id="player" type="text/html" width="200" height="200"
                src="http://www.youtube.com/embed/'.$row->video_id.'?enablejsapi=1&origin=http://example.com"
                frameborder="0"></iframe>';
            })
            ->rawColumns(['action','subject','class','stream','video'])
            ->make(true);
    }

    public function addSubjectVideo()
    {
        $stream = Stream::get();
        return view('admin.subject_video.add_subject_video',compact('stream'));
    }

    public function insertSubjectVideo(Request $request)
    {
        $this->validate($request, [
            'video_type'=>'required',
            'stream' => 'required',
            'class' => 'required',
            'subject' => 'required',
            'video_id.*' => 'required',
            'video_title.*' => 'required',
        ]);
        $video_id =  $request->input('video_id');
        $video_title =  $request->input('video_title');
        $video_description =  $request->input('video_description');
        $org_id = Auth::guard('admin')->id();
        $subject = $request->input('subject');
        $video_type = $request->input('video_type');
        for ($i=0; $i < count($video_id); $i++) { 
            if (isset($video_id[$i]) && !empty($video_id[$i])) {
                
                $subject_file = new SubjectVideo();
                $subject_file->subject_id = $subject;
                $subject_file->org_id = $org_id;
                $subject_file->video_id = $video_id[$i];
                $subject_file->title = $video_title[$i];
                if (isset($video_description[$i]) && !empty($video_description[$i])) {
                    $subject_file->description = $video_description[$i];
                }
                $subject_file->status = $video_type;
                $subject_file->save();

            }
        }

        return redirect()->back()->with('message','Subject Video Added Successfully');
    }

}
