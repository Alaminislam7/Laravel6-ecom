@extends('layouts.frontLayout.front_design')
@section('content')

    <section id="form"><!--form-->
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                  <li><a href="#">Home</a></li>
                  <li class="active">Check Out</li>
                </ol>
            </div>
            @if(Session::has('flash_message_error'))
            <div class="alert alert-error alert-block" style="background-color:antiquewhite">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                <strong>{!! session('flash_message_error') !!}</strong>
            </div>
            @endif  
            <form action="{{ url('checkout') }}" method="POST">{{csrf_field()}}
                <div class="row">
                    <div class="col-sm-5 col-sm-offset-1">
                        <div class="login-form"><!--login form-->
                            <h2>Bill to</h2>
                            <div class="form-group">
                                <input type="text" name="billing-name" id="billing-name" @if(!empty($userDetails->name)) value="{{ $userDetails->name }}" @endif placeholder="Billing Name" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="billing-address" id="billing-address" @if(!empty($userDetails->address)) value="{{ $userDetails->address }}" @endif placeholder="Billing Address" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="billing-city" id="billing-city" @if(!empty($userDetails->city)) value="{{ $userDetails->city }}" @endif placeholder="Billing City" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="billing-state" id="billing-state" @if(!empty($userDetails->state)) value="{{ $userDetails->state }}" @endif placeholder="Billing State" class="form-control" />
                            </div>
                            <div class="form-group">
                                <select name="billing-country" id="billing-country" class="form-control">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->country_name }}" @if(!empty($userDetails->country) && $country->country_name == $userDetails->country) selected @endif>{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" name="billing-pincode" id="billing-pincode" @if(!empty($userDetails->pincode)) value="{{ $userDetails->pincode }}" @endif placeholder="Billing Pincode" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="billing-mobile" id="billing-mobile" @if(!empty($userDetails->mobile)) value="{{ $userDetails->mobile }}" @endif placeholder="Billing Mobile" class="form-control" />
                            </div>
                            <span class="form-check">
                                <input type="checkbox" class="form-check-input" id="copyAddress">
							    <label class="form-check-label" for="copyAddress">Shipping Address same as Billing Address</label>
                            </span>
                        </div><!--/login form-->
                    </div>
                    <div class="col-sm-4">
                        <div class="signup-form"><!--sign up form-->
                            <h2>Ship to</h2>
                            <div class="form-group">
                                <input type="text" name="shipping-name" id="shipping-name" @if(!empty($shippingDetails->name)) value="{{ $shippingDetails->name }}" @endif placeholder="Shipping Name" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="shipping-address" id="shipping-address" @if(!empty($shippingDetails->address)) value="{{ $shippingDetails->address }}" @endif placeholder="Shipping Address" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="shipping-city" id="shipping-city" @if(!empty($shippingDetails->city)) value="{{ $shippingDetails->city }}" @endif placeholder="Shipping City" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="shipping-state" id="shipping-state" @if(!empty($shippingDetails->state)) value="{{ $shippingDetails->state }}" @endif placeholder="Shipping state" class="form-control" />
                            </div>
                            <div class="form-group">
                                <select name="shipping-country" id="shipping-country" class="form-control">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->country_name }}" @if(!empty($shippingDetails->country) && $country->country_name == $shippingDetails->country) selected @endif>{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" name="shipping-pincode" id="shipping-pincode" @if(!empty($shippingDetails->pincode)) value="{{ $shippingDetails->pincode }}" @endif placeholder="Shipping Pincode" class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="shipping-mobile" id="shipping-mobile" @if(!empty($shippingDetails->mobile)) value="{{ $shippingDetails->mobile }}" @endif placeholder="Shipping Mobile" class="form-control" />
                            </div>
                                <button type="submit" class="btn btn-default">Checkout</button>
                        </div><!--/sign up form-->
                    </div>
                </div>
            </form>
        </div>
    </section><!--/form-->

@endsection