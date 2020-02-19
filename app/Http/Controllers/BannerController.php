<?php

namespace App\Http\Controllers;

use App\banner;
use Symfony\Component\Console\Input\Input;
use Image;
use Illuminate\Http\Request;

class BannerController extends Controller
{   //Home page banner add
    public function addBanner(Request $request){

        if($request->isMethod('post')){
            $data = $request->all();
            //echo '<pre>'; print_r($data); die;

            $banner = new banner();
            $banner->title = $data['title'];
            $banner->link = $data['link'];
            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }

            //Upload images 

            if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                   // Upload Images after Resize
                   $extension = $image_tmp->getClientOriginalExtension();
                   $fileName = rand(111,99999).'.'.$extension;
                   $banner_path = 'images/frontend_images/banner-images/'.$fileName;
                    Image::make($image_tmp)->resize(1140, 340)->save($banner_path);
                    $banner->image = $fileName; 
                }
            }

            $banner->status = $status;
            $banner->save();
            return redirect('admin-panel/view-banner')->with('flash_message_success','Banner Added Succesfully');
        }
        return view('admin.banners.add-banner');
    }

    //Home page banner view
    public function viewBanner(){
        $banner = banner::get();
        return view('admin.banners.view-banner')->with(compact('banner'));
    }

    //Home page banner edit
    public function editBanner(Request $request, $id=null ){

        if($request->isMethod('post')){
            $data = $request->all();
            //echo '<pre>'; print_r($data); die;
            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }
            if(empty($data['title'])){
                $data['title'] = '';
            }
            if(empty($data['link'])){
                $data['link'] = '';
            }
            //Upload images 

            if($request->hasFile('image')){
                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                   // Upload Images after Resize
                   $extension = $image_tmp->getClientOriginalExtension();
                   $fileName = rand(111,99999).'.'.$extension;
                   $banner_path = 'images/frontend_images/banner-images/'.$fileName;
                   Image::make($image_tmp)->resize(1140, 340)->save($banner_path);
                }
                }else if(!empty($data['current_image'])){
                    $fileName = $data['current_image'];
                }else{
                    $fileName = '';
                }
            // Updated Image
            
            Banner::where('id',$id)->update(['status'=>$status,'title'=>$data['title'],'link'=>$data['link'],'image'=>$fileName]);
            return redirect()->back()->with('flash_message_success','Banner has been edited Successfully');

        }
        $bannerDetails = Banner::where('id',$id)->first();
        return view('admin.banners.edit-banner')->with(compact('bannerDetails'));
    }

    //Home page banner delete
    public function deleteBanner($id = null){
        banner::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Banner has been deleted successfully');
    }

}

