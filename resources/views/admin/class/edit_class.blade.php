@extends('admin.template.admin_master')

@section('content')
<style>
    .error{
        color:red;
    }
</style>
<div class="right_col" role="main">
    <div class="row">
    	{{-- <div class="col-md-2"></div> --}}
    	<div class="col-md-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
    	            <h2>Edit Class</h2>
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
                        @if (isset($class) && !empty($class))
                            
    	            	{{ Form::open(['method' => 'put','route'=>['admin.update_class','id'=>$class->id]]) }}
                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                  <label for="name">Select Stream</label>
                                  <select class="form-control" name="stream">
                                      <option value="">Select Stream</option>
                                      @if (isset($stream) && !empty($stream))
                                          @foreach ($stream as $item)
                                            @if ($class->stream_id == $item->id)
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

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="name">Class Name</label>
                                    <input type="text" class="form-control" name="name"  placeholder="Enter Class Name"  value="{{$class->name }}" >
                                    @if($errors->has('name'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @enderror
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
    	{{-- <div class="col-md-2"></div> --}}
    </div>
</div>


 @endsection

@section('script')
 @endsection


        
    