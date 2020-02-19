@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Category</a> <a href="#" class="current">View Category</a> </div>
      <h1>View Category</h1>
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
              <h5>View Category</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Category id</th>
                    <th>Category Name</th>
                    <th>Category Levels</th>
                    <th>Category Url</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr class="gradeX">
                          <td>{{ $category->id }}</td>
                          <td>{{ $category->category_name }}</td>
                          <td>{{ $category->parent_id }}</td>
                          <td>{{ $category->url }}</td>
                          <td class="center">
                            <a href="{{ URL::to('/admin-panel/edit-category/'.$category->id) }}" class="btn btn-primary btn-mini">Edit</a>
                              {{-- sweet alert category table delete  --}}
                              <a id="delProduct" rel="{{ $category->id }}" rel1="delete-category" href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                            </td>
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