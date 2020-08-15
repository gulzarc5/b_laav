@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>Video List</h2>
                    <a class="btn btn-sm btn-info" style="float: right" href="{{route('admin.subject_video_add')}}">Add New Video</a>
    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <table id="subject" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Sl</th>
                              <th>Stream</th>
                              <th>Class</th>
                              <th>Subject</th>
                              <th>Video</th>
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
         ajax: "{{ route('admin.subject_video_list_ajax') }}",
         columns: [
             {data: 'DT_RowIndex', name: 'DT_RowIndex'},       
             {data: 'stream', name: 'stream',searchable: true},          
             {data: 'class', name: 'class',searchable: true},
             {data: 'subject', name: 'subject',searchable: true},    
             {data: 'video', name: 'video',searchable: true},
             {data: 'created_at', name: 'created_at' ,searchable: true}, 
             {data: 'action', name: 'action' ,searchable: true}, 
         ]
     });            
  });
</script>    
    
 @endsection