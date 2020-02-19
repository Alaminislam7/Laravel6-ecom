@extends('layouts.frontLayout.front_design')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="#">Home</a></li>
              <li class="active">Thanks</li>
            </ol>
        </div>
    </div>
</section> <!--/#cart_items-->

<section id="do_action">
    <div class="container">
        <div class="heading" align="center">
            <h3>YOUR PAYPAL ORDER HAS BEEN PLACED</h3>
            <P>Thanks for the payment. We will process your very order soon!</P>
            <p>Your order number is {{Session::get('order_id')}} and total amount paid is TK {{Session::get('grand_total')}}</p>
        </div>
    </div>
</section><!--/#do_action-->

@endsection

<?php 
    Session::forget('grand_total');
    Session::forget('order_id');
?>