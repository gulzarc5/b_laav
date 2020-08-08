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
    	<div class="col-md-12" style="margin-top:5px;">
    	    <div class="x_panel">

    	        <div class="x_title">
    	            <h2>Exam Edit Form</h2>
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
    	           
                        
                        @if (isset($exam) && !empty($exam))
                        @php
                            $stream_name = null;
                            if (!empty($exam->class_id)) {
                                $stream_name = $exam->class->stream_id;
                            }
                        @endphp
    	            	{{ Form::open(['method' => 'put','route'=>['admin.update_exam','exam_id'=>encrypt($exam->id)]]) }}
                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="exam_type">Select Exam type <span style="color:red"> * </span></label>
                                    <select class="form-control" name="exam_type" onchange="check_exam_type(this.value)">
                                        <option value="" selected>Select Exam Type</option>
                                        <option value="1" {{ $exam->exam_type == '1' ? 'selected' : ''}}>Free User</option>
                                        <option value="2" {{ $exam->exam_type == '2' ? 'selected' : ''}}>Premium User</option>
                                    </select>
                                    @if($errors->has('exam_type'))
                                          <span class="invalid-feedback" role="alert" style="color:red">
                                              <strong>{{ $errors->first('exam_type') }}</strong>
                                          </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                  <label for="name">Select Stream <span style="color:red"> * </span></label>
                                  <select class="form-control" name="stream" onchange="get_class_list(this.value)">
                                      <option value="">Select Stream</option>
                                      @if (isset($stream) && !empty($stream))
                                          @foreach ($stream as $item)
                                              <option value="{{$item->id}}" {{ $stream_name == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                                          @endforeach
                                      @endif
                                  </select>
                                  @if($errors->has('stream'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('stream') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="name">Select Class <span style="color:red"> * </span></label>
                                    <select class="form-control" name="class" id="classes" onchange="get_subject_list(this.value)">
                                        <option value="">Select Class</option>
                                        @if (isset($classes) && !empty($classes))
                                            @foreach ($classes as $item)
                                                <option value="{{$item->id}}" {{ $exam->class_id == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if($errors->has('class'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('class') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="subject">Select Subject <span style="color:red"> * </span></label>
                                    <select class="form-control" name="subject" id="subject" >
                                        <option value="">Select Subject</option>
                                        @if (isset($exam->class_id) && !empty($exam->class_id))
                                            @foreach ($exam->class->subject as $item)
                                                <option value="{{$item->id}}" {{ $exam->subject->id == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if($errors->has('subject'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('subject') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3" >
                                    <label for="title">Exam Title <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control" name="title"  placeholder="Enter Exam Title"  value="{{$exam->name}}">
                                    @if($errors->has('title'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3" id="s_date">
                                    <label for="s_date">Exam Start Date <span style="color:red"> * </span></label>
                                    <input type="date" class="form-control" name="s_date"  placeholder="Enter Exam Start Date"  value="{{$exam->start_date}}">
                                    @if($errors->has('s_date'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('s_date') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3" id="e_date">
                                    <label for="e_date">Exam End Date <span style="color:red"> * </span></label>
                                    <input type="date" class="form-control" name="e_date"  placeholder="Enter Exam End Date" value="{{$exam->end_date}}" >
                                    @if($errors->has('e_date'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('e_date') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3" >
                                    <label for="total_mark">Total Mark <span style="color:red"> * </span></label>
                                    <input type="number" class="form-control" name="total_mark"  placeholder="Enter Total Mark"  value="{{$exam->total_mark}}">
                                    @if($errors->has('total_mark'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('total_mark') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3" >
                                    <label for="pass_mark">Pass Mark <span style="color:red"> * </span></label>
                                    <input type="number" class="form-control" name="pass_mark"  placeholder="Enter Pass Mark"  value="{{$exam->pass_mark}}">
                                    @if($errors->has('pass_mark'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('pass_mark') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3" >
                                    <label for="duration">Exam Duration ()In Minutes <span style="color:red"> * </span></label>
                                    <input type="number" class="form-control" name="duration"  placeholder="Enter Exam Duration"  value="{{$exam->duration}}">
                                    @if($errors->has('duration'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('duration') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

    	            	<div class="form-group">    
                            <button type="submit" class='btn btn-success'>Submit</button>
                        <a href="{{route('admin.exam_list')}}" class="btn btn-warning">Back</a>
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
    @include('admin.script.exam_script');
@endsection


        
    