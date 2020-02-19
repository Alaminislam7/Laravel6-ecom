@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Banner</a> <a href="#" class="current">View Banners</a> </div>
      <h1>View Banner</h1>
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
              <h5>View Banner</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Banner Id</th>
                    <th>Title</th>
                    <th>Link</th>
                    <th>Images</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($banner as $s_banner)
                        <tr class="gradeX">
                            <td>{{ $s_banner->id }}</td>
                            <td>{{ $s_banner->title }}</td>
                            <td>{{ $s_banner->link }}</td>
                            <td>
                                @if(!empty($s_banner->image))
                                    <img src="{{ asset('images/frontend_images/banner-images/'.$s_banner->image) }}" style="width:250px;">
                                @endif
                            </td>
                            <td class="center">
                                <a href="{{ URL::to('/admin-panel/edit-banner/'.$s_banner->id) }}" class="btn btn-primary btn-mini" title="Edit Banner">Edit</a>
                                {{-- sweet alert product table delete  --}}
                                <a id="delBanner" rel="{{ $s_banner->id }}" rel1="delete-banner" href="javascript:" class="btn btn-danger btn-mini deleteRecord" title="Delete banner">Delete</a>
                            </td>
                        </tr>
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