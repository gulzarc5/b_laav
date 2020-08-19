@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">

    <div class="">
      
      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-2 col-sm-2 col-xs-12"></div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <div>
                        <h2>Add Other Organization Student For Exam {{$exam->name}}</h2>
                    </div>
                    <div class="col-md-12">
                        @if (Session::has('message'))
                            <div class="alert alert-success" >{{ Session::get('message') }}</div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger">{{ Session::get('error') }}</div>
                        @endif
                    <div>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                {{ Form::open(['method' => 'post','route'=>'admin.insert_other_org_student']) }}
    	           @if (isset($exam) && !empty($exam) )
                       	<input type="hidden" name="exam_id" value="{{$exam->id}}" id="exam_id_inpt">
                        
                        <div class="well" style="overflow: auto">
                            {{-- <div class="col-md-12 col-sm-12 col-xs-12" style="border:0px solid #e5e5e5;">
                                <div class="row product-view-tag">
                                    <h5 class="col-md-4 col-sm-4 col-xs-12">
                                            <span class="question-left"><strong>Exam Total Mark : </strong></span>
                                            <span class="question-right">{{$exam->total_mark}}</span>
                                    </h5>
                                </div>
                            </div>  --}}

                            <div class="form-row mb-10" id="question-div">
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="student_id">Enter Student Id/Email<span style="color:red"> * </span></label>
                                    <input type="text" class="form-control" name="student_id" onchange="check_student(this.value)">
                                    
                                    @if($errors->has('student_id'))
                                            <span class="invalid-feedback" role="alert" style="color:red">
                                                <strong>{{ $errors->first('student_id') }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <span id="student_info">
                                    
                                </span>
            
                                                
                            </div>
                        </div>
                       
                        

                    <div class="form-group" style="display: none" id="st_add_btn"> 
                        <div id="for-msg-show-div">
                        </div>   
                        <div id="question-form-button">                            
                            {{-- <button type="button" class='btn btn-success' onclick="validate_add_question()">Submit</button> --}}
                        </div>
                        <button type="submit" class='btn btn-success'>Submit</button>
                        <a href="{{route('admin.add_other_org_student',['exam_id'=>encrypt($exam->id)])}}" class="btn btn-warning">Back</a>
                    </div>

                    @endif 
                {{ Form::close() }}
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
  <!-- /page content -->

 @endsection
 @section('script')
    @include('admin.script.add_other_org_student_script');
@endsection