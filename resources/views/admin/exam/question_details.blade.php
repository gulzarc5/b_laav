@extends('admin.template.admin_master')

@section('content')
<style>
    .question-div{
        margin-top: 10px;
        margin-left: 32px;
        display: grid;
    }
    .question-option{
        padding-top: 5px;
    }
    .question-answer{
        background-color: #0bccff;
        color: white;
        border-radius: 11px;
        padding-left: 3px;
        padding-bottom: 3px;
    }
    .question-right{
        float: right;
    }
    .question-left{
        float: left;
    }
</style>

<div class="right_col" role="main">

    <div class="">
      
      <div class="clearfix"></div>

      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Exam Details</h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @if (isset($exam) && !empty($exam))
                    <div class="col-md-12 col-sm-12 col-xs-12" style="border:0px solid #e5e5e5;">
                        {{-- <h3 class="prod_title">{{$product->name}} <a href="#" class="btn btn-warning" style="float:right;margin-top: -8px;">Edit Product</a></h3>
                        <p>{{$product->p_short_desc}}</p> --}}
                        <div class="row product-view-tag">
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Exam Name:</strong> 
                                    {{$exam->name}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Stream:</strong> 
                                @if (isset($exam->class_id) && !empty($exam->class_id))
                                    {{$exam->class->stream->name}}
                                @endif
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Class:</strong>
                                @if (isset($exam->class_id) && !empty($exam->class_id))
                                    {{$exam->class->name}}
                                @endif
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Subject :</strong> 
                                @if (isset($exam->subject_id) && !empty($exam->subject_id))
                                    {{$exam->subject->name}}
                                @endif
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Start date :</strong> 
                                    {{$exam->start_date}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>End Date :</strong> 
                                    {{$exam->end_date}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Total Marks :</strong> 
                                    {{$exam->total_mark}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Pass Marks :</strong> 
                                    {{$exam->pass_mark}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Exam Duration (in minutes) :</strong> 
                                    {{$exam->duration}}
                            </h5>
                            <h5 class="col-md-4 col-sm-12 col-xs-12"><strong>Exam Type :</strong> 
                                @if ($exam->exxam_type == '1')
                                    <button class="btn btn-sm btn-warning"> Free User </button>
                                @else
                                    <button class="btn btn-sm btn-primary"> Premium</button>
                                @endif
                            </h5>
                            
                        </div>
                    </div>                
                @endif
            </div>
          </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Questions</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    @php
                        $questions = $exam->question;
                        $q_count = 1;
                    @endphp
                    @if (isset($questions) && !empty($questions))
                    <div class="col-md-12 col-sm-12 col-xs-12" style="border:0px solid #e5e5e5;">
                        <div class="row product-view-tag">
                        @foreach ($questions as $question)
                                <h5 class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <span class="question-left"><strong>Q.{{$q_count++}}.</strong> 
                                            @if ($question->question_type == 2)
                                                <img src="{{route('admin.view_file_question',['file_name'=>$question->question])}}" alt="" style="    max-width: 670px;">
                                            @else
                                                {{$question->question}}                                                
                                            @endif
                                        </span>
                                        <span class="question-right">
                                            Mark : {{$question->mark}}
                                        <a href="{{route('admin.edit_question_form',['question_id'=>$question->id])}}" class="btn btn-sm btn-warning">Edit</a>
                                        </span>
                                       
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 question-div">
                                        @php
                                            $options = $question->options;
                                            $option_count = 1;
                                        @endphp
                                        @if (isset($options) && !empty($options))
                                            @foreach ($options as $option)                                                
                                                <span class="question-option">
                                                    @if ($option->id == $question->correct_answer_id)
                                                        <strong class="question-answer">{{$option_count++}}</strong> 
                                                    @else
                                                        <strong>{{$option_count++}}</strong> 
                                                    @endif

                                                    @if ($option->option_type == '2')                                                        
                                                        <img src="{{route('admin.view_file_question',['file_name'=>$option->option])}}" alt="" style="    max-width: 670px;">
                                                    @else
                                                        {{$option->option}}
                                                    @endif
                                                </span>
                                            @endforeach
                                        @endif
                                    </div>
                                </h5>
                        @endforeach
                            <h5 class="col-md-12 col-sm-12 col-xs-12 question-right">
                                <span class="question-left"></span>
                                <span class="question-right"><strong>Total Mark</strong> {{$exam->question->sum('mark')}}</span>                                
                            </h5>                        
                        </div>
                    </div> 
                    @endif
                    
                    <h5 class="col-md-12 col-sm-12 col-xs-12 question-right">
                        <span class="add-q-btn" style="display:flex;justify-content:center;">
                            @if ($exam->question->sum('mark') < $exam->total_mark)
                            <a class="btn btn-sm btn-info" href="{{route('admin.add_question_form',['exam_id'=>encrypt($exam->id)])}}">Add Question</a>
                            @endif
                        </span>
                  </h5>    
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