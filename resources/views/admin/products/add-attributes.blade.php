
@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Product</a> <a href="#" class="current">Add Attributes</a> </div>
      <h1>Add Product Attributes</h1>
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
              <h5>Add Product Attributes</h5>
            </div>
            <div class="widget-content nopadding">
                {{-- <form class="form-horizontal" enctype="multipart/form-data" method="post" action="{{URL::to('admin-panel/add-attributes/'.$productDetails->id)}}" name="add_attributes" id="add_attributes" novalidate="novalidate"> --}}
              <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('admin-panel/add-attributes/'.$productDetails->id) }}" name="add_product" id="add_product" novalidate="novalidate">
                  {{csrf_field()}}
                <input type="hidden" name="product_id" value="{{$productDetails->id}}">
                <div class="control-group">
                  <label class="control-label"><strong>Product Name</strong></label>
                  <label class="control-label">{{$productDetails->product_name}}</label>
                </div>
                <div class="control-group">
                  <label class="control-label"><strong>Product Color</strong></label>
                  <label class="control-label">{{$productDetails->product_color}}</label>
                </div>
                <div class="control-group">
                  <label class="control-label"><strong>Price</strong></label>
                  <label class="control-label">{{$productDetails->price}}</label>
                </div>
                <div class="control-group">
                  <label class="control-label"></label>
                  <div class="field_wrapper">
                    <div>
                        <input type="text" name="sku[]" id="sku" placeholder="SKU" style="width:120px" value=""/>
                        <input type="text" name="size[]" id="size" placeholder="SIZE" style="width:120px" value=""/>
                        <input type="text" name="price[]" id="price" placeholder="PRICE" style="width:120px" value=""/>
                        <input type="text" name="stock[]" id="stock" placeholder="STOCK" style="width:120px" value=""/>
                        <a href="javascript:void(0);" class="add_button" title="Add field">Add</a>
                    </div>
                  </div>
                </div>
                <div class="form-actions">
                  <input type="submit" value="Add Attribute" class="btn btn-success">
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
              <h5>Attributes</h5>
            </div>
            <div class="widget-content nopadding">
              <form action="{{ url('admin-panel/edit-attributes/'.$productDetails->id) }}" method="post">{{ csrf_field() }}
                <table class="table table-bordered data-table">
                  <thead>
                    <tr>
                      <th>Attribute Id</th>
                      <th>Sku</th>
                      <th>Size</th>
                      <th>Price</th>
                      <th>Stock</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach ($productDetails['attributes'] as $attribute)
                        <tr class="gradeX">
                            <td><input type="hidden" name="idAttr[]" value="{{ $attribute->id }}"> {{ $attribute->id }}</td>
                            <td>{{ $attribute->sku }}</td>
                            <td>{{ $attribute->size }}</td>
                            <td> <input type="text" name="price[]" value="{{ $attribute->price }}"></td>
                            <td> <input type="text" name="stock[]" value="{{ $attribute->stock }}"></td>
                            <td class="center">
                                {{-- sweet alert product table delete  --}}
                                <input type="submit" value="Update" class="btn btn-info btn-mini">
                                <a id="delProduct" rel="{{ $attribute->id }}" rel1="delete-attribute" href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                            </td>
                        </tr>
                      @endforeach
                  </tbody>
                </table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    
</div>
  <!--Footer-part-->




@endsection
