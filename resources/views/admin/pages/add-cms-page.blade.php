@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Cms Pages</a> <a href="#" class="current">Add Cms Page</a> </div>
      <h1>Add Cms Pages</h1>
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
              <h5>Add Cms</h5>
            </div>
            <div class="widget-content nopadding">
                <form class="form-horizontal" enctype="multipart/form-data" method="post" action="{{URL::to('admin-panel/add-cms')}}" name="add_cms" id="add_cms">
                    {{csrf_field()}}
                  <div class="control-group">
                    <label class="control-label">Title</label>
                    <div class="controls">
                      <input type="text" name="title" id="title" required>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Description</label>
                    <div class="controls">
                      <textarea name="description" id="description" required></textarea>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Url</label>
                    <div class="controls">
                        <input type="text" name="url" id="url" required>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Meta Title</label>
                    <div class="controls">
                        <input type="text" name="meta_title" id="meta_title">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Meta Description</label>
                    <div class="controls">
                        <input type="text" name="meta_description" id="meta_description">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Meta Kaywords</label>
                    <div class="controls">
                        <input type="text" name="meta_keyourds" id="meta_keyourds">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label">Status</label>
                    <div class="controls">
                      <input type="checkbox" name="status" id="status" value="1">
                    </div>
                  </div>
                  <div class="form-actions">
                    <input type="submit" value="Add Cms" class="btn btn-success">
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