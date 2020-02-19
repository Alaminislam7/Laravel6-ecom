@extends('layouts.frontLayout.front_design')
@section('content')

<section id="form" style="margin:30px"><!--form-->
    <div class="container">
        <div class="row">
            @if(Session::has('flash_message_error'))
                <div class="alert alert-error alert-block" style="background-color:antiquewhite">
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
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form">
                    <form id="accountForm" name="accountForm" action="{{ url('/account') }}" method="POST">{{csrf_field()}}
                        <h2>Update Account</h2>
                        <input value="{{ $userDetails->name }}" type="text" id="name" name="name" placeholder="name">
                        <input value="{{ $userDetails->address }}" type="text" id="address" name="address" placeholder="address">
                        <input value="{{ $userDetails->city }}" type="text" id="city" name="city" placeholder="city">
                        <input value="{{ $userDetails->state }}" type="text" id="state" name="state" placeholder="state">
                        <select name="country" id="country">
                            <option value="">Select Country</option>
                            @foreach ($countries as $country)
                            <option value="{{ $country->country_name }}" @if($country->country_name==$userDetails->country) Selected @endif>{{ $country->country_name }}</option>
                            @endforeach
                        </select>
                        <input value="{{ $userDetails->pincode }}" style="margin-top:10px" type="text" id="pincode" name="pincode" placeholder="pincode">
                        <input value="{{ $userDetails->mobile }}" type="text" id="mobile" name="mobile" placeholder="mobile">
                        <button type="submit" class="btn btn-default">Update</button>
                    </form>
                </div>
            </div>
            <div class="col-sm-1">
                <h2 class="or">OR</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form">
                    <h2>Update password!</h2>
                    {{-- <form id="passwordForm" name="passwordForm" action="{{ url('/check-user-pwd') }}" method="POST">{{csrf_field()}} --}}
                    <form name="passwordForm" id="passwordForm" action="{{ url('/update-user-pwd') }}" method="post" novalidate="novalidate">{{ csrf_field() }}
                        <input type="password" id="current_pwd" name="current_pwd" placeholder="Current Password">
                        <span id="chkPwd"></span>
                        <input type="password" id="new_pwd" name="new_pwd" placeholder="New Password">
                        <input type="password" id="confirm_pwd" name="confirm_pwd" placeholder="Confirm Password">
                        <button type="submit" class="btn btn-default">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section><!--/form-->

@endsection