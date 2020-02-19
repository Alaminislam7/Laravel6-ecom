<?php

namespace App;
use Auth;
use Session;
use DB;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function attributes(){
        return $this->hasMany('App\product_attributes','product_id');
    }

    public static function cartCount(){
    	if(Auth::check()){
    		// User is logged in; We will use Auth
    		$user_email = Auth::user()->email;
    		$cartCount = DB::table('cart')->where('user_email',$user_email)->sum('quantity');
    	}else{
    		// User is not logged in. We will use Session
    		$session_id = Session::get('session_id');
    		$cartCount = DB::table('cart')->where('session_id',$session_id)->sum('quantity');
    	}
    	return $cartCount;
    }

    public static function productCount($cat_id){
        $productCount = Product::where(['category_id'=>$cat_id,'status'=>1])->count();
        return $productCount;
    }

    public static function getCurrencyRates($price){
        $getCurrency = Currency::where('status',1)->get();
        foreach( $getCurrency as $currency ){
            if($currency->currency_code == 'USD'){
                $USD_Rate = round($price/$currency->exchange_rate,2);
            }else if($currency->currency_code == 'GBR'){
                $GBR_Rate = round($price/$currency->exchange_rate,2);
            }else if($currency->currency_code == 'EUR'){
                $EUR_Rate = round($price/$currency->exchange_rate,2);
            }
        }
        $currencyArr = array('USD_Rate'=>$USD_Rate,'GBR_Rate'=>$GBR_Rate,'EUR_Rate'=>$EUR_Rate);
        return $currencyArr;
    }
}
