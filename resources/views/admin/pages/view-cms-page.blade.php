@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Cms Pages</a> <a href="#" class="current">View Cms Page</a> </div>
        <h1>View Cms Pages</h1>
      @if(Session::has('flash_message_error'))
          <div class="alert alert-error alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button> 
                  <strong>{!! session('flash_message_error') !!}</strong>
          </div>
      @endif   
      @if(Session::has('flash_message_success'))
          <div class="alert alert-success alert-block">
              <button type="button" class="close" data-dismiss="alert">×</button> 
                  <strong>{!! session('flash_message_success') !!}</strong>
          </div>
      @endif 
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>View Cms Page</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Url</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($cmsPages as $cmsPage)
                        <tr class="gradeX">
                            <td>{{ $cmsPage->id }}</td>
                            <td>{{ $cmsPage->title }}</td>
                            <td>{{ $cmsPage->description }}</td>
                            <td>{{ $cmsPage->url }}</td>
                            <td> @if($cmsPage->status == 1) Active @else Inactive @endif</td>

                            <td class="center">
                                <a href="#myModal{{ $cmsPage->id }}" data-toggle="modal" class="btn btn-success btn-mini">View</a>
                                <a href="{{ URL::to('/admin-panel/edit-cms/'.$cmsPage->id) }}" class="btn btn-primary btn-mini" title="Edit Product">Edit</a>
                                {{-- sweet alert product table delete  --}}
                                <a id="delProduct" rel="{{ $cmsPage->id }}" rel1="delete-cms" href="javascript:" class="btn btn-danger btn-mini deleteRecord" title="Delete Cms">Delete</a>
                            </td>
                        </tr>
                        <div id="myModal{{ $cmsPage->id }}" class="modal hide">
                            <div class="modal-header">
                                <button data-dismiss="modal" class="close" type="button">×</button>
                                <h3>{{ $cmsPage->title }} Full Details</h3>
                            </div>
                            <div class="modal-body">
                                <p>Title: {{ $cmsPage->title }} </p>
                                <p>Url: {{ $cmsPage->url }} </p>
                                <p>Status: @if($cmsPage->status == 1) Active @else Inactive @endif </p>
                                <p>Created at: {{ $cmsPage->created_at }} </p>
                                <p>description: {{ $cmsPage->description }} </p>
                            </div>
                        </div>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    

  @endsection