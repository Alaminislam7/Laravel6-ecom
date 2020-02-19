@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Product</a> <a href="#" class="current">View Product</a> </div>
      <h1>View Product</h1>
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
              <h5>View Product</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Product Id</th>
                    <th>Category Id</th>
                    <th>Category Name</th>
                    <th>Product Name</th>
                    <th>Product Code</th>
                    <th>Product Color</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Featured</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($product as $s_product)
                        <tr class="gradeX">
                            <td>{{ $s_product->id }}</td>
                            <td>{{ $s_product->category_id }}</td>
                            <td>{{ $s_product->category_name }}</td>
                            <td>{{ $s_product->product_name }}</td>
                            <td>{{ $s_product->product_code }}</td>
                            <td>{{ $s_product->product_color }}</td>
                            <td>{{ $s_product->price }}</td>
                            <td>
                                @if(!empty($s_product->image))
                                    <img src="{{ URL::to('images/backend_images/products/small/'.$s_product->image) }}" style="width:55px" alt="">
                                @endif
                            </td>
                            <td> @if($s_product->feature_item == 1) Yes @else No @endif</td>
                            <td class="center">
                                <a href="#myModal{{ $s_product->id }}" data-toggle="modal" class="btn btn-success btn-mini">View</a>
                                <a href="{{ URL::to('/admin-panel/edit-product/'.$s_product->id) }}" class="btn btn-primary btn-mini" title="Edit Product">Edit</a>
                                <a href="{{ URL::to('/admin-panel/add-attributes/'.$s_product->id) }}" class="btn btn-primary btn-mini" title="Add Attributes">Add</a>
                                <a href="{{ URL::to('/admin-panel/add-images/'.$s_product->id) }}" class="btn btn-info btn-mini" title="Add Images">Add</a>
                                {{-- sweet alert product table delete  --}}
                                <a id="delProduct" rel="{{ $s_product->id }}" rel1="delete-product" href="javascript:" class="btn btn-danger btn-mini deleteRecord" title="Delete product">Delete</a>
                            </td>
                        </tr>
                        <div id="myModal{{ $s_product->id }}" class="modal hide">
                            <div class="modal-header">
                                <button data-dismiss="modal" class="close" type="button">×</button>
                                <h3>{{ $s_product->category_name }} Full Details</h3>
                            </div>
                            <div class="modal-body">
                                <p>Product ID: {{ $s_product->id }} </p>
                                <p>Category ID: {{ $s_product->category_id }} </p>
                                <p>Product Code: {{ $s_product->product_code }} </p>
                                <p>Product Color: {{ $s_product->product_color }} </p>
                                <p>Product Price: {{ $s_product->price }} </p>
                                <p>{{ $s_product->description }}</p>
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