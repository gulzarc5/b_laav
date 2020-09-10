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
    	            <h2>Add Answer</h2>
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
                        @if (isset($question) && !empty($question))
                            
    	            	{{ Form::open(['method' => 'post','route'=>'admin.ans_insert']) }}
    	            	<input type="hidden" name="q_id" value="{{$question->id}}">
                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="name">Subject</label>
                                    <textarea class="form-control" disabled>{{$question->subject}}</textarea>                                  
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="name">Question</label>
                                    <textarea class="form-control" disabled>{{$question->message}}</textarea>                                  
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="name">Enter Answer</label>
                                    <textarea class="form-control" placeholder="Please Type Your Answer" name="answer"></textarea>   
                                    @if($errors->has('answer'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('answer') }}</strong>
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


        
    