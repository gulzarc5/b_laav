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
    	            <h2>Edit Subject</h2>
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
                        @if (isset($subject) && !empty($subject))
                            
    	            	{{ Form::open(['method' => 'put','route'=>['admin.update_subject','subject_id'=>$subject->id]]) }}
    	            	
                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                  <label for="name">Select Stream</label>
                                  <select class="form-control" name="stream" onchange="get_class_list(this.value)">
                                      <option value="">Select Stream</option>
                                      @if (isset($stream) && !empty($stream))
                                          @foreach ($stream as $item)
                                            @if ($subject->class->stream->id == $item->id)                                                
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
                                    <select class="form-control" name="class" id="classes" >
                                        <option value="">Select Class</option>
                                        @foreach ($class as $item)
                                            @if ($item->id == $subject->class_id)                                                
                                              <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                            @else                                                
                                              <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @if($errors->has('class'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('class') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div id="sub_div">
                                    <div class="col-md-12 col-sm-12 col-xs-12 mb-3" >
                                        <label for="name">Subject Name</label>
                                        <input type="text" class="form-control" name="name"  placeholder="Enter Subject Name" value="{{$subject->name}}"  required >
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
 @include('admin.script.subject_script');
@endsection

        
    