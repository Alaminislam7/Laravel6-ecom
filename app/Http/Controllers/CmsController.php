<?php

namespace App\Http\Controllers;

use App\CmsPage;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;
use App\Http\Controllers\Controller;

class CmsController extends Controller
{
    //Add cms page
    public function addCmsPage(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            if(empty($data['meta_title'])){
                $data['meta_title'] = "";
            }
            if(empty($data['meta_description'])){
                $data['meta_description'] = "";
            }
            if(empty($data['meta_keyourds'])){
                $data['meta_keyourds'] = "";
            }
            $cmsPage = new CmsPage;
            $cmsPage->title = $data['title'];
            $cmsPage->description = $data['description'];
            $cmsPage->url = $data['url'];
            $cmsPage->meta_title = $data['meta_title'];
            $cmsPage->meta_description = $data['meta_description'];
            $cmsPage->meta_keyourds = $data['meta_keyourds'];
            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }
            $cmsPage->status = $status;
            $cmsPage->save();
            return \redirect()->back()->with('flash_message_success','Cms Page has been added successfull');
        }
        return view('admin.pages.add-cms-page');
    }

    //view cms page
    public function viewCmsPage(){
        $cmsPages = CmsPage::get();
        return view('admin.pages.view-cms-page')->with(compact('cmsPages'));
    }

    //Edit cms page
    public function editCmsPage(Request $request,$id){
        if($request->isMethod('post')){
            $data = $request->all();
            if(empty($data['meta_title'])){
                $data['meta_title'] = "";
            }
            if(empty($data['meta_description'])){
                $data['meta_description'] = "";
            }
            if(empty($data['meta_keyourds'])){
                $data['meta_keyourds'] = "";
            }
            CmsPage::where('id',$id)->update(['title'=>$data['title'],'url'=>$data['url'],'description'=>$data['description'],'meta_title'=>$data['meta_title'],'meta_description'=>$data['meta_description'],'meta_keyourds'=>$data['meta_keyourds'],'status'=>$data['status']]);
            return redirect()->back()->with('flash_message_success','CMS page has been updated successfull');
        }
        $cmsPage = CmsPage::where('id',$id)->first();
        return view('admin.pages.edit-cms-page')->with(compact('cmsPage'));
    }

    //Delete cms page
    public function deleteCmsPage($id){
        CmsPage::where('id',$id)->delete();
        return redirect('admin-panel/view-cms')->with('flash_message_success','CMS page has been deleted successfull');
    }

    //Display cms page
    public function cmsPage($url){
        //Redirect 404 page if Cms page is disable
        $cmsPageCount = CmsPage::where(['url'=>$url,'status'=>1])->count();
        if($cmsPageCount > 0){
            $cmsPageDetails = CmsPage::where('url',$url)->first();
            $meta_title = $cmsPageDetails->meta_title;
            $meta_description = $cmsPageDetails->meta_description;
            $meta_keyourds = $cmsPageDetails->meta_keyourds;
        }else{
            abort(404);
        }
        //Get All category and subcategory
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();
        return view('pages.cms-pages')->with(compact('cmsPageDetails','categories','meta_title','meta_description','meta_keyourds'));
    }

    //Dispay contact page
    public function contact(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();

            //laravel validation
            $Validator = Validator::make($request->all(), [
                'name' => 'required|regex:/^[\pL\s\-]+$/u|max:255',
                'email' => 'required|email',
                'subject' => 'required',
            ]);
            if ($Validator->fails()) { 
                return redirect()->back()->withErrors($Validator)->withInput();
            }
            //echo "<pre>"; print_r($data); die;
            $email = "wdevalamin@gmail.com";
            $messageData = [
                'name'=>$data['name'],
                'email'=>$data['email'],
                'subject'=>$data['subject'],
                'comment'=>$data['message'],
            ];
            Mail::send('emails.enquary',$messageData,function($message)use($email){
                $message->to($email)->subject('Enquary from Broken Website');
            });
            return redirect()->back()->with('flash_message_success','Thanks for your enquary. We will get back to you soon!');
        }
        //Get All category and subcategory
        $categories = Category::with('categories')->where(['parent_id'=>0])->get();

        //Meta tags
        $meta_title = "Contact us E-shop Broken Website";
        $meta_description = "Contact us for any quary related to our products";
        $meta_keyword = "Contact us queries";

        return view('pages.contact')->with(compact('categories','meta_title','meta_description','meta_keyword'));
    }
}
