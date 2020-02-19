<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\category;

class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //Add Category Controller
    public function addCategory(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }
            if(empty($data['meta_title'])){
                $data['meta_title'] = "";
            }
            if(empty($data['meta_description'])){
                $data['meta_description'] = "";
            }
            if(empty($data['meta_keyourds'])){
                $data['meta_keyourds'] = "";
            }
            $category = new Category;
            $category->category_name = $data['category_name'];
            $category->parent_id = $data['parent_id'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keyourds = $data['meta_keyourds'];
            $category->status = $status;
            $category->save();
            return redirect('/admin-panel/view-category')->with('flash_message_success','category added succesfully');
        }

        
        
        /* $levels = category::where(['parent_id'=>0])->get();
        return view('admin.category.add-category')->with(compact('levels')); */
        $levels = Category::where(['parent_id'=>0])->get();
        return view('admin.category.add-category')->with(compact('levels'));
    }

    //View Category Controller
    public function viewCategory(){
        $categories = category::get();
        return view('admin.category.view-category')->with(compact('categories'));
    }

    //Edit Category Controller
    public function editCategory(Request $request, $id=null ){
        
        if($request->isMethod('post')){
            $data=$request->all();

            if(empty($data['status'])){
                $status = 0;
            }else{
                $status = 1;
            }
            if(empty($data['meta_title'])){
                $data['meta_title'] = "";
            }
            if(empty($data['meta_description'])){
                $data['meta_description'] = "";
            }
            if(empty($data['meta_keyourds'])){
                $data['meta_keyourds'] = "";
            }
            category::where(['id'=>$id])->update(['category_name'=>$data['category_name'],'description'=>$data['description'],'url'=>$data['url'],'meta_title'=>$data['meta_title'],'meta_description'=>$data['meta_description'],'meta_keyourds'=>$data['meta_keyourds'],'status'=>$status]);
            return redirect('/admin-panel/view-category')->with('flash_message_success','category updated succesfully');
        }

        $categoryDetails = Category::where(['id'=>$id])->first();
        $levels = Category::where(['parent_id'=>0])->get();
        return view('admin.category.edit-category')->with(compact('categoryDetails','levels'));
    }

    //Delete Category Controller
    public function deleteCategory($id = null){
        Category::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_success', 'Category has been deleted successfully');
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
