<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // add category page
    public function addCategory(){
        try{
            return view('category.addcategory');
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
        
    }

    // add category
    public function postAddCategory(Request $req){
        try{
            $validate = $req->validate([
                'catname' => ['required','string', 'max:255' , 'unique:categories,cat_name'],
                'catdescription' => ['max:300']
            ]);
    
            if($validate){
                $category = new Category();
                    $category->cat_name = $req->catname;
                    $category->cat_description = $req->catdescription;
                    $category->save();
                // try{
                // }catch(\Illuminate\Database\QueryException $e){
                //     $errorCode = $e->errorInfo[1];
                //         if($errorCode == 1062){
                //             return view('category.duplicate');
                //         }
                // }
                
                return back()->with('status',"Category added successfully");
            }
        }catch(\Illuminate\Database\QueryException $e){
            return view('layouts.pagenotfound')->with('error', $e->getMessage());
        }
        
    }

    // display category
    public function showCategory(){
        try{
            $category = Category::paginate(5)->all();
            return view('category.showcategory',compact('category'));   
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
    }

    // show category detail edit page
    public function editCategory($id){
        try {
            $category = Category::where('id', $id)->firstorFail();
            return view('category.editcategory', compact('category'));
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
        
    }

    // update category
    public function updateCategory(Request $req){
        $validate = $req->validate([
            'catname' => ['required','string', 'max:255','unique:categories,cat_name,'.$req->catid],
            'catdescription' => ['max:300']
        ]);
        if($validate){
            try{
                Category::where('id',$req->catid)->update([
                    'cat_name' => $req->catname,
                    'cat_description' => $req->catdescription
                ]);
            }catch(\Illuminate\Database\QueryException $e){
                $errorCode = $e->errorInfo[1];
                if($errorCode == 1062){
                    return view('category.duplicate');
                }
            }
            
            return back()->with('status',"Category Updated successfully");
        }
    }

    // delete category
    public function deleteCategory(Request $req){
        try{
            Category::where('id',$req->aid)->delete();
            return back();
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
    }
}
