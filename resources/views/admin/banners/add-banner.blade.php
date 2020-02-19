@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Banner</a> <a href="#" class="current">Add Banner</a> </div>
      <h1>Add Banner Image</h1>
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
              <h5>Add Banner Image</h5>
              
            </div>
            <div class="widget-content nopadding">
                <form class="form-horizontal" enctype="multipart/form-data" method="post" action="{{URL::to('admin-panel/add-banner')}}" name="add_banner" id="add_banner" novalidate="novalidate">
                    {{csrf_field()}}
                    <div class="control-group">
                     <label class="control-label">Image</label>
                     <div class="controls">
                        <input type="file" name="image" id="image" >
                     </div>
                    </div>
                  <div class="control-group">
                    <label class="control-label">Title</label>
                    <div class="controls">
                      <input type="text" name="title" id="title">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Link</label>
                    <div class="controls">
                      <input type="url" name="link" id="link">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Enable</label>
                    <div class="controls">
                      <input type="checkbox" name="status" id="status" value="1">
                    </div>
                  </div>
                  <div class="form-actions">
                    <input type="submit" value="Add Banner" class="btn btn-success">
                  </div>
                </form>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>

    
</div>
  <!--Footer-part-->




@endsection
