<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Model\Subject;
use App\Model\Stream;
use App\Model\SubjectFile;
use File;
use DataTables;
use Response;
use Storage;

class SubjectController extends Controller
{
    public function listSubject()
    {
        $org_id = Auth::guard('admin')->id();
        $subject = Subject::where('org_id',$org_id)->orderBy('id','desc')->get();
        return view('admin.subject.subject_list',compact('subject'));
    }

    public function addSubject()
    {
        $stream = Stream::get();
        return view('admin.subject.add_subject',compact('stream'));
    }

    public function insertSubject(Request $request)
    {
        $this->validate($request, [
            'class' => 'required',
        ]);

       
        $name = $request->input('name');
        for ($i=0; $i < count($name); $i++) { 
            $subject = new Subject();
            $subject->name = $name[$i];
            $subject->class_id = $request->input('class');
            $subject->org_id = Auth::guard('admin')->id();
            $subject->save();
        }
       
        return redirect()->back()->with('message','Subject Added Successfully');
    }

    public function listSubjectFile()   
    {
        return view('admin.subject_file.subject_file_list');
    }

    public function listSubjectFileAjax(Request $request)
    {
        $org_id = Auth::guard('admin')->id();
        $subject_file = SubjectFile::where('org_id',$org_id)->orderBy('id','desc');
        return datatables()->of($subject_file->get())
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn ='<a href="#" class="btn btn-warning btn-sm" target="_blank">Edit</a>
                <a href="'.route('admin.view_file_subject',['file_name'=>$row->pdf_file]).'" class="btn btn-info btn-sm" target="_blank">View File</a>';
                
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
            })
            ->rawColumns(['action','subject','class','stream'])
            ->make(true);
    }

    public function addSubjectFile()
    {
        $stream = Stream::get();
        return view('admin.subject_file.add_subject_file',compact('stream'));
    }

    public function listSubjectAjax($class_id)
    {
        $org_id = Auth::guard('admin')->id();
        $subject = Subject::where('org_id',$org_id)->where('class_id',$class_id)->orderBy('id','desc')->get();
        return $subject;
    }

    public function insertSubjectFile(Request $request)
    {
        $this->validate($request, [
            'stream' => 'required',
            'class' => 'required',
            'subject' => 'required',
            'file.*' => 'required|mimes:pdf',
        ]);
        $file_title = $request->input('title');
        $files =  $request->file('file');
        $org_id = Auth::guard('admin')->id();
        $subject = $request->input('subject');
        $file_type = $request->input('file_type');
        for ($i=0; $i < count($file_title); $i++) { 
            if (isset($file_title[$i]) && !empty($file_title[$i])) {

                $file = $files[$i];  
                $file_name = $i.time().date('Y-M-d').'.'.$file->getClientOriginalExtension();
                $file->storeAs('subject_file/', $file_name);
                
                $subject_file = new SubjectFile();
                $subject_file->name = $file_title[$i];
                $subject_file->org_id = $org_id;
                $subject_file->subject_id = $subject;
                $subject_file->pdf_file = $file_name;
                $subject_file->status = $file_type;
                $subject_file->save();

            }
        }

        return redirect()->back()->with('message','Subject File Added Successfully');
    }

    public function viewSubjectFile ($file_name) {

        $path = storage_path('/app/subject_file/'.$file_name);
        if (!File::exists($path)) 
            $response = 404;

            $file = File::get($path);
            $type = File::mimeType($path);
            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
    }


}
