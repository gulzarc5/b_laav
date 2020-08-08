@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">

    <div class="">
      
      <div class="clearfix"></div>

      <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Edit Question</h2>
                @if (Session::has('message'))
                    <div class="alert alert-success" >{{ Session::get('message') }}</div>
                @endif
                @if (Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @endif
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                {{ Form::open(['method' => 'post','route'=>'admin.update_bidya_question','enctype'=>'multipart/form-data']) }}
    	           @if (isset($question) && !empty($question) )
                       	<input type="hidden" name="question_id" value="{{$question->id}}">
                       	<input type="hidden" name="exam_id" value="{{$question->bidya_exam_id}}">
                        
                        <div class="well" style="overflow: auto">
                        
                        <div class="form-row mb-10" id="question-div">
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="question_type">Select Question type <span style="color:red"> * </span></label>
                                <select class="form-control" name="question_type" onchange="check_question_type(this.value)">
                                    <option value="">Select Question Type</option>
                                    <option value="1" {{$question->question_type == '1' ? 'selected':''}}>Text</option>
                                    <option value="2" {{$question->question_type == '2' ? 'selected':''}}>Image</option>
                                </select>
                                @if($errors->has('question_type'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('question_type') }}</strong>
                                        </span>
                                @enderror
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3" >
                                <label for="question_mark">Enter Mark <span style="color:red"> * </span></label>
                                <input type="number" class="form-control" name="question_mark" value="{{$question->mark}}">    
                                @if($errors->has('question_mark'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('question_mark') }}</strong>
                                        </span>
                                @enderror
                            </div>
            

                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3" id="question-input-div">     
                                <label for="question">Enter Question<span style="color:red"> * </span></label>
                                @if ($question->question_type == '1')                                    
                                    <textarea class="form-control" name="question"  placeholder="Enter Question">{{$question->question}}</textarea>  
                                @else
                                    <input type="file" class="form-control" name="question">
                                @endif     
                                @if($errors->has('question'))
                                        <span class="invalid-feedback" role="alert" style="color:red">
                                            <strong>{{ $errors->first('question') }}</strong>
                                        </span>
                                @enderror                      
                            </div>

                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3" style="text-align: center">
                                <h2>Options</h2>
                            </div>
                            @php
                                $options = $question->options;
                                $i=1;
                            @endphp
                            @if (@isset($options) && !empty($options))
                                @foreach ($options as $option)
                                    <input type="hidden" name="option_id{{$i}}" value="{{$option->id}}">
                                    <div id="option-div{{$i}}">
                                        <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                            <label for="question">Sl No<span style="color:red"> * </span></label>
                                            <input type="number" value="{{$i}}" class="form-control" disabled>                                   
                                        </div>
                                        <div class="col-md-3 col-sm-12 col-xs-12 mb-3">
                                        <label for="answer_type">Select Answer type <span style="color:red"> * </span></label>
                                            <select class="form-control" name="answer_type{{$i}}" onchange="check_exam_type(this.value,{{$i}})">
                                                <option value="" selected>Select Answer Type</option>
                                                <option value="1"  {{$option->option_type == '1' ? 'selected':''}}>Text</option>
                                                <option value="2" {{$option->option_type == '2' ? 'selected':''}}>Image</option>
                                            </select>
                                            @error('answer_type'.$i)
                                                    <span class="invalid-feedback" role="alert" style="color:red">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-5 col-sm-12 col-xs-12 mb-3" id="option-input-div{{$i}}">
                                            <label for="option">Enter Option Value <span style="color:red"> * </span></label>
                                            @if ($option->option_type == '2')
                                                <input type="file"  class="form-control" name='option{{$i}}' >
                                            @else
                                                <input type="text"  class="form-control" name="option{{$i}}" value="{{$option->option}}"> 
                                            @endif  
                                            @error('option'.$i)
                                                    <span class="invalid-feedback" role="alert" style="color:red">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-xs-12 mb-3">
                                            <label for="is_correct">Is Correct <span style="color:red"> * </span></label>
                                            @if ($option->id == $question->correct_answer_id)
                                            <input type="radio" name="is_correct" value="{{$option->id}}" class="form-control" checked>   
                                            @else
                                            <input type="radio" name="is_correct" value="{{$option->id}}" class="form-control">   
                                            @endif                          
                                        </div>
                                    </div>   
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            @endif
                                
                            {{-- @for (; $i <= 4; $i++)
                               
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
                           
                             @endfor --}}
                                               
                        </div>
                        </div>
                       
                        

                    <div class="form-group"> 
                        <div id="for-msg-show-div">
                        </div>   
                        <div id="question-form-button">                            
                            {{-- <button type="button" class='btn btn-success' onclick="validate_add_question()">Submit</button> --}}
                        </div>
                        <button type="submit" class='btn btn-success'>Submit</button>
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