<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use Image;
use Session;
use App\User;
use App\coupon;
use App\country;
use App\product;
use App\order;
use App\category;
use App\ProductsImages;
use App\deliveryAddress;
use App\product_attributes;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ordersProduct;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Console\Input\Input;

class productController extends Controller
{

    //Add Product Controller (Admin)
    public function addProduct(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $product = new Product;
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            if(!empty($data['description'])){
                $product->description = $data['description'];
            }else{
                $product->description = '';
            }
            if(!empty($data['care'])){
                $product->care = $data['care'];
            }else{
                $product->care = '';
            }
            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }
            if(empty($data['feature_item'])){
                $feature_item = 0;
            }else{
                $feature_item = 1;
            }

            $product->price = $data['price'];

            //Upload images 
            if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                    $extention = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extention;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;

                    //Resize Images

                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);

                    //Store image name in products table
                    $product->Image = $filename;
                }
            }
            //Upload videos
            if($request->hasFile('video')){
                $video_tmp = $request->file('video');
                $video_name = $video_tmp->getClientOriginalName();
                $video_path = 'videos/';
                $video_tmp->move($video_path,$video_name);
                $product->video = $video_name;
            }
            
            $product->status = $status;
            $product->feature_item = $feature_item;
            $product->save();
            return redirect('admin-panel/view-product')->with('flash_message_success','Product Added Succesfully');

            }

        //Category Dropdown Start
        $categories = category::where(['parent_id'=>0])->get();
        $category_drowdown = "<option selected desabled>Select</option>";
        foreach($categories as $cat){
            $category_drowdown .="<option value='".$cat->id."'>".$cat->category_name."</option>";
            $sub_category = category::where(['parent_id'=>$cat->id])->get();
            foreach ($sub_category as $sub_cat){
                $category_drowdown .="<option value='".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->category_name."</option>";
            }
        }
        return view('admin.products.add-product')->with(compact('category_drowdown'));

        //End Category Dropdown
    }


    //View Product Controller (Admin)
    public function viewProduct(){
        $product = product::orderBy("id","desc")->get();
        //echo '<pre>'; print_r($product); die;
        $product = json_decode(json_encode($product));
        //Category name in product
        foreach($product as $key => $val){
            $category_name = category::where(['id'=>$val->category_id])->first();
            $product[$key]->category_name = $category_name->category_name;
        }
        //echo '<pre>'; print_r($product); die;
        return view('admin.products.view-product')->with(compact('product'));
    }
    

    //Edit Product Controller (Admin)
    public function editProduct(Request $request,$id=null){
        
        if($request->isMethod('post')){
            $data = $request->all();

            if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                    $extention = $image_tmp->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extention;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;

                    //Resize Images

                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(600,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(300,300)->save($small_image_path);

                }

            }else if(!empty($data['current_image'])){
                $filename = $data['current_image'];
            }else{
                $filename = "";
            }
             //Edit videos
             if($request->hasFile('video')){
                $video_tmp = $request->file('video');
                $video_name = $video_tmp->getClientOriginalName();
                $video_path = 'videos/';
                $video_tmp->move($video_path,$video_name);
                $videoName = $video_name;
            }else if(!empty($data['current_video'])){
                $videoName = $data['current_video'];
            }else{
                $videoName = '';
            }

            if(empty($data['description'])){
                $data['description'] = '';
            }

            if(empty($data['care'])){
                $data['care'] = '';
            }

            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }
            if(empty($data['feature_item'])){
                $feature_item = 0;
            }else{
                $feature_item = 1;
            }
            
            //Edit product Updated
            product::where(['id'=>$id])->update(['category_id'=>$data['category_id'],'product_name'=>$data['product_name'],'product_code'=>$data['product_code'],'product_color'=>$data['product_color'],'description'=>$data['description'],'care'=>$data['care'],'price'=>$data['price'],'image'=>$filename,'video'=>$videoName,'status'=>$status,'feature_item'=>$feature_item]);

            return redirect()->back()->with('flash_message_success','Product Updated Succesfully');
        }

        //Get product details
        $productDetails = product::where(['id'=>$id])->first();
        //echo '<pre>'; print_r($productDetails);

        //Category Dropdown Start
        $categories = category::where(['parent_id'=>0])->get();
        $category_drowdown = "<option value='' selected desabled>Select</option>";
        foreach($categories as $cat){
            if($cat->id==$productDetails->category_id){
                $selected = "selected";
            }else{
                $selected = "";
            }
            $category_drowdown .="<option value='".$cat->id."' ".$selected." >".$cat->category_name."</option>";
            $sub_category = category::where(['parent_id'=>$cat->id])->get();
            foreach ($sub_category as $sub_cat){
                if($sub_cat->id==$productDetails->category_id){
                    $selected = "selected";
                }else{
                    $selected = "";
                }
                $category_drowdown .="<option value='".$sub_cat->id."' ".$selected.">&nbsp;--&nbsp;".$sub_cat->category_name."</option>";
            }
        }
        //End Category Dropdown

        return view('admin.products.edit-product')->with(compact('productDetails','category_drowdown'));
    }


    //Delete Product video
    public function deleteProductVideo($id){
        //Get video name
        $productVideo = Product::select('video')->where('id',$id)->first();

        //Get video path
        $video_path = 'video/';

        //Delete video if exist in video folder
        if(file_exists($video_path.$productVideo->video)){
            unlink($video_path.$productVideo->video);
        }

        //Delete video from product table
        Product::where('id',$id)->update(['video'=>'']);
        return redirect()->back()->with('flash_message_success','Product video has been deleted successfull');
    }

    //Delete Product image Controller (Admin)
    public function deleteProductImage($id = null){
        //Get Product image name
        $productimage = product::where(['id'=>$id])->first();

        //Get Product image path
        $large_image_path = 'images/backend_images/products/large/';
        $medium_image_path = 'images/backend_images/products/medium/';
        $small_image_path = 'images/backend_images/products/small/';

        //Delete large image if not exists in folder
        if(file_exists($large_image_path.$productimage->image)){
            unlink($large_image_path.$productimage->image);
        }

        //Delete Medium image if not exists in folder
        if(file_exists($medium_image_path.$productimage->image)){
            unlink($medium_image_path.$productimage->image);
        }

        //Delete Small image if not exists in folder
        if(file_exists($small_image_path.$productimage->image)){
            unlink($small_image_path.$productimage->image);
        }

        product::where(['id'=>$id])->update(['image'=>'']);
        return redirect()->back()->with('flash_message_success','Product Image has been deleted Succesfully');
    }
    //Delete Product image Controller (Admin)
    public function deleteAlImage($id = null){
        //Get Product image name
        $productimage = ProductsImages::where(['id'=>$id])->first();

        //Get Product image path
        $large_image_path = 'images/backend_images/products/large/';
        $medium_image_path = 'images/backend_images/products/medium/';
        $small_image_path = 'images/backend_images/products/small/';

        //Delete large image if not exists in folder
        if(file_exists($large_image_path.$productimage->image)){
            unlink($large_image_path.$productimage->image);
        }

        //Delete Medium image if not exists in folder
        if(file_exists($medium_image_path.$productimage->image)){
            unlink($medium_image_path.$productimage->image);
        }

        //Delete Small image if not exists in folder
        if(file_exists($small_image_path.$productimage->image)){
            unlink($small_image_path.$productimage->image);
        }

        ProductsImages::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Product Alternate Image has been deleted Succesfully');
    }


    //Delete Product Controller (Admin)
    public function deleteProduct($id = null){
        Session::forget('couponAmount');
        Session::forget('couponCode');
        product::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Product has been deleted Succesfully');
    }


    //Add Product Attributes
    public function addAttributes(Request $request,$id=null){
        $productDetails = product::with('attributes')->where(['id'=>$id])->first();
        //$productDetails = json_decode(json_encode($productDetails));
        //echo '<pre>'; print_r($productDetails); die;
        if($request->isMethod('post')){
            $data = $request->all();

            foreach($data['sku'] as $key => $val){
                if(!empty($val)){

                    //Prevent Duplicate SKU check
                    $attrCountSKU = product_attributes::where('sku',$val)->count();
                    if($attrCountSKU>0){
                        return redirect('/admin-panel/add-attributes/'.$id)->with('flash_message_error','SKU Already Exist ! Please Add Another SKU');
                    }

                    //Prevent Duplicate Size check
                    $attrCountSize = product_attributes::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                    if($attrCountSize>0){
                        return redirect('/admin-panel/add-attributes/'.$id)->with('flash_message_error','"'.$data['size'][$key].'"SIZE Already Exist ! Please Add Another SIZE');
                    }

                    //Product attributes add
                    $attr = new product_attributes;
                    $attr->product_id = $id;
                    $attr->sku = $val;
                    $attr->size = $data['size'][$key];
                    $attr->price = $data['price'][$key];
                    $attr->stock = $data['stock'][$key];
                    $attr->save();
                }
            }
            return redirect('/admin-panel/add-attributes/'.$id)->with('flash_message_success','Product Attributes has been updated Succesfully');
        }
        return view('admin.products.add-attributes')->with(compact('productDetails'));
    }



    //Edit Product Attribute
    public function editAttributes(Request $request, $id=null){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            foreach($data['idAttr'] as $key=> $attr){
                if(!empty($attr)){
                    product_attributes::where(['id' => $data['idAttr'][$key]])->update(['price' => $data['price'][$key], 'stock' => $data['stock'][$key]]);
                }
            }
            return redirect('admin-panel/add-attributes/'.$id)->with('flash_message_success', 'Product Attributes has been updated successfully');
        }
    }



    //Add Product Attributes
    public function addImages(Request $request, $id=null){
        $productDetails = Product::where(['id' => $id])->first();

        if($request->isMethod('post')){
            $data = $request->all();
            if($request->hasFile('image')){
                $files = $request->file('image');
                foreach($files as $file){
                    //Upload images after resize
                    $image = new ProductsImages;
                    $extention = $file->getClientOriginalExtension();
                    $filename = rand(111,99999).'.'.$extention;
                    $large_image_path = 'images/backend_images/products/large/'.$filename;
                    $medium_image_path = 'images/backend_images/products/medium/'.$filename;
                    $small_image_path = 'images/backend_images/products/small/'.$filename;
                    Image::make($file)->save($large_image_path);
                    Image::make($file)->resize(600,600)->save($medium_image_path);
                    Image::make($file)->resize(300,300)->save($small_image_path);
                    $image->image = $filename;
                    $image->product_id = $data['product_id'];
                    $image->save();
                }
            }
            return redirect('/admin-panel/add-images/'.$id)->with('flash_message_success','Images Has Been Updated Success');
        }
        $productImages = ProductsImages::where(['product_id' => $id])->orderBy('id','DESC')->get();

        return view('admin.products.add-images')->with(compact('productDetails','productImages'));
    }



    //Delete Product Attributes
    public function deleteAttributes($id = null){
        product_attributes::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success','Product has been deleted Succesfully');
    }


    public function products($url=null){
        //------------------akhane problem ase--------------------------//
    	// Show 404 Page if Category does not exists
    	$categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
    	if($categoryCount==0){
    		abort(404);
    	}

    	$categories = Category::with('categories')->where(['parent_id' => 0])->get();

    	$categoryDetails = Category::where(['url'=>$url])->first();
    	if($categoryDetails->parent_id==0){
    		$subCategories = Category::where(['parent_id'=>$categoryDetails->id])->get();
    		//$subCategories = json_decode(json_encode($subCategories));
    		foreach($subCategories as $subcat){
    			$cat_ids[] = $subcat->id;
    		}
    		$productAll = Product::whereIn('products.category_id', $cat_ids)->where('products.status','1')->orderBy('products.id','Desc');
            $breadcrumb = "<a href='/'>Home</a> / <a href='".$categoryDetails->url."'>".$categoryDetails->name."</a>";
    	}else{
    		$productAll = Product::where(['products.category_id'=>$categoryDetails->id])->where('products.status','1')->orderBy('products.id','Desc');
            $mainCategory = Category::where('id',$categoryDetails->parent_id)->first();
            $breadcrumb = "<a href='/'>Home</a> / <a href='".$mainCategory->url."'>".$mainCategory->name."</a> / <a href='".$categoryDetails->url."'>".$categoryDetails->name."</a>";	
    	}


        $productAll = $productAll->paginate(3);
        /*$productsAll = json_decode(json_encode($productsAll));
        echo "<pre>"; print_r($productsAll); die;*/

        /*$colorArray = array('Black','Blue','Brown','Gold','Green','Orange','Pink','Purple','Red','Silver','White','Yellow');*/

        
        /*echo "<pre>"; print_r($sizesArray); die;*/

        $meta_title = $categoryDetails->meta_title;
        $meta_description = $categoryDetails->meta_description;
        $meta_keyourds = $categoryDetails->meta_keyourds;
        //echo "<pre>"; print_r($meta_keyourds); die;
    	return view('products.listing')->with(compact('categories','productAll','categoryDetails','meta_title','meta_description','meta_keyourds','url','breadcrumb'));
    }


    //Product Search
    public function searchProduct(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            //Get all cateogry and subcategories
            $categories = Category::with('categories')->where(['parent_id'=>0])->get();
            $search_product = $data['product'];
            /* $productAll = product::where('product_name','like','%'.$search_product.'%')->orwhere('product_code',$search_product)->where('status',1)->get(); */
            $productAll = Product::where(function($query) use($search_product){
                $query->where('product_name','like','%'.$search_product.'%')
                ->orwhere('product_code','like','%'.$search_product.'%')
                ->orwhere('description','like','%'.$search_product.'%')
                ->orwhere('product_color','like','%'.$search_product.'%');
            })->where('status',1)->get();
            return view('products.listing')->with(compact('categories','productAll','search_product'));
        }
    }

    //Category/Product Details page
    public function product($id = null){
        //Show 404 page if product is disable
        $productCount = Product::where(['id'=>$id,'status'=>1])->count();
        //echo $countCategory; die;
        if($productCount==0){
            abort(404);
        }

        //Get product Details
        $productDetails = Product::with('attributes')->where(['id'=>$id])->first();
        $productDetails = json_decode(\json_encode($productDetails));
        //echo "<pre>"; print_r($productDetails); die;

        //Get all category and subcategory
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();

        //Get product alternet image
        $productAltimage = ProductsImages::where(['product_id'=>$id])->get();

        //Get stock availablity
        $total_stock = product_attributes::where(['product_id'=>$id])->sum('stock');

        //Get Recomended/Related product in same category
        $RelatedProduct = Product::where('id','!=',$id)->where(['category_id'=>$productDetails->category_id])->get();
        /* $RelatedProduct = json_decode(json_encode($RelatedProduct)); */
        $meta_title = $productDetails->product_name;
        $meta_description = $productDetails->description;
        $meta_keyourds = $productDetails->product_name;

        return view('products.detail')->with(compact('productDetails','categories','productAltimage','total_stock','RelatedProduct','meta_title','meta_description','meta_keyourds'));
    }



    /*
    ---------------ETA PRODUCT ER TAKAR SATHA USD,GBR,EUR -----------CHANGE HOBE--------ETA JAVASCRIPT ER ERROR DICCE-------------------------
    $data = $request->all();
        //echo "<pre>"; print_r($data); die;
        $proArr = explode("-",$data['idSize']);
        $proAttr = product_attributes::where(['product_id' => $proArr[0],'size' => $proArr[1]])->first();
        $getCurrencyRates = Product::getCurrencyRates($proAttr->price);
        echo $proAttr->price."-".$getCurrencyRates['USD_Rate']."-".$getCurrencyRates['GBP_Rate']."-".$getCurrencyRates['EUR_Rate'];
        echo "#";
        echo $proAttr->stock;
 */


 
    //Get product attributes price with ajax
    public function getproductprice(Request $request){
        $data = $request->all();
        //echo "<pre>"; print_r($data); die;
        $proArr = explode("-",$data['idSize']);
        $proAttr = product_attributes::where(['product_id' => $proArr[0],'size' => $proArr[1]])->first();
        /* $getCurrencyRates = Product::getCurrencyRates($proAttr->price);
        echo $proAttr->price."-".$getCurrencyRates['USD_Rate']."-".$getCurrencyRates['GBP_Rate']."-".$getCurrencyRates['EUR_Rate']; */
        echo $proAttr->price;
        echo "#";
        echo $proAttr->stock;
    }


    //Add to cart 
    public function addtocart(Request $request){
        Session::forget('couponAmount');
        Session::forget('couponCode');

        $data = $request->all();

        // Check Product Stock is available or not
        $product_size = explode("-",$data['size']);
        $getProductStock = product_attributes::where(['product_id'=>$data['product_id'],'size'=>$product_size[1]])->first();

        if($getProductStock->stock<$data['quantity']){
            return redirect()->back()->with('flash_message_error','Required Quantity is not available!');
        }

        if(empty(Auth::user()->email)){
            $data['user_email'] = '';    
        }else{
            $data['user_email'] = Auth::user()->email;
        }

        $session_id = Session::get('session_id');
        if(!isset($session_id)){
            $session_id = Str::random(40);
            Session::put('session_id',$session_id);
        }

        $sizeIDArr = explode('-',$data['size']);
        $product_size = $sizeIDArr[1];

        if(empty(Auth::check())){
            $countProducts = DB::table('cart')->where(['product_id' => $data['product_id'],'product_color' => $data['product_color'],'size' => $product_size,'session_id' => $session_id])->count();
            if($countProducts>0){
                return redirect()->back()->with('flash_message_error','Product already exist in Cart!');
            }
        }else{
            $countProducts = DB::table('cart')->where(['product_id' => $data['product_id'],'product_color' => $data['product_color'],'size' => $product_size,'user_email' => $data['user_email']])->count();
            if($countProducts>0){
                return redirect()->back()->with('flash_message_error','Product already exist in Cart!');
            }    
        }
        

        $getSKU = product_attributes::select('sku')->where(['product_id' => $data['product_id'], 'size' => $product_size])->first();
                
        DB::table('cart')
        ->insert(['product_id' => $data['product_id'],'product_name' => $data['product_name'],
            'product_code' => $getSKU['sku'],'product_color' => $data['product_color'],
            'price' => $data['price'],'size' => $product_size,'quantity' => $data['quantity'],'user_email' => $data['user_email'],'session_id' => $session_id]);

        return redirect('cart')->with('flash_message_success','Product has been added in Cart!');
    }    


    //Cart Page Controller
    public function cart(){
        if(Auth::check()){
            $user_email = Auth::user()->email;
            $userCart = DB::table('cart')->where(['user_email'=>$user_email])->get();
        }else{
            $session_id = Session::get('session_id');
            $userCart = DB::table('cart')->where(['session_id'=>$session_id])->get();
        }
        foreach($userCart as $key => $product){
            $productDetails = Product::where('id',$product->product_id)->first();
            $userCart[$key]->image = $productDetails->image;
        }
        //echo "<pre>"; print_r($userCart); die;
        $meta_title = "Shopping cart Broken E-com";
        $meta_description = "View Shopping cart Broken E-com";
        $meta_keyourds = "Shopping cart Broken E-com";
        return view('products.cart')->with(compact('userCart','meta_title','meta_description','meta_keyourds'));
    }


    //Cart product Deleted
    public function deleteCartProduct($id = null){
        Session::forget('couponAmount');
        Session::forget('couponCode');
        DB::table('cart')->where(['id'=>$id])->delete();
        //echo $id; die;
        return redirect('cart')->with('flash_message_success','Product has been deleted successful!');
    }


    //update cart quantity
    public function updateCartQuantity($id=null,$quantity=null){
        Session::forget('couponAmount');
        Session::forget('couponCode');
        $getProductSKU = DB::table('cart')->select('product_code','quantity')->where('id',$id)->first();
        $getProductStock = product_attributes::where('sku',$getProductSKU->product_code)->first();
        $updated_quantity = $getProductSKU->quantity+$quantity;
        //dd($getProductStock);
        if($getProductStock->stock>=$updated_quantity){
            DB::table('cart')->where('id',$id)->increment('quantity',$quantity); 
            return redirect('cart')->with('flash_message_success','Product Quantity has been updated in Cart!');   
        }else{
            return redirect('cart')->with('flash_message_error','Required Product Quantity is not available!');    
        }
    }


    //Apply Coupon
    public function applyCoupon(Request $request){
        Session::forget('couponAmount');
        Session::forget('couponCode');

        $data = $request->all();
        $couponCount = coupon::where('coupon_code',$data['coupon_code'])->count();
        if($couponCount==0){
            return redirect()->back()->with('flash_message_error','This Coupon does not exist!');
        }else{
            //Get coupon Details
            $couponDetails = coupon::where('coupon_code',$data['coupon_code'])->first();

            //If Coupon is inactive
            if($couponDetails->status==0){
                return redirect()->back()->with('flash_message_error','This Coupon is not active!');
            }
            // If coupon is Inactive
            if($couponDetails->status==0){
                return redirect()->back()->with('flash_message_error','This coupon is not active!');
            }

            //If coupon is Expire
            $expiry_date = $couponDetails->expiry_date;
            $courent_date = date('Y-m-d');
            if($expiry_date < $courent_date){
                return redirect()->back()->with('flash_message_error','This Coupon is expire!');
            }

            //Get cart total amount
            $session_id = Session::get('session_id');
            if(Auth::check()){
                $user_email = Auth::user()->email;
                $userCart = DB::table('cart')->where(['user_email' => $user_email])->get();     
            }else{
                $session_id = Session::get('session_id');
                $userCart = DB::table('cart')->where(['session_id' => $session_id])->get();    
            }

            $total_amount = 0;
            foreach($userCart as $item){
                $total_amount = $total_amount + ($item->price * $item->quantity);
            }

            //Check amount type is fixed or percentage
            if($couponDetails->amount_type=='Fixed'){
                $couponAmount = $couponDetails->amount;
            }else{
                //echo $total_amount; die;
                $couponAmount = $total_amount * ($couponDetails->amount/100);
            }

            //Add coupon code and amount in session
            Session::put('couponAmount',$couponAmount);
            Session::put('couponCode',$data['coupon_code']);
            return redirect()->back()->with('flash_message_error','You are available discount');
        }
    }


    //Checkout page
    public function checkout( Request $request){
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::find($user_id);
        $countries = Country::get();
        //Check if shiping address exist
        $shippingCount = deliveryAddress::where('user_id',$user_id)->count();
        $shippingDetails = array();
        if($shippingCount>0){
            $shippingDetails = deliveryAddress::where('user_id',$user_id)->first();
        }
        //Update cart table with user email
        $session_id = Session::get('session_id');
        DB::table('cart')->where(['session_id'=>$session_id])->update(['user_email'=>$user_email]);

        if($request->isMethod('post')){
            $data = $request->all();
            if(empty($data['billing-name']) || empty($data['billing-address']) || empty($data['billing-city']) || empty($data['billing-state']) || empty($data['billing-country']) || empty($data['billing-pincode']) || empty($data['billing-mobile']) || empty($data['shipping-name']) || empty($data['shipping-address']) || empty($data['shipping-city']) || empty($data['shipping-state']) || empty($data['shipping-country']) || empty($data['shipping-pincode']) || empty($data['shipping-mobile'])){
                return redirect()->back()->with('flash_message_error','Please fill the all fields!');
            }

            //Update user details
            User::where('id',$user_id)->update(['name'=>$data['billing-name'],'address'=>$data['billing-address'],'city'=>$data['billing-city'],'state'=>$data['billing-state'],'country'=>$data['billing-country'],'pincode'=>$data['billing-pincode'],'mobile'=>$data['billing-mobile']]);

            if($shippingCount>0){
                //Update shipping address
                deliveryAddress::where('user_id',$user_id)->update(['name'=>$data['shipping-name'],'address'=>$data['shipping-address'],'city'=>$data['shipping-city'],'state'=>$data['shipping-state'],'country'=>$data['shipping-country'],'pincode'=>$data['shipping-pincode'],'mobile'=>$data['shipping-mobile']]);
            }else{
                //Add new shipping address
                $shipping = new deliveryAddress;
                $shipping->user_id = $user_id;
                $shipping->user_email = $user_email;
                $shipping->name = $data['shipping-name'];
                $shipping->address = $data['shipping-address'];
                $shipping->city = $data['shipping-city'];
                $shipping->state = $data['shipping-state'];
                $shipping->country = $data['shipping-country'];
                $shipping->pincode = $data['shipping-pincode'];
                $shipping->mobile = $data['shipping-mobile'];
                $shipping->save();
            }
            
            $pincodeCount = DB::table('pincodes')->where('pincode',$data['shipping-pincode'])->count();
            if($pincodeCount == 0){
                return redirect()->back()->with('flash_message_error','Your location is not available for delivery. Please enter another location.');
            }

            return redirect()->action('productController@orderReview');
        }
        $meta_title = "Checkout E-shop";
        return view('products.checkout')->with(compact('userDetails','countries','shippingDetails','meta_title'));
    }


    //Order review page
    public function orderReview(){
        $user_id = Auth::user()->id;
        $user_email = Auth::user()->email;
        $userDetails = User::where('id',$user_id)->first();
        $shippingDetails = deliveryAddress::where('user_id',$user_id)->first();
        //Cart information
        $userCart = DB::table('cart')->where(['user_email'=>$user_email])->get();
        foreach($userCart as $key => $product){
            $productDetails = Product::where('id',$product->product_id)->first();
            $userCart[$key]->image = $productDetails->image;
        }
        $codPincodeCount = DB::table('cod_pincodes')->where('pincode',$shippingDetails->pincode)->count();
        $prepaidPincodeCount = DB::table('prepaid_pincodes')->where('pincode',$shippingDetails->pincode)->count();
        return view('products.order-review')->with(compact('shippingDetails','userDetails','userCart','codPincodeCount','prepaidPincodeCount'));
    }


    //Payment method
    public function placeOrder(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $user_id = Auth::user()->id;
            $user_email = Auth::user()->email;
            //Shipping address for user
            $shippingDetails = deliveryAddress::where(['user_email'=>$user_email])->first();
            $pincodeCount = DB::table('pincodes')->where('pincode',$shippingDetails->pincode)->count();
            if($pincodeCount == 0){
                return redirect()->back()->with('flash_message_error','Your location is not available for delivery. Please enter another location.');
            }
            //echo "<pre>"; print_r($shippingDetails); die;
            if(empty(Session::get('couponCode'))){
                $coupon_code = ''; 
             }else{
                $coupon_code = Session::get('couponCode'); 
             }
 
             if(empty(Session::get('couponAmount'))){
                $coupon_amount = ''; 
             }else{
                $coupon_amount = Session::get('couponAmount'); 
             }

            $order = new Order;
            $order->user_id = $user_id;
            $order->user_email = $user_email;
            $order->name = $shippingDetails->name;
            $order->address = $shippingDetails->address;
            $order->city = $shippingDetails->city;
            $order->state = $shippingDetails->state;
            $order->pincode = $shippingDetails->pincode;
            $order->country = $shippingDetails->country;
            $order->mobile = $shippingDetails->mobile;
            $order->coupon_code = $coupon_code;
            $order->coupon_amount = $coupon_amount;
            $order->order_status = "New";
            $order->payment_method = $data['payment_method'];
            $order->grand_total = $data['grand_total'];
            $order->save();


            $order_id = DB::getPdo()->lastInsertId();
            $cartProducts = DB::table('cart')->where(['user_email'=>$user_email])->get();
            foreach($cartProducts as $pro){
                $cartPro = new ordersProduct;
                $cartPro->order_id = $order_id;
                $cartPro->user_id = $user_id;
                $cartPro->product_id = $pro->product_id;
                $cartPro->product_code = $pro->product_code;
                $cartPro->product_name = $pro->product_name;
                $cartPro->product_color = $pro->product_color;
                $cartPro->product_size = $pro->size;
                $cartPro->product_price = $pro->price;
                $cartPro->product_qty = $pro->quantity;
                $cartPro->save();
            }
            Session::put('order_id',$order_id);
            Session::put('grand_total',$data['grand_total']);
            if($data['payment_method']=="COD"){
                $productDetails = order::with('orders')->where('id',$order_id)->first();
                /* echo "<pre>"; print_r($productDetails); */
                $userDetails = User::where('id',$user_id)->first();
                /* echo "<pre>"; print_r($userDetails); die; */
                /*Code for order email start*/

                $email = $user_email;
                $messageData = [
                    'email'             =>$user_email,
                    'name'              =>$shippingDetails->name,
                    'order_id'          =>$order_id,
                    'productDetails'    =>$productDetails,
                    'userDetails'       =>$userDetails
                ];
                Mail::send('emails.order',$messageData,function($message)use($email){
                    $message->to($email)->subject('Order Placed Broken Website');
                });

                /*Code for order email end*/

                //COD- Redirect user thanks page after saving order
                return redirect('/thanks');
            }else{
                //paypal- Redirect user to paypal page after saving order
                return redirect('/paypal');
            }
            

        }
    }


    //Thanks page
    public function thanks(Request $request){
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email',$user_email)->delete();
        return view('orders.thanks');
    }


    //Paypal page
    public function paypal(Request $request){
        $user_email = Auth::user()->email;
        DB::table('cart')->where('user_email',$user_email)->delete();
        return view('orders.paypal');
    }


    //Paypal thanks page
    public function paypalThanks(Request $request){
        return view('orders.thanks_paypal');
    }



    //Paypal thanks page
    public function paypalCancel(Request $request){
        return view('orders.cancel_paypal');
    }


    //User order page
    public function userOrder(){
        $user_id = Auth::user()->id;
        $orders = order::with('orders')->where('user_id',$user_id)->orderBy('id','DESC')->get();
        /* $orders = json_decode(json_encode($orders));
        echo "<pre>"; print_r($orders); die; */
        return view('orders.users_orders')->with(compact('orders'));
    }


    //User ordered details
    public function userOrderDetails($order_id){
        $user_id = Auth::user()->id;
        $orderDetails = order::with('orders')->where('id',$order_id)->first();
        $orderDetails = json_decode(json_encode($orderDetails));
        /* echo "<pre>"; print_r($orderDetails); die; */
        return view('orders.user_order_details')->with(compact('orderDetails'));
    }


    //Admin ordered pages
    public function viewOrders(){
        $orders = order::with('orders')->orderBy('id','DESC')->get();
        //DD($orders);
        return view('admin.orders.view-orders')->with(compact('orders'));
    }


    //Admin Ordered Details page
    public function viewOrderDetails($order_id){
        $orderDetails = order::with('orders')->where('id',$order_id)->first();
        //dd($orderDetails);
        $user_id = $orderDetails->user_id;
        $userDetails = user::where('id',$user_id)->first();
        return view('admin.orders.order-details')->with(compact('orderDetails','userDetails'));
    }


    //Admin Invoice Ordered Details page
    public function viewOrderInvoice($order_id){
        $orderDetails = order::with('orders')->where('id',$order_id)->first();
        //dd($orderDetails);
        $user_id = $orderDetails->user_id;
        $userDetails = user::where('id',$user_id)->first();
        return view('admin.orders.order-invoice')->with(compact('orderDetails','userDetails'));
    }

    //Admin Update order status
    public function updateOrder(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //dd($data);
            Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
            //order::where('id',$data['order_id'])->update(['order_status',$data['order_status']]);
            return redirect()->back()->with('flash_message_success','Order status has been updated Successful!');
        }
    }

    //Check pincode
    public function checkPincode(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            echo $pincodeCount = DB::table('pincodes')->where('pincode',$data['pincode'])->count();
        }
    }








}
