<?php

namespace App\Http\Controllers;
use App\coupon;
use Illuminate\Http\Request;

class couponController extends Controller
{
    public function addCoupon( Request $request){

        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $coupon = new coupon;
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->amount = $data['amount'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->status = $data['status'];
            $coupon->save();

            return redirect()->action('couponController@viewCoupon')->with('flash_massege_success','Coupon has been added successful');
        }
        return view('admin.coupons.add-coupon');
    }

    public function viewCoupon(){
        $coupons = coupon::get();
        return view('admin.coupons.view-coupons')->with(compact('coupons'));
    }
    
    public function editCoupon(Request $request,$id = null){
        if($request->isMethod('post')){
            $data = $request->all();
            $coupon = coupon::find($id);
            $coupon->coupon_code = $data['coupon_code'];
            $coupon->amount = $data['amount'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->expiry_date = $data['expiry_date'];
            if(empty($data['status'])){
                $data['status'] = 0;
            }
            $coupon->status = $data['status'];
            $coupon->save();

            return redirect()->action('couponController@viewCoupon')->with('flash_massege_success','Coupon has been updated successful');
        }
        $couponDetails = coupon::find($id);
        return view('admin.coupons.edit-coupon')->with(compact('couponDetails'));
    }

    //Delete Category Controller
    public function deletecoupon($id = null){
        coupon::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Coupon has been deleted successfully');
    }
}
