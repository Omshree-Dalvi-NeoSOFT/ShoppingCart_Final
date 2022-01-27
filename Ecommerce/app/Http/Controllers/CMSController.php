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
        return view('cms.addcms');
    }
  
    // add cms page
    public function postAddCMS(Request $req){
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
    }

    // display cms
    public function displayCMS(){
        $cms = CMS::all();
        return view('cms.displaycms',compact('cms'));
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
        }catch(\Exception $exception){
            return view('layouts.pagenotfound');
        }
        
        return back();
    }

    // edit cms
    public function editCMS($id){
        try{
            $cms = CMS::where('id',$id)->firstorFail();
            return view('cms.editcms',compact('cms'));
        }catch(\Exception $e){
            return view('layouts.pagenotfound');
        } 
    }

    // update cms
    public function postEditCMS(Request $req){
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
    }
}
