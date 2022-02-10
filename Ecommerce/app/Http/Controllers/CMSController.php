<?php

namespace App\Http\Controllers;

use App\Models\CMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;



class CMSController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // add cms page
    public function addCMS(){
        try{
            return view('cms.addcms');
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
    }
  
    // add cms page
    public function postAddCMS(Request $req){
        try{
            $validateData = $req->validate([
                'heading' => ['required', 'string', 'max:255'],
                'cmsdescription' => ['max:1000'],
                'cmsimage' => ['required', 'mimes:jpg,png,jpeg,JPG,PNG,JPEG']
            ]);
    
            if ($validateData) {
                $file = $req->file('cmsimage');
                $fname = $file->getClientOriginalName();
                $filename = rand() . "-" . time() . "-" . $fname;
                $des = public_path('/images/cms');          
    
                $cms = new CMS();
                $cms->title = $req->heading;
                $cms->description = $req->cmsdescription;
                $cms->image = $filename;
    
                if ($file->move($des, $filename)) {                
                    $cms->save();
                    // alert()->success('CMS Added')->persistent('Close')->autoclose(145);
                    return back()->with('status',"CMS Added !");
                }
            }
        }catch(\Illuminate\Database\QueryException $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
        
    }

    // display cms
    public function displayCMS(){
        try{
            $cms = CMS::all();
            return view('cms.displaycms',compact('cms'));
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
        
    }

    // delete cms
    public function deleteCMS(Request $req){
        try{
            $cms = CMS::where('id',$req->aid)->firstorFail();
            $destination = public_path('images/cms/'.$cms->image);

            if(File::exists($destination)){
                unlink($destination);
                $cms->delete();
            }
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
        
        return back();
    }

    // edit cms
    public function editCMS($id){
        try{
            $cms = CMS::where('id',$id)->firstorFail();
            return view('cms.editcms',compact('cms'));
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
    }

    // update cms
    public function postEditCMS(Request $req){
        try{
            $validateData = $req->validate([
                'heading' => ['required', 'string', 'max:255'],
                'cmsdescription' => ['string', 'max:1000'],
                'cmsimage' => ['mimes:jpg,png,jpeg,JPG,PNG,JPEG'],
            ]);
            if ($validateData) {
                $banner = CMS::findorFail($req->id);
                
                if($req->hasFile('cmsimage')){
                    
                    $file = $req->file('cmsimage');
                    $fname = $file->getClientOriginalName();
                    $destination=public_path('images/cms/'.$banner->image);
    
                    if(File::exists($destination)){
                        unlink($destination);
                    }
                     
                    $filename = rand() . "-" . time() . "-" . $fname;
                    $des = public_path('/images/cms');
                    $file->move($des, $filename);
                    $banner->image = $filename;
                }
                $banner->title=$req->heading;
                $banner->description=$req->cmsdescription;
                $banner->save();
            }
            return back()->with('status',"Updates Successfully !");
        }catch(\Illuminate\Database\QueryException $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
    }
}
