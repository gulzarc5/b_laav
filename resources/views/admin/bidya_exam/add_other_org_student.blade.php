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
                        <h2>Add Student For <b style="color:green"> {{$exam->name}}</b></h2>
                    </div>
                    <div class="col-md-12">
                        @if (Session::has('message'))
                            <div class="alert alert-success" >{{ Session::get('message') }}</div>
                        @endif
                        @if (Session::has('error'))
                            <div class="alert alert-danger">{{ Session::get('error') }}</div>
                        @endif
                    </div>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                {{ Form::open(['method' => 'post','route'=>'admin.insert_other_org_student']) }}
    	           @if (isset($exam) && !empty($exam) )
                       	<input type="hidden" name="exam_id" value="{{$exam->id}}" id="exam_id_inpt">
                        
                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10" id="question-div">
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="student_id">Enter Student Login ID<span style="color:red"> * </span></label>
                                    <input type="text" class="form-control" id="login_id" name="student_id" onchange="check_student(this.value)">
                                    
                                    @if($errors->has('student_id'))
                                            <span class="invalid-feedback" role="alert" style="color:red">
                                                <strong>{{ $errors->first('student_id') }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <span id="student_info">
                                    
                                </span>

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="password">Enter Password<span style="color:red"> * </span></label>
                                    <input type="text" class="form-control" name="password">
                                    
                                    @if($errors->has('password'))
                                            <span class="invalid-feedback" role="alert" style="color:red">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                    @enderror
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="name">Enter Name<span style="color:red"> * </span></label>
                                    <input type="text" class="form-control" name="name">
                                    
                                    @if($errors->has('name'))
                                            <span class="invalid-feedback" role="alert" style="color:red">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                    @enderror
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="email">Enter Email</label>
                                    <input type="email" class="form-control" name="email">
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="mobile">Enter Mobile</label>
                                    <input type="number" class="form-control" name="mobile">
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="father_name">Father Name</label>
                                    <input type="text" class="form-control" name="father_name">
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="school_name">School Name</label>
                                    <input type="text" class="form-control" name="school_name">
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="class_name">Class Name</label>
                                    <input type="text" class="form-control" name="class_name">
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" class="form-control" name="dob">
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="gender">Gender </label>
                                    <p style="padding-bottom: 6px; margin-top: 8px;">
                                        Male:
                                        <input type="radio" class="flat" name="gender" id="genderM" value="M" checked="" required /> FeMale:
                                        <input type="radio" class="flat" name="gender" id="genderF" value="F" />
                                    </p>
                                </div> 

                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="address">Address</label>
                                    <textarea class="form-control" name="address"></textarea>
                                </div>
            
                                                
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