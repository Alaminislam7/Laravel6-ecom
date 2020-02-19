<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use App\Admin;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->input();

            $adminCount = Admin::where(['username' => $data['username'],'password'=>md5($data['password']),'status'=>1])->count();
            if($adminCount > 0){
                //echo "Success"; die; 
                Session::put('adminSession', $data['username']);
                return redirect('/admin-panel/dashboard');
        	}else{
                //echo "failed"; die;
                return redirect('/admin-panel/dashboard')->with('flash_message_error','Invalid Username or Password');
        	}
        }
        return view('admin.admin-login');
    }

    public function dashboard(){
        return view('admin.admin-master');
    }

    public function logout(){
        Session::flush();
        return redirect('admin-panel')->with('flash_message_success','Successfully Logout');
    }

    public function chackpassword(Request $request){
        $data = $request->all();

        $adminCount = Admin::where(['username' => Session::get('adminSession'),'password'=>md5($data['current_pwd'])])->count();
        if ($adminCount == 1) {
            //echo '{"valid":true}';die;
            echo "true"; die;
        } else {
            //echo '{"valid":false}';die;
            echo "false"; die;
        }
    }

    public function updatepassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            $adminCount =Admin::where(['username'=>Session::get('adminSession'),'password'=>md5($data['current_pwd'])])->count();
            if($adminCount == 1 ){
                $password = md5($data['new_pwd']);
                Admin::where('username',Session::get('adminSession'))->update(['password'=>$password]);
                return redirect('/admin-panel/settings')->with('flash_message_success','Password updated Successfully!');
            }else{
                return redirect('/admin-panel/settings')->with('flash_message_error','Incorrect Current Password!');
            }
        }
    }

    public function settings(){
        $adminDetails = Admin::where(['username'=>Session::get('adminSession')])->first();
        /* echo "<pre>"; print_r($adminDetails); die; */
        return view('admin.settings')->with(compact('adminDetails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
