<?php
use App\Http\Controllers\Controller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\HomeController;

/* Route::get('/', function () {
    return view('welcome');
}); */


Route::match(['get','post'], '/admin-panel', 'AdminController@login');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//Index page
Route::get('/','IndexController@index');

//Category/Listing page
Route::get('/products/{url}','productController@products');

//Product filter page
Route::match(['get','post'], '/products/filter', 'productController@filter');

//Category Details page
Route::get('/product/{id}','productController@product');

//Get product Attributes price
Route::any('/get-product-price','productController@getproductprice');

//Cart page
Route::match(['get','post'], '/cart', 'productController@cart');

//Add to cart Page
Route::match(['get','post'], '/add-cart', 'productController@addtocart');

//Delete product from cart page
Route::get('/cart/delete-product/{id}','productController@deleteCartProduct');

//Update quantity in cart
Route::get('/cart/update-quantity/{id}/{quantity}','productController@updateCartQuantity');

//Apply Coupon
Route::post('/cart/apply-coupon','productController@applyCoupon');

//User Login Register Page
Route::get('/login-register','UserController@userLoginRegister');

//User Forget password
Route::match(['get','post'], '/forgot-password', 'UserController@userForgotPassword');

//User Register
Route::post('/user-register','UserController@register');

// Confirm Account
Route::get('confirm/{code}','UserController@confirmAccount');

//User login
Route::post('user-login','UserController@userLogin');

//User Logout
Route::get('user-logout','UserController@logout');

//Search Product
Route::post('/search-products','productController@searchProduct');


//All Routes after login
Route::group(['middleware' => 'Frontlogin'], function () {
    //User Account page
    Route::match(['get','post'], '/account', 'UserController@account');

    //Check user current password
    Route::get('/check-user-pwd','UserController@chkUserPassword');

    //update user password
    Route::post('/update-user-pwd','UserController@updatePassword');

    //Checkout page
    Route::match(['get', 'post'],'/checkout','productController@checkout');

    //Review page
    Route::match(['get','post'], '/order-review', 'productController@orderReview');

    //payment method
    Route::match(['get','post'], '/place-order', 'productController@placeOrder');

    //Thanks page
    Route::get('/thanks','productController@thanks');

    //Paypal page
    Route::get('/paypal','productController@paypal');

    //User Order page
    Route::get('/orders','productController@userOrder');

    //User Ordered Products Page
    Route::get('/orders/{id}','productController@userOrderDetails');

    //Paypal thanks Page
    Route::get('/paypal/thanks','productController@paypalThanks');

    //Paypal cancel Page
    Route::get('/paypal/cancel','productController@paypalCancel');
});



/* Route::match(['get','post'], '/login-register', 'UserController@register'); */

//Check if User already Exist
Route::match(['get','post'], '/check-email', 'UserController@checkEmail');

//Check pincode
Route::post('/check-pincode','productController@checkPincode');

//Admin Panel Route
Route::group(['middleware' => ['Adminlogin']], function () {

    //Admin panel(User login)
    Route::get('/admin-panel/dashboard','AdminController@dashboard');
    Route::get('/admin-panel/settings','AdminController@settings');
    Route::get('/admin-panel/check-pwd','AdminController@chackpassword');
    Route::match(['get','post'], '/admin-panel/update-password', 'AdminController@updatepassword');

    //Category route (Admin)
    Route::match(['get', 'post'],'/admin-panel/add-category','categoryController@addCategory');
    Route::match(['get', 'post'],'/admin-panel/edit-category/{id}','categoryController@editCategory');
    Route::match(['get','post'],'/admin-panel/delete-category/{id}','CategoryController@deleteCategory');
    Route::get('/admin-panel/view-category','categoryController@viewCategory');

    //Product Route(admin)
    Route::match(['get', 'post'], '/admin-panel/add-product', 'productController@addProduct');
    Route::match(['get','post'],'admin-panel/edit-product/{id}','productController@editProduct');
    Route::get('/admin-panel/view-product','productController@viewProduct');
    Route::get('/admin-panel/delete-product/{id}','productController@deleteProduct');
    Route::get('/admin-panel/delete-product-image/{id}','productController@deleteProductImage');
    Route::get('/admin-panel/delete-product-video/{id}','productController@deleteProductVideo');
    Route::get('/admin-panel/delete-alt-image/{id}','productController@deleteAlImage');

    //Add Product Attributes
    Route::match(['get', 'post'], '/admin-panel/add-attributes/{id}','productController@addAttributes');
    Route::match(['get', 'post'], '/admin-panel/edit-attributes/{id}','productController@editAttributes');
    Route::match(['get', 'post'], '/admin-panel/add-images/{id}','productController@addimages');
    Route::get('/admin-panel/delete-attribute/{id}','productController@deleteAttributes');

    //Coupon Routes
    Route::match(['get','post'],'admin-panel/add-coupon/','couponController@addCoupon');
    Route::get('/admin-panel/view-coupons','couponController@viewCoupon');
    Route::match(['get','post'],'admin-panel/edit-coupon/{id}','couponController@editCoupon');
    Route::get('/admin-panel/delete-coupon/{id}','couponController@deletecoupon');

    //Admin Banner Routes
    Route::match(['get','post'],'admin-panel/add-banner','BannerController@addBanner');
    Route::get('/admin-panel/view-banner','BannerController@viewBanner');
    Route::match(['get','post'],'/admin-panel/edit-banner/{id}','BannerController@editBanner');
    Route::get('/admin-panel/delete-banner/{id}','BannerController@deleteBanner');

    //Admin Orders Pages
    Route::get('/admin-panel/view-orders','productController@viewOrders');

    //Admin Orders Details Pages
    Route::get('/admin-panel/view-order/{id}','productController@viewOrderDetails');

    //Order Invoice
    Route::get('/admin-panel/view-order-invoice/{id}','productController@viewOrderInvoice');

    //Admin Update order status
    Route::post('admin-panel/update-order-status','productController@updateOrder');

    //Admin User
    Route::get('admin-panel/view-users','UserController@viewUser');

    //Add cms page
    Route::match(['get','post'],'admin-panel/add-cms','CmsController@addCmsPage');

    //Edit cms page
    Route::match(['get','post'],'admin-panel/edit-cms/{id}','CmsController@editCmsPage');
    
    //Edit cms page
    Route::match(['get','post'],'admin-panel/delete-cms/{id}','CmsController@deleteCmsPage');
    
    //View Cms Page
    Route::get('admin-panel/view-cms','CmsController@viewCmsPage');
    
    //Currancy Route
    //Add Currency
    Route::match(['get','post'],'admin-panel/add-currency','currencyController@addCurrency');

    //Edit currency
    Route::match(['get','post'],'admin-panel/edit-currency/{id}','currencyController@editCurrency');
    
    //View Currency
    Route::get('admin-panel/view-currencies','currencyController@viewCurrencies');

});

Route::get('/logout', 'AdminController@logout');

//Display Contack page
Route::match(['get','post'],'page/contact','CmsController@contact');

//Display Cms page
Route::match(['get','post'],'/page/{url}','CmsController@cmsPage');




