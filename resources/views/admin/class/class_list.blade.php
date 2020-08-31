@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>Class List</h2>
                    <a class="btn btn-sm btn-info" style="float: right" href="{{route('admin.class_add')}}">Add New Class</a>
    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <table id="category" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Sl</th>
                              <th>Name</th>
                              <th>Stream</th>
                              <th>Date</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>  
                            @if (isset($class) && !empty($class))
                            @php
                              $count=1;
                            @endphp
                                @foreach ($class as $item)
                                    <tr>
                                      <td>{{$count++}}</td>
                                      <td>{{$item->name}}</td>
                                      <td>
                                        @if (isset($item->stream_id) && !empty($item->stream_id))
                                            {{$item->stream->name}}
                                        @endif
                                      </td>
                                      <td>{{$item->created_at}}</td>
                                      <td>
                                        <a href="{{route('admin.class_edit',['id'=>$item->id])}}" class="btn btn-sm btn-warning">Edit</a>
                                      </td>
                                    </tr>
                                @endforeach
                            @else
                              <tr>
                                <td colspan="4" style="text-align: center">No Category Found</td>
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