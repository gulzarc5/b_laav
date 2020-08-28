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
    	            <h2>Edit Student</h2>
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
                    @if (isset($student) && !empty($student))                        
    	            <div class="x_content">
    	           
    	            	{{ Form::open(['method' => 'put','route'=>['admin.update_student','id'=>$student->id]]) }}
    	            	<input type="hidden" name="student_id" value="{{$student->id}}">
                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="organization">Select Organization <span style="color:red"> * </span></label>
                                    <select class="form-control" name="organization" id="organization">
                                        <option value="">Select Organization</option>
                                        @if (isset($organization) && !empty($organization))
                                            @foreach ($organization as $item)
                                                @if ($student->org_id == $item->id)
                                                <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                                @else    
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                    @if($errors->has('organization'))
                                          <span class="invalid-feedback" role="alert" style="color:red">
                                              <strong>{{ $errors->first('organization') }}</strong>
                                          </span>
                                      @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="name">Select Stream <span style="color:red"> * </span></label>
                                    <select class="form-control" name="stream" onchange="get_class_list(this.value)">
                                        <option value="">Select Stream</option>
                                        @if (isset($stream) && !empty($stream))
                                            @foreach ($stream as $item)
                                                @if ($student->class->stream->id == $item->id)
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
                                  <label for="class">Select Class <span style="color:red"> * </span></label>
                                  <select class="form-control" name="class" id="classes">
                                      <option value="">Select Class</option>
                                      @if (isset($class) && !empty($class))
                                        @foreach ($class as $item)
                                            @if ($student->class_id == $item->id)
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

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="mobile">Mobile Number <span style="color:red"> * </span></label>
                                    <input type="number" class="form-control" name="mobile"  placeholder="Enter Mobile Number"  value="{{ $student->mobile }}" >
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
                                    <input type="text" class="form-control" name="email"  placeholder="Enter Email"  value="{{ $student->email }}" >
                                    @if($errors->has('email'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                           
                        </div>

                        <div class="well" style="overflow: auto">
                            <div class="form-row mb-10">
                                
                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="s_name">Student Name <span style="color:red"> * </span></label>
                                    <input type="text" class="form-control" name="s_name"  placeholder="Enter Student Name"  value="{{ $student->name }}" >
                                    @if($errors->has('s_name'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('s_name') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="father_name">Father Name</label>
                                    <input type="text" class="form-control" name="father_name"  placeholder="Enter Father Name"  value="{{ $student->father_name }}" >
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
                                    <input type="text" class="form-control" name="mother_name"  placeholder="Enter Mother Name"  value="{{ $student->mother_name }}" >
                                    @if($errors->has('mother_name'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('mother_name') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                    <label for="dob">Date Of Birth <span style="color:red"> * </span></label>
                                    <input type="date" class="form-control" name="dob"  placeholder="Enter Date Of Birth"  value="{{ $student->dob }}" >
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
                                    <textarea class="form-control" rows="4" name="address" placeholder="Type Address">{{ $student->address }}</textarea>
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
                                    <input type="text" class="form-control" name="state"  placeholder="Enter State Name" value="{{$student->state}}">
                                    @if($errors->has('state'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('state') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" name="city"  placeholder="Enter City Name"  value="{{$student->city}}">
                                    @if($errors->has('city'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('city') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                    <label for="pin">Enter Pin No.</label>
                                    <input type="number" class="form-control" name="pin"  placeholder="Enter Pin No" value="{{$student->pin}}" >
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
                    @endif
    	        </div>
    	    </div>
    	</div>
    	{{-- <div class="col-md-2"></div> --}}
    </div>
</div>


 @endsection

 @section('script')
 <script>
      function get_class_list(stream_id) {
        var org_id = $("#organization").val();
        if (org_id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "GET",
                url: "{{ url('admin/class/list/ajax/') }}/"+ stream_id+"/"+org_id,
                dataType: 'json',
                beforeSend: function () {
                    $("#classes").html('');
                },
                success: function (response) {
                    var data=response;
                    if (!$.isEmptyObject(data)) {
                        var state_html = '<option value=""> Select Class</option>';
                        $.each(data, function(i, e) {
                            state_html += '<option value="' + e.id + '">' + e.name + '</option>';
                        });
                        $("#classes").html(state_html);
                    }else{
                        $("#classes").html('<option ""> No Sub Category Found </option>');
                    }
                }
            }) 
        }
        
    }
 </script>
@endsection



        
    