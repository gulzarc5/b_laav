@extends('admin.template.admin_master')

@section('content')

<div class="right_col" role="main">
    <div class="row">
    	<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:50px;">
    	    <div class="x_panel">

    	        <div class="x_title">
                    <h2>App Settings</h2>
                    <a class="btn btn-sm btn-info" style="float: right" href="{{route('admin.imageForm')}}">Add Slider Image</a>
    	            <div class="clearfix"></div>
    	        </div>
    	        <div>
    	            <div class="x_content">
                        <table id="subject" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Sl</th>
                              <th>Name</th>
                              <th>Video</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>  
                              @if (isset($data) && !empty($data))
                              @php
                                  $count = 1;
                              @endphp
                                  @foreach ($data as $item)
                                    <tr>
                                      <td>{{$count++}}</td>
                                      <td>
                                        @if ($item->type == '1')
                                            App Home Page Video
                                        @else
                                            App Starting Slidet
                                        @endif
                                      </td>
                                      <td>
                                        @if ($item->type == '1')
                                        <iframe id="player" type="text/html" width="200" height="200"
                                        src="http://www.youtube.com/embed/{{$item->file}}?enablejsapi=1&origin=http://example.com"
                                        frameborder="0"></iframe>
                                        @else
                                          <img src="{{asset('org_image/'.$item->file.'')}}" alt="" height="200">
                                        @endif
                                      </td>
                                      <td>
                                        @if ($item->type == '1')
                                            <a href="{{route('admin.videoForm')}}" class="btn btn-sm btn-info">Change Video</a>
                                        @else                                          
                                          <a href="{{route('admin.imageDelete',['id'=>$item->id])}}" class="btn btn-sm btn-danger">Delete Image</a>
                                        @endif
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


 @endsection
