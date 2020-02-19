@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
    <div id="content-header">
      <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Orders</a> <a href="#" class="current">View Orders</a> </div>
      <h1>View Product</h1>
    </div>
    <div class="container-fluid">
      <hr>
      <div class="row-fluid">
        <div class="span12">
          <div class="widget-box">
            <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
              <h5>View Orders</h5>
            </div>
            <div class="widget-content nopadding">
              <table class="table table-bordered data-table">
                <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Customar Name</th>
                    <th>Customar Email</th>
                    <th>Ordered Product</th>
                    <th>Order Amount</th>
                    <th>Order Status</th>
                    <th>Payment Method</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr class="gradeX">
                            <td class="center">{{ $order->id }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->user_email }}</td>
                            <td>
                                @foreach ($order->orders as $pro)
                                    <a href="{{ url('/orders/'.$order->id) }}">{{ $pro->product_code }}</a><br>
                                @endforeach
                            </td>
                            <td>{{ $order->grand_total }}</td>
                            <td>{{ $order->order_status }}</td>
                            <td>{{ $order->payment_method }}</td>
                            <td>
                                <a target="_blank" class="btn btn-info btn-mini" href="{{ url('admin-panel/view-order/'.$order->id) }}">View Order Details</a><br>
                                <a target="_blank" class="btn btn-success btn-mini" href="{{ url('admin-panel/view-order-invoice/'.$order->id) }}">View Order Invoice</a>
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