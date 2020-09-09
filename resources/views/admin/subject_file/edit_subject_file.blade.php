@extends('admin.template.admin_master')

@section('content')
<style>
    .error{
        color:red;
    }
</style>
<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-2"></div>
    	<div class="col-md-8" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
    	            <h2>Edit Subject File</h2>
    	            <div class="clearfix"></div>
    	        </div>
                <div>
                     @if (Session::has('message'))
                        <div class="alert alert-success" >{{ Session::get('message') }}</div>
                     @endif
                     @if (Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                     @endif

                </div>
    	        <div>
    	            <div class="x_content">
                        @if (isset($subject_file) && !empty($subject_file))
                            
    	            	{{ Form::open(['method' => 'put','route'=>['admin.subject_file_update','file_id'=>$subject_file->id],'enctype'=>'multipart/form-data']) }}
    	            	
                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="file_type">Select File type</label>
                                    <select class="form-control" name="file_type">
                                        <option value="1" {{$subject_file->status == '1' ? 'selected':''}}>Premium File</option>
                                        <option value="2" {{$subject_file->status == '2' ? 'selected':''}}>Sample File</option>
                                    </select>
                                    @if($errors->has('file_type'))
                                          <span class="invalid-feedback" role="alert" style="color:red">
                                              <strong>{{ $errors->first('file_type') }}</strong>
                                          </span>
                                    @enderror
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                  <label for="name">Select Stream</label>
                                  <select class="form-control" name="stream" onchange="get_class_list(this.value)">
                                      <option value="">Select Stream</option>
                                      @if (isset($stream) && !empty($stream))
                                          @foreach ($stream as $item)
                                            @if ($subject_file->subject->class->stream->id == $item->id)
                                            <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                            @else
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endif
                                          @endforeach
                                      @endif
                                  </select>
                                  @if($errors->has('stream'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('stream') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="name">Select Class</label>
                                    <select class="form-control" name="class" id="classes" onchange="get_subject_list(this.value)">
                                        <option value="">Select Class</option>
                                       @if (isset($class) && !empty($class))
                                           @foreach ($class as $item)
                                            @if ($subject_file->subject->class->id == $item->id)
                                            <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                            @else
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endif
                                           @endforeach
                                       @endif
                                    </select>
                                    @if($errors->has('class'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('class') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="subject">Select Subject</label>
                                    <select class="form-control" name="subject" id="subject" >
                                        <option value="">Select Subject</option>
                                        @if (isset($subject) && !empty($subject))
                                           @foreach ($subject as $item)
                                            @if ($subject_file->subject_id == $item->id)
                                            <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                            @else
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endif
                                           @endforeach
                                       @endif
                                    </select>
                                    @if($errors->has('subject'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('subject') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div id="sub_file_div">
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-3" >
                                        <label for="title">File Title</label>
                                        <input type="text" class="form-control" name="title"  placeholder="Enter File Title" value="{{$subject_file->name}}" required >
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-3" >
                                        <label for="file">Select File</label>
                                        <input type="file" class="form-control" name="file"  >
                                    </div>

                                   
                                </div>
                            </div>
                        </div>

    	            	<div class="form-group">    
                            <button type="submit" class='btn btn-success'>Submit</button>
    	            	</div>
    	            	{{ Form::close() }}
                        @endif

    	            </div>
    	        </div>
    	    </div>
    	</div>
    	<div class="col-md-2"></div>
    </div>
</div>


 @endsection

@section('script')
    @include('admin.script.subject_file_script');
@endsection


        
    