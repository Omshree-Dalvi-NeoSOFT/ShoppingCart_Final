<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use SebastianBergmann\Environment\Console;

class BannerController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // show banner page
    public function addBanner(){
        try{
            return view('banner.addbanner');
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
    }

    // add banner
    public function postAddBanner(Request $req){
        $validateData = $req->validate([
            'heading' => ['required', 'string', 'max:255'],
            'description' => ['string', 'max:300'],
            'bannerimage' => ['required', 'mimes:jpg,png,jpeg,JPG,PNG,JPEG'],
            'bannertag' => ['mimes:jpg,png,jpeg,JPG,PNG,JPEG']
        ]);

        if ($validateData) {
            try{
            $file = $req->file('bannerimage');
            $fname = $file->getClientOriginalName();
            $filename = rand() . "-" . time() . "-" . $fname;
            $des = public_path('/images/banner');

            if($req->bannertag){
                $filetag = $req->file('bannertag');
                $fnametag = $filetag->getClientOriginalName();
                $filenametag = rand() . "-" . time() . "-" . $fnametag;
                $destag = public_path('/images/bannertags');
            }
            

            $banner = new Banner();
            $banner->heading = $req->heading;
            $banner->description = $req->bannerdescription;
            $banner->banner_image = $filename;
            if($req->bannertag){
                $banner->price_tag = $filenametag;
            }
            
            if ($file->move($des, $filename)) {
                if($req->bannertag){
                    $filetag->move($destag,$filenametag);
                }
                
                $banner->save();
                return back()->with('status', "Banner Added !");
            }
            }catch(\Exception $ex){
                return view('layouts.pagenotfound')->with('error', $ex->getMessage());
            }
        }
    }

    // show banner
    public function showBanners()
    {
        try {
            $banners = Banner::paginate(5)->all();
            return view('banner.showbanner', compact('banners'));
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
    }

    // edit banner page
    public function editBanner($id)
    {
        try {
            $banner = Banner::where('id', $id)->firstorFail();
            return view('banner.editbanner', compact('banner'));
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
        
    }

    // update banner
    public function postUpdateBanner(Request $req)
    {
        $validateData = $req->validate([
            'heading' => ['required', 'string', 'max:255'],
            'description' => ['string', 'max:300'],
            'bannerimage' => ['required', 'mimes:jpg,png,jpeg,JPG,PNG,JPEG'],
            'bannertag' => ['mimes:jpg,png,jpeg,JPG,PNG,JPEG']
        ]);

        if ($validateData) {
            try{
            $validateData = $req->validate([
                'heading' => ['required', 'string', 'max:255'],
                'description' => ['string', 'max:300'],
                'bannerimage' => ['mimes:jpg,png,jpeg,JPG,PNG,JPEG'],
                'bannertag' => ['mimes:jpg,png,jpeg,JPG,PNG,JPEG']
            ]);
            if ($validateData) {
                $banner = Banner::findorFail($req->id);
                
                if($req->hasFile('bannerimage')){
                    
                    $file = $req->file('bannerimage');
                    $fname = $file->getClientOriginalName();
                    $destination=public_path('images/banner/'.$banner->banner_image);
                    if(File::exists($destination)){
                        unlink($destination);
                    } 
                    $filename = rand() . "-" . time() . "-" . $fname;
                    $des = public_path('/images/banner');
                    $file->move($des, $filename);
                    $banner->banner_image = $filename;
                }
    
                if($req->hasFile('bannertag')){
                    $filetag = $req->file('bannertag');
                    $fnametag = $filetag->getClientOriginalName();
                    if($banner->price_tag){
                        $destag = public_path('/images/bannertags/'.$banner->price_tag);
                        if(File::exists($destag)){
                            unlink($destag);
                        }
                        $filenametag = rand() . "-" . time() . "-" . $fnametag;
                        $destag = public_path('images/bannertags');
                        $filetag->move($destag,$filenametag);
                        $banner->price_tag = $filenametag;
                    }
                    else{
                        $filenametag = rand() . "-" . time() . "-" . $fnametag;
                    $destag = public_path('images/bannertags');
                    $filetag->move($destag,$filenametag);
                    $banner->price_tag = $filenametag;
                    }
                    
                }
                $banner->heading=$req->heading;
                $banner->description=$req->bannerdescription;
                $banner->save();
            }
            return redirect('/showbanner')->with('status',"Updates Successfully !");

            }catch(\Exception $ex){
                return view('layouts.pagenotfound')->with('error', $ex->getMessage());
            }
        }
        
    }

    // delete banner
    public function deleteBanner(Request $req){
        try{
            $banner = Banner::where('id',$req->aid)->firstorFail();
            $destination = public_path('images/banner/'.$banner->banner_image);

            if(File::exists($destination)){
                unlink($destination);
                $banner->delete();
            }
            return back()->with('status',"Banner Removed");
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
    }
}
