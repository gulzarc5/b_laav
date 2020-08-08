@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>Student Exams</h2>
    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <table id="subject" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Sl</th>
                              <th>Name</th>
                              <th>Stream</th>
                              <th>Class</th>
                              <th>Subject</th>
                              <th>Exam Date</th>
                              <th>Total Marks</th>
                              <th>Pass Marks</th>                              
                              <th>Marks Obtained</th>
                              <th>Exam Status</th>
                              <th>Result Status</th>
                              <th>Exam Type</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>  
                                              
                          </tbody>
                        </table>
    	            </div>
    	        </div>
    	    </div>
    	</div>
    </div>
	</div>


 @endsection

@section('script')
     
<script type="text/javascript">
  $(function () {

     var table = $('#subject').DataTable({
         processing: true,
         serverSide: true,
         iDisplayLength: 25,
         ajax: "{{ route('admin.student_exam_list_ajax') }}",
         columns: [
             {data: 'DT_RowIndex', name: 'DT_RowIndex'},      
             {data: 'exam_name', name: 'exam_name',searchable: true},    
             {data: 'stream', name: 'stream',searchable: true},          
             {data: 'class', name: 'class',searchable: true},
             {data: 'subject', name: 'subject',searchable: true}, 
             {data: 'created_at', name: 'created_at' ,searchable: true}, 
             {data: 'total_marks', name: 'total_marks' ,searchable: true}, 
             {data: 'pass_mark', name: 'pass_mark' ,searchable: true}, 
             {data: 'marks_obtain', name: 'marks_obtain' ,searchable: true}, 
             {data: 'exam_status', name: 'exam_status' ,searchable: true}, 
             {data: 'result_status', name: 'result_status' ,searchable: true}, 
             {data: 'exam_type', name: 'exam_type' ,searchable: true}, 
             {data: 'action', name: 'action' ,searchable: true}, 
         ]
     });            
  });
</script>    
    
 @endsection