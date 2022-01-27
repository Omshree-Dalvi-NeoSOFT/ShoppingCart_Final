<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // display coupon
    public function showCoupons(){
        $coupons = Coupon::all();
        return view('coupon.showcoupon',compact('coupons'));
    }

    // add coupon page
    public function addCoupon(){
        return view('coupon.addcoupon');
    }

    // add coupon
    public function addPostCoupon(Request $req){
        $validate = $req->validate([
            'code'=>'required|unique:coupons',
            'type'=>'required',
            'value'=>'required|numeric',
            'cart_value'=>'required|numeric',
            'couponstatus' => 'required'
        ]);
        if($validate){
            $coupon = new Coupon();
            $coupon->code=$req->code;
            $coupon->type=$req->type;
            $coupon->value=$req->value;
            $coupon->cart_value=$req->cart_value;
            $coupon->couponstatus=$req->couponstatus;
            if($coupon->save()){
                return back()->withSuccess('Coupon added successfully');            }
        }
    }

    // edit coupon
    public function editCoupon($id){
        try{
            $coupon = Coupon::find($id);
            return view('coupon.editcoupon',compact('coupon'));
        }catch(\Exception $e){
            return view('layouts.pagenotfound');
        }
        
    }

    // edit coupon
    public function editPostCoupon(Request $req){
        $validate = $req->validate([
            'code'=>'required',
            'type'=>'required',
            'value'=>'required|numeric',
            'cart_value'=>'required|numeric',
            'couponstatus' =>'required'
        ]);
        if($validate){
            $coupon = Coupon::find($req->id);
            $coupon->code=$req->code;
            $coupon->type=$req->type;
            $coupon->value=$req->value;
            $coupon->cart_value=$req->cart_value;
            $coupon->couponstatus=$req->couponstatus;
            if($coupon->save()){
                return back()->with('status','Coupon updated successfully');
            }
        }
    }

    // delete coupon
    public function deleteCoupon(Request $req){
        $coupon = Coupon::find($req->cid);
        if($coupon->delete()){
            return back()->withSuccess('Coupon deleted successfully');
        }
        else
        {
            return back()->withFail('Error while deleting');
        }
    }
}
