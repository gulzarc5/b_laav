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
    	            <h2>Add New Video File</h2>
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
    	           
    	            	{{ Form::open(['method' => 'post','route'=>'admin.insert_video_subject']) }}
    	            	
                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="video_type">Select video type</label>
                                    <select class="form-control" name="video_type">
                                        <option value="1">Premium video</option>
                                        <option value="2">Sample video</option>
                                    </select>
                                    @if($errors->has('video_type'))
                                          <span class="invalid-feedback" role="alert" style="color:red">
                                              <strong>{{ $errors->first('video_type') }}</strong>
                                          </span>
                                    @enderror
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                  <label for="name">Select Stream</label>
                                  <select class="form-control" name="stream" onchange="get_class_list(this.value)">
                                      <option value="">Select Stream</option>
                                      @if (isset($stream) && !empty($stream))
                                          @foreach ($stream as $item)
                                              <option value="{{$item->id}}">{{$item->name}}</option>
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
                                    </select>
                                    @if($errors->has('subject'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('subject') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div id="sub_file_div">
                                    {{-- <div class="col-md-12 col-sm-12 col-xs-12 mb-3" >
                                        <label for="title">File Title</label>
                                        <input type="text" class="form-control" name="title[]"  placeholder="Enter File Title"  required >
                                    </div> --}}

                                    <div class="col-md-10 col-sm-10 col-xs-12 mb-3" >
                                        <label for="video">Enter Video Title</label>
                                        <input type="text" class="form-control" name="video_title[]" placeholder="Enter Video Title" required >
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-12 mb-3" >
                                        <label for="video">Enter Video Id</label>
                                        <input type="text" class="form-control" name="video_id[]" placeholder="Enter Video Id" required >
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-12 mb-3" >
                                        <label for="video">Enter Video Description</label>
                                        <textarea type="text" class="form-control" name="video_description[]" placeholder="Enter Video Description" required ></textarea>
                                    </div>

                                    <div class="col-md-2 col-sm-2 col-xs-12 mb-3">
                                        <button type="button" class="btn btn-sm btn-warning" style="margin-top: 25px;" onclick="add_video_div()">Add more</button>
                                    </div>
                                </div>
                            </div>
                        </div>

    	            	<div class="form-group">    
                            <button type="submit" class='btn btn-success'>Submit</button>
    	            	</div>
    	            	{{ Form::close() }}

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


        
    