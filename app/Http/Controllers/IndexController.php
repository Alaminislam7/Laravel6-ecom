<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\banner;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){

        //In Random order
        $productAll = Product::inRandomOrder()->where('status',1)->where('feature_item',1)->paginate(3);

        //Get All category and subcategory
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();

        //Get All Home page banner
        $banners = banner::where('status','1')->get();

        //Meta tags
        $meta_title = "E-shop Broken Website";
        $meta_description = "Online Shopping site for Men, Women and Kind Cloting";
        $meta_keyourds = "Broken Website, Online Shopping, Men Cloting";

        return view('index')->with(compact('productAll','categories','banners','meta_title','meta_description','meta_keyourds'));

    }
}
