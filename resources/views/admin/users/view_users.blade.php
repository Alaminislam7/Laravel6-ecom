@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Users</a> <a href="#" class="current">View Users</a> </div>
      <h1>View Users</h1>
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>View Users</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Country</th>
                    <th>Pincode</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Register On</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="gradeX">
                            <td class="center">{{ $user->id }}</td>
                            <td class="center">{{ $user->name }}</td>
                            <td class="center">{{ $user->address }}</td>
                            <td class="center">{{ $user->city }}</td>
                            <td class="center">{{ $user->state }}</td>
                            <td class="center">{{ $user->country }}</td>
                            <td class="center">{{ $user->pincode }}</td>
                            <td class="center">{{ $user->mobile }}</td>
                            <td class="center">{{ $user->email }}</td>
                            <td class="center">
                                @if($user->status == 1 )
                                    <span style="color:yellow" >Active</span>
                                @else
                                <span style="color:red" >InActive</span>
                                @endif
                            </td>
                            <td class="center">{{ $user->created_at }}</td>
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