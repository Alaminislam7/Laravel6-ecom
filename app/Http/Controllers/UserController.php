<?php

namespace App\Http\Controllers;

use Auth;
use Session;
use App\User;
use App\country;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function userLoginRegister(){
        $meta_title = "User/Login register";
        return view('users.login-register')->with(compact('meta_title'));
    }

    public function register(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $userCount = User::where('email',$data['email'])->count();
            //echo "<pre>"; print_r($userCount); die;
            if($userCount>0){
                return redirect()->back()->with('flash_message_error','Email already exist');
            }else{
                $user = new User;
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->save();
                //Send Register email
                /* $email = $data['email'];
                $messageData = ['email'=>$data['email'],'name'=>$data['name']];
                Mail::send('emails.register',$messageData,function($message)use($email){
                    $message->to($email)->subject('Register with Broken E-com website');
                }); */

                //Send Corfirmation Email
                $email = $data['email'];
                $messageData = ['email'=>$data['email'],'name'=>$data['name'],'code'=>base64_encode($data['email'])];
                Mail::send('emails.confirmation',$messageData,function($message)use($email){
                    $message->to($email)->subject('Register with Broken E-com website');
                });
                return redirect()->back()->with('flash_message_success','Please confirm your email to activate your account!');

                if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                    Session::put('fronSession',$data['email']);

                    if(!empty(Session::get('session_id'))){
                        $session_id = Session::get('session_id');
                        DB::table('cart')->where('session_id',$session_id)->update(['user_email' => $data['email']]);
                    }

                    return redirect('/cart');
                }
            }
        }
    }

    public function userForgotPassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $userCount = User::where('email',$data['email'])->count();
            if($userCount == 0 ){
                return redirect()->back()->with('flash_message_error','Email does not Exist');
            }
            //Get user Details
            $getuserDetails = User::where('email',$data['email'])->first();

            //Genarate random password
            $random_password = Str::random(8);

            //Encode / Secuare password
            $new_password = bcrypt($random_password);

            //Update password
            User::where('email',$data['email'])->update(['password'=>$new_password]);
            //Send Forget Password Email Code
            $email = $data['email'];
            $name = $getuserDetails->name;
            $messageData = [
                'email'=>$email,
                'name'=>$name,
                'password'=>$random_password
            ];
            
            Mail::send('emails.forgotpassword',$messageData,function($message)use($email){
                $message->to($email)->subject('New Password Broken E-com website');
            });
            return redirect('/login-register')->with('flash_message_success','Please check your email for new password!');
            
        }
        return view('users.forgot-password');
    }

    public function userLogin(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //dd($data);
            if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                $userStatus = User::where('email',$data['email'])->first();
                if($userStatus->status == 0){
                    return redirect()->back()->with('flash_message_error','Your account is not activated! Please confirm your email to activate!');
                }
                Session::put('fronSession',$data['email']);

                if(!empty(Session::get('session_id'))){
                    $session_id = Session::get('session_id');
                    DB::table('cart')->where('session_id',$session_id)->update(['user_email' => $data['email']]);
                }

                return redirect('/cart');
            }else{
                return redirect()->back()->with('flash_message_error','Invalid Username or Password');
            }
        }
    }

    public function account(Request $request){
        $userId = Auth::user()->id;
        $userDetails = User::find($userId);
        $countries = country::get();
        //dd($userDetails);
        if($request->isMethod('post')){
           $data =  $request->all();
            if(empty($data['name'])){
                    return redirect()->back()->with('flash_message_error','Please enter your name to update your details');
            }
           if(empty($data['address'])){
            return redirect()->back()->with('flash_message_error','Please enter your address to update your details');
            }
            if(empty($data['city'])){
                return redirect()->back()->with('flash_message_error','Please enter your city to update your details');
            }
            if(empty($data['state'])){
                return redirect()->back()->with('flash_message_error','Please enter your state to update your details');
            }
            if(empty($data['pincode'])){
                return redirect()->back()->with('flash_message_error','Please enter your pincode to update your details');
            }
            if(empty($data['mobile'])){
                return redirect()->back()->with('flash_message_error','Please enter your mobile to update your details');
            }

           $user = User::find($userId);
           $user->name = $data['name'];
           $user->address = $data['address'];
           $user->city = $data['city'];
           $user->state = $data['state'];
           $user->country = $data['country'];
           $user->pincode = $data['pincode'];
           $user->mobile = $data['mobile'];
           $user->save();
           return redirect()->back()->with('flash_message_success','Your account has been updated successfull');
        }
        return view('users.account')->with(compact('countries','userDetails'));
    }

    public function logout(){
        Auth::logout();
        Session::forget('fronSession');
        Session::forget('session_id');
        return redirect('/');
    }

    public function checkEmail(Request $request){
        $data = $request->all();
        $userCount = User::where('email',$data['email'])->count();
            //echo "<pre>"; print_r($userCount); die;
            if($userCount>0){
                echo 'false';
            }else{
                echo 'true';
            }
    }
    //current password check 
    public function chkUserPassword(Request $request){
        $data = $request->all();
        $current_password = $data['current_pwd'];
        $user_id = Auth::User()->id;
        $check_password = User::where('id',$user_id)->first();
        if(Hash::check($current_password, $check_password->password)){
            echo 'true'; die;
        }else{
            echo 'false'; die;
        }
    }

    //Update password
    public function updatePassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $old_pwd = User::where('id',Auth::User()->id)->first();
            $current_pwd = $data['current_pwd'];
            if(Hash::check($current_pwd, $old_pwd->password)){
                //Update password
                $new_pwd = bcrypt($data['new_pwd']);
                User::where('id',Auth::User()->id)->update(['password'=>$new_pwd]);
                return redirect()->back()->with('flash_message_success','Password updated successfull');
            }else{
                return redirect()->back()->with('flash_message_error','Current password is incurrect!');
            }
        }
    }

    //Confirm Account
    public function confirmAccount($email){
        $email = base64_decode($email);
        $userCount = User::where('email',$email)->count();
        if($userCount > 0){
            $userDetails = User::where('email',$email)->first();
            if($userDetails->status == 1){
                return redirect('/login-register')->with('flash_message_success','Your email account is already activated.You can login now');
            }else{
                User::where('email',$email)->update(['status'=>1]);

                //Send Register email
                $messageData = ['email'=>$email,'name'=>$userDetails->name];
                Mail::send('emails.welcome',$messageData,function($message)use($email){
                    $message->to($email)->subject('Welcome to E-com website');
                });

                return redirect('/login-register')->with('flash_message_success','Your email account is active now. You can login now');
            }

        }else{
            abort(404);
        }
    }


    //Admin users
    public function viewUser(){
        $users = User::get();
        return view('admin.users.view_users')->with(compact('users'));
    }



}
