@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>Organization Student List</h2>
    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <table id="student" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Sl</th>
                              <th>Name</th>
                              <th>Class</th>
                              <th>Email</th>
                              <th>Mobile</th>
                              <th>Address</th>
                              <th>State</th>
                              <th>City</th>
                              <th>Pin</th>
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

     var table = $('#student').DataTable({
         processing: true,
         serverSide: true,
         iDisplayLength: 25,
         ajax: "{{ route('admin.org_student_list_ajax') }}",
         columns: [
             {data: 'DT_RowIndex', name: 'DT_RowIndex'},      
             {data: 'name', name: 'name',searchable: true},    
             {data: 'class_name', name: 'class_name',searchable: true},          
             {data: 'email', name: 'email',searchable: true},
             {data: 'mobile', name: 'mobile',searchable: true}, 
             {data: 'address', name: 'address' ,searchable: true}, 
             {data: 'state', name: 'state' ,searchable: true},
             {data: 'city', name: 'city' ,searchable: true},
             {data: 'pin', name: 'pin' ,searchable: true},
             {data: 'created_at', name: 'created_at' ,searchable: true},
             {data: 'action', name: 'action' ,searchable: true}, 
         ]
     });            
 });
</script>
    
 @endsection