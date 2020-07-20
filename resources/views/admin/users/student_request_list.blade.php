@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>Organization List</h2>
    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <table id="category" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Sl</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Password</th>
                              <th>Address</th>
                              <th>State</th>
                              <th>City</th>
                              <th>Pin</th>
                              <th>Date</th>
                            </tr>
                          </thead>
                          <tbody>  
                            @if (isset($org) && !empty($org))
                            @php
                              $count=1;
                            @endphp
                                @foreach ($org as $item)
                                    <tr>
                                      <td>{{$count++}}</td>
                                      <td>{{$item->name}}</td>
                                      <td>{{$item->email}}</td>
                                      <td>{{$item->code}}</td>
                                      <td>{{$item->address}}</td>
                                      <td>{{$item->state}}</td>
                                      <td>{{$item->city}}</td>
                                      <td>{{$item->pin}}</td>
                                      <td>{{$item->created_at}}</td>
                                    </tr>
                                @endforeach
                            @else
                              <tr>
                                <td colspan="9" style="text-align: center">No Organization Found</td>
                              </tr>  
                            @endif                   
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
            var table = $('#category').DataTable();
        });
     </script>
    
 @endsection