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
    	            <h2>Add New Bidya Exam</h2>
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
    	           
    	            	{{ Form::open(['method' => 'post','route'=>'admin.insert_bidya_exam']) }}
    	            	
                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="exam_type">Select Exam type <span style="color:red"> * </span></label>
                                    <select class="form-control" name="exam_type" >
                                        <option value="">Select Exam Type</option>
                                        <option value="1">Free User</option>
                                        <option value="2">Premium User</option>
                                    </select>
                                    @if($errors->has('exam_type'))
                                          <span class="invalid-feedback" role="alert" style="color:red">
                                              <strong>{{ $errors->first('exam_type') }}</strong>
                                          </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3" >
                                    <label for="title">Exam Title <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control" name="title"  placeholder="Enter Exam Title"   >
                                    @if($errors->has('title'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3" id="s_date">
                                    <label for="s_date">Exam Start Date <span style="color:red"> * </span></label>
                                    <input type="date" class="form-control" name="s_date"  placeholder="Enter Exam Start Date"   >
                                    @if($errors->has('s_date'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('s_date') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3" id="e_date">
                                    <label for="e_date">Exam End Date <span style="color:red"> * </span></label>
                                    <input type="date" class="form-control" name="e_date"  placeholder="Enter Exam End Date"   >
                                    @if($errors->has('e_date'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('e_date') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3" >
                                    <label for="total_mark">Total Mark <span style="color:red"> * </span></label>
                                    <input type="number" class="form-control" name="total_mark"  placeholder="Enter Total Mark"   >
                                    @if($errors->has('total_mark'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('total_mark') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3" >
                                    <label for="pass_mark">Pass Mark <span style="color:red"> * </span></label>
                                    <input type="number" class="form-control" name="pass_mark"  placeholder="Enter Pass Mark"   >
                                    @if($errors->has('pass_mark'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('pass_mark') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3" >
                                    <label for="duration">Exam Duration ()In Minutes <span style="color:red"> * </span></label>
                                    <input type="number" class="form-control" name="duration"  placeholder="Enter Exam Duration"   >
                                    @if($errors->has('duration'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('duration') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @if (isset($class) && !empty($class))
                                    @foreach ($class as $item)
                                    <div class="col-md-4 col-sm-12 col-xs-12 mb-3" >
                                        <label for="duration">{{$item->name}} 
                                            @if ($item->stream->name != "No Stream")
                                                ({{$item->stream->name}})
                                            @endif
                                            <span style="color:red"> * </span></label>
                                        <input type="checkbox"  name="class[]" value="{{$item->id}}">
                                    </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>

    	            	<div class="form-group">    
                            <button type="submit" class='btn btn-success'>Submit</button>
                        <a href="{{route('admin.bidya_exam_list')}}" class="btn btn-warning">Back</a>
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
    @include('admin.script.exam_script');
@endsection


        
    