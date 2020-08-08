@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">

    <div class="">
      
      <div class="clearfix"></div>

      <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Questions</h2>
                @if (Session::has('message'))
                    <div class="alert alert-success" >{{ Session::get('message') }}</div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @endif
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                {{ Form::open(['method' => 'post','route'=>'admin.insert_bidya_question','enctype'=>'multipart/form-data']) }}
    	           @if (isset($exam) && !empty($exam) )
                       	<input type="hidden" name="exam_id" value="{{$exam->id}}">
                        
                        <div class="well" style="overflow: auto">
                            <div class="col-md-12 col-sm-12 col-xs-12" style="border:0px solid #e5e5e5;">
                                <div class="row product-view-tag">
                                    <h5 class="col-md-4 col-sm-4 col-xs-12">
                                            <span class="question-left"><strong>Exam Total Mark : </strong></span>
                                            <span class="question-right">{{$exam->total_mark}}</span>
                                    </h5>
                                    <h5 class="col-md-4 col-sm-4 col-xs-12 question-right">
                                        <span class="question-left"></span>
                                        <span class="question-right"><strong>Total Question Added : </strong> {{$total_question}}</span>                                
                                    </h5>    
                                    <h5 class="col-md-4 col-sm-4 col-xs-12 question-right">
                                        <span class="question-left"></span>
                                        <span class="question-right"><strong>Total Mark Count: </strong> {{$total_question_mark}}</span>                                
                                    </h5>                        
                                </div>
                            </div> 
                        <h4 style="color: #0095ff;text-align: center;font-weight: bold;">Question No. {{$total_question+1}}</h4><hr>
                        <div class="form-row mb-10" id="question-div">
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="question_type">Select Question type <span style="color:red"> * </span></label>
                                <select class="form-control" name="question_type" onchange="check_question_type(this.value)">
                                    <option value="">Select Question Type</option>
                                    <option value="1" {{old('question_type') == '1' ? 'selected':''}}>Text</option>
                                    <option value="2" {{old('question_type') == '2' ? 'selected':''}}>Image</option>
                                </select>
                                @if($errors->has('question_type'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('question_type') }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3" >
                                <label for="question_mark">Enter Mark <span style="color:red"> * </span></label>
                                <input type="number" class="form-control" name="question_mark" value="{{old('question_mark')}}">    
                                @if($errors->has('question_mark'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('question_mark') }}</strong>
                                        </span>
                                @enderror
                            </div>
            

                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3" id="question-input-div">     
                                <label for="question">Enter Question<span style="color:red"> * </span></label>
                                <textarea class="form-control" name="question"  placeholder="Enter Question">{{old('question')}}</textarea>       
                                @if($errors->has('question'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('question') }}</strong>
                                        </span>
                                @enderror                      
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3" style="text-align: center">
                                <h2>Options</h2>
                            </div>
                           @for ($i = 1; $i <= 4; $i++)
                               
                            <div id="option-div{{$i}}">
                                    <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                        <label for="question">Sl No<span style="color:red"> * </span></label>
                                        <input type="number" value="{{$i}}" class="form-control" disabled>                                   
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12 mb-3">
                                    <label for="answer_type">Select Answer type <span style="color:red"> * </span></label>
                                        <select class="form-control" name="answer_type{{$i}}" onchange="check_exam_type(this.value,{{$i}})">
                                            <option value="" selected>Select Answer Type</option>
                                            <option value="1"  {{old('answer_type'.$i) == '1' ? 'selected':''}}>Text</option>
                                            <option value="2" {{old('answer_type'.$i) == '2' ? 'selected':''}}>Image</option>
                                        </select>
                                        @error('answer_type'.$i)
                                                <span class="invalid-feedback" role="alert" style="color:red">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-5 col-sm-12 col-xs-12 mb-3" id="option-input-div{{$i}}">
                                        <label for="option">Enter Option Value <span style="color:red"> * </span></label>
                                        <input type="text"  class="form-control" name="option{{$i}}" value="{{old('answer_type'.$i)}}">   
                                        @error('option'.$i)
                                                <span class="invalid-feedback" role="alert" style="color:red">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                        <label for="is_correct">Is Correct <span style="color:red"> * </span></label>
                                        @if ($i < 2)
                                        <input type="radio" name="is_correct" value="{{$i}}" class="form-control" checked>   
                                        @else
                                        <input type="radio" name="is_correct" value="{{$i}}" class="form-control">   
                                        @endif                          
                                    </div>
                            </div>    
                           
                             @endfor
                                               
                        </div>
                        </div>
                       
                        

                    <div class="form-group"> 
                        <div id="for-msg-show-div">
                        </div>   
                        <div id="question-form-button">                            
                            {{-- <button type="button" class='btn btn-success' onclick="validate_add_question()">Submit</button> --}}
                        </div>
                        <button type="submit" class='btn btn-success'>Submit</button>
                    <a href="{{route('admin.bidya_exam_list')}}" class="btn btn-warning">Back</a>
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
    @include('admin.script.add_question_script');
@endsection