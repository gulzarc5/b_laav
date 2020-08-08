@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>List of Bidya Exams</h2>
                    <a class="btn btn-sm btn-info" style="float: right" href="{{route('admin.new_bidya_exam_form')}}">Add New Exam</a>
    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <table id="subject" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Sl</th>
                              <th>Name</th>
                              <th>Start Date</th>
                              <th>End Date</th>
                              <th>Total Marks</th>
                              <th>Pass Marks</th>
                              <th>Exam Duration (in munites)</th>
                              <th>Question Status</th>
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
         ajax: "{{ route('admin.bidya_exam_list_ajax') }}",
         columns: [
             {data: 'DT_RowIndex', name: 'DT_RowIndex'},      
             {data: 'name', name: 'name',searchable: true},    
            
             {data: 'start_date', name: 'start_date' ,searchable: true}, 
             {data: 'end_date', name: 'end_date' ,searchable: true}, 
             {data: 'total_mark', name: 'total_mark' ,searchable: true}, 
             {data: 'pass_mark', name: 'pass_mark' ,searchable: true}, 
             {data: 'duration', name: 'duration' ,searchable: true}, 
             {data: 'question_status', name: 'question_status' ,searchable: true}, 
             {data: 'exam_type', name: 'exam_type' ,searchable: true}, 
             {data: 'action', name: 'action' ,searchable: true}, 
         ]
     });            
  });
</script>    
    
 @endsection