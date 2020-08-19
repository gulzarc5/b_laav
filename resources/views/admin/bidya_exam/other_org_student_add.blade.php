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
              <h2>Bidya Laav Other Organization Students</h2>
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
                                @if ($exam->exam_type == '1')
                                    <button class="btn btn-sm btn-warning"> Free User </button>
                                @else
                                    <button class="btn btn-sm btn-primary"> Premium</button>
                                @endif
                            </h5>
                            <h5 class="col-md-8 col-sm-12 col-xs-12"><strong>Class:</strong>
                                    @foreach ($exam->examClass as $item)
                                        {{$item->class->name}} || 
                                    @endforeach
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
                    <h2 style="float: left">Student List</h2>
                    <h2 style="float: right"><a href="{{route('admin.add_other_org_student_form',['exam_id'=>encrypt($exam->id)])}}" class="btn btn-sm btn-info">Add Other Organization Student</a></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
           
                    <div class="col-md-12 col-sm-12 col-xs-12" style="border:0px solid #e5e5e5;">
                        <div class="row product-view-tag">
                            
                            <table id="category" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <th>Organization Name</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>  
                                  @if (isset($other_org_student) && !empty($other_org_student))
                                  @php
                                    $count=1;
                                  @endphp
                                      @foreach ($other_org_student as $item)
                                          <tr>
                                            <td>{{$count++}}</td>
                                            <td>{{$item->student->name}}</td>
                                            <td>
                                              @if (isset($item->student_id) && !empty($item->student_id))
                                                  {{$item->student->class->name}}
                                              @endif
                                            </td>
                                            <td>
                                                @if (isset($item->student_id) && !empty($item->student_id))
                                                    {{$item->student->org->name}}
                                                @endif
                                              </td>
                                            <td>{{$item->created_at}}</td>
                                            <td>
                                              <a href="" class="btn btn-sm btn-danger">Remove Permission</a>
                                            </td>
                                          </tr>
                                      @endforeach
                                    
                                  @endif                   
                                </tbody>
                              </table>
                                           
                        </div>
                    </div> 
                      
                </div>
            </div>
        </div>


        
    </div>
    </div>
  </div>
  <!-- /page content -->

 @endsection

@section('script')
    <script type="text/javascript">
        $(function () {
        var table = $('#category').DataTable();
    });
    </script>
    @include('admin.script.add_question_script');
@endsection