
@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Product</a> <a href="#" class="current">Add Image</a> </div>
      <h1>Add Product Image</h1>
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
    <div class="container-fluid"><hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
              <h5>Add Product Image</h5>
              
            </div>
            <div class="widget-content nopadding">
                {{-- <form class="form-horizontal" enctype="multipart/form-data" method="post" action="{{URL::to('admin-panel/add-attributes/'.$productDetails->id)}}" name="add_attributes" id="add_attributes" novalidate="novalidate"> --}}
              <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('admin-panel/add-images/'.$productDetails->id) }}" name="add_image" id="add_image" novalidate="novalidate">
                  {{csrf_field()}}
                <input type="hidden" name="product_id" value="{{ $productDetails->id }}">
                <div class="control-group">
                  <label class="control-label"><strong>Product Name</strong></label>
                  <label class="control-label">{{$productDetails->product_name}}</label>
                </div>
                <div class="control-group">
                  <label class="control-label"><strong>Product Code</strong></label>
                  <label class="control-label">{{$productDetails->product_code}}</label>
                </div>
                <div class="control-group">
                  <label class="control-label"><strong>Altername Images</strong></label>
                  <input type="file" name="image[]" id="image" multiple="multiple">
                </div>
                <div class="form-actions">
                  <input type="submit" value="Add Image" class="btn btn-success">
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>Images</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Image ID</th>
                    <th>Product ID</th>
                    <th>Image</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($productImages as $image)
                  <tr class="gradeX">
                    <td class="center">{{ $image->id }}</td>
                    <td class="center">{{ $image->product_id }}</td>
                    <td class="center"><img style="width:50px" src="{{ asset('images/backend_images/products/small/'.$image->image) }}"></td>
                    <td class="center"><a id="delImage" rel="{{ $image->id }}" rel1="delete-alt-image" href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a></td>
  
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
  <!--Footer-part-->




@endsection
