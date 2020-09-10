@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>Student Questions</h2>
    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <table id="subject" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Sl</th>
                              <th>Student Name</th>
                              <th>Subject</th>
                              <th>Question</th>
                              <th>Is Answered</th>
                              <th>Date</th>
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
         ajax: "{{ route('admin.question_list_ajax') }}",
         columns: [
             {data: 'DT_RowIndex', name: 'DT_RowIndex'},      
             {data: 'student_name', name: 'student_name',searchable: true},    
             {data: 'subject', name: 'subject',searchable: true},          
             {data: 'message', name: 'message',searchable: true},
             {data: 'status_tab', name: 'status_tab' ,searchable: true}, 
             {data: 'created_at', name: 'created_at' ,searchable: true}, 
             {data: 'action', name: 'action' ,searchable: true}, 
         ]
     });            
  });
</script>    
    
 @endsection