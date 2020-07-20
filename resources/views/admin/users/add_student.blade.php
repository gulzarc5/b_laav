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
    	            <h2>Add New Product</h2>
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
    	           
    	            	{{ Form::open(['method' => 'post','route'=>'admin.insert_student']) }}
    	            	
                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="name">Select Stream <span style="color:red"> * </span></label>
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

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="user_type">Student Type <span style="color:red"> * </span></label>
                                    <select class="form-control" name="user_type" >
                                        <option value="">Select Type</option>
                                        <option value="1">Free User</option>
                                        <option value="2">Premium User</option>
                                    </select>
                                    @if($errors->has('user_type'))
                                          <span class="invalid-feedback" role="alert" style="color:red">
                                              <strong>{{ $errors->first('user_type') }}</strong>
                                          </span>
                                      @enderror
                                </div>
  
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                  <label for="class">Select Class <span style="color:red"> * </span></label>
                                  <select class="form-control" name="class" id="classes">
                                      <option value="">Select Class</option>
                                  </select>
                                  @if($errors->has('class'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('class') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="mobile">Mobile Number <span style="color:red"> * </span></label>
                                    <input type="number" class="form-control" name="mobile"  placeholder="Enter Email"  value="{{ old('mobile') }}" >
                                    @if($errors->has('mobile'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('mobile') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row mb-10">
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="email">Email <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control" name="email"  placeholder="Enter Email"  value="{{ old('email') }}" >
                                    @if($errors->has('email'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="password">Password <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control" name="password"  placeholder="Enter Password"  value="{{ old('password') }}" >
                                    @if($errors->has('password'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                           
                        </div>

                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="s_name">Student Name <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control" name="s_name"  placeholder="Enter Student Name"  value="{{ old('s_name') }}" >
                                    @if($errors->has('s_name'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('s_name') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="father_name">Father Name</label>
                                    <input type="text" class="form-control" name="father_name"  placeholder="Enter Father Name"  value="{{ old('father_name') }}" >
                                    @if($errors->has('father_name'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('father_name') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row mb-10">
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="mother_name">Mother Name</label>
                                    <input type="text" class="form-control" name="mother_name"  placeholder="Enter Mother Name"  value="{{ old('mother_name') }}" >
                                    @if($errors->has('mother_name'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('mother_name') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="dob">Date Of Birth <span style="color:red"> * </span></label>
                                    <input type="date" class="form-control" name="dob"  placeholder="Enter Date Of Birth"  value="{{ old('dob') }}" >
                                    @if($errors->has('dob'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('dob') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                           
                        </div>

                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <label for="address" required>Address</label>
                                    <textarea class="form-control" rows="4" name="address" placeholder="Type Address">{{ old('address') }}</textarea>
                                    @if($errors->has('address'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row mb-3">
                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                    <label for="state">State</label>
                                    <input type="text" class="form-control" name="state"  placeholder="Enter State Name" >
                                    @if($errors->has('state'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('state') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" name="city"  placeholder="Enter City Name"  >
                                    @if($errors->has('city'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                    <label for="pin">Enter Pin No.</label>
                                    <input type="number" class="form-control" name="pin"  placeholder="Enter Pin No"  >
                                    @if($errors->has('pin'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('pin') }}</strong>
                                        </span>
                                    @enderror
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
    	{{-- <div class="col-md-2"></div> --}}
    </div>
</div>


 @endsection

 @section('script')
 @include('admin.script.subject_script');
@endsection



        
    