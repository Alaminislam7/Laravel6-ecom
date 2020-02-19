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
            <div class="col-sm-4 col-sm-offset-4">
                <div class="login-form center"><!--login form-->
                    <h2>Forget Password</h2>
                    <form id="forgotpassword" name="forgotpassword" action="{{ url('/forgot-password') }}" method="POST">{{csrf_field()}}
                        <input type="email" name="email" placeholder="Type your email" required/>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div><!--/login form-->
            </div>
        </div>
    </div>
</section><!--/form-->

@endsection