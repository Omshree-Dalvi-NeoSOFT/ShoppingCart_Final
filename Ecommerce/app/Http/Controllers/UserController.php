<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserApiResource;
use App\Mail\AdminRegister;
use App\Mail\OrderMail;
use App\Models\Banner;
use App\Models\Category;
use App\Models\CMS;
use App\Models\ContactUs;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\ProductAttributesAssoc;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\UserDetails;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\RegisterMail;
use App\Models\NewaLetter;
use App\Models\Settings;

class UserController extends Controller
{
    // api constructor 
    public function __constract(){
        $this->middleware('auth:api',['except'=>['login','register']]);
    }

    // display all users
    public function Index(){
        $data = User::all();
        return response()->json($data);
    }

    // login user
    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>'required',
            'password'=>'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        else {
            if(!$token = auth()->attempt($validator->validated())){
               return response()->json(['err'=>"Unauthorized User !"],401);
            }
            $user = User::where('email',$request->email)->first();
            return response()->json([
                'access_token'=>$token,
                'token_type'=>'bearer',
                'expires_in'=>auth()->guard('api')->factory()->getTTL()*60,
                'user'=>$user
            ]);
        }
    }

    // register user
    public function registerUser(Request $request){
            User::create([
                'firstname' => $request->ufname,
                'lastname' => $request->ulname,
                'email' => $request->uemail,
                'password' => Hash::make($request->upassword),
                'role_id' => 5,
                'status' => 1
            ]);
            $data = ['fname' => $request->ufname,'lname' => $request->ulname,'email' => $request->uemail,'password' => $request->upassword];
            $user['to'] = $request->uemail;
            Mail::send('email.register',$data,function($message) use ($user){
                $message->to($user['to']);
                $message->subject('Registration Confirmed !');
            });

            $settings = Settings::first();
            if($settings->registration == 1){
                Mail::send('email.adminregister',$data,function($message) use ($user){
                    $message->to('omshreedalvi98@gmail.com');
                    $message->subject('New User Registered !');
                });
            }
            return response()->json(['msg'=>"User Registered Successfully !"]);
        
    }

    // fetch contact us 
    public function contactUs(Request $request){
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            'subject'=>'required',
            'message'=>'required|min:5|max:500'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        else{
            $contact = new ContactUs();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->subject = $request->subject;
            $contact->message = $request->message;
            $contact->save();
            return response()->json(['msg'=>"we will contact you"]);
        }
    }

    // display productdetails
    public function productDetails(){
        $product = Product::all();
        $productImage = ProductImage::all();
        $productAttributes = ProductAttributesAssoc::all();
        $proddetails = ["Product"=>$product,"ProductIimage"=>$productImage,"ProductAttr"=>$productAttributes];
        return response()->json($proddetails);
    }

    // fetch product images
    public function productImages(){
        $productImage = ProductImage::all();
        return response(['image'=>UserApiResource::collection($productImage)]);
    }

    // get bnner details
    public function bannerDetails(){
        $banner = Banner::all();
        return response(['banner'=>UserApiResource::collection($banner)]);
    }

    // get all category 
    public function Category(){
        $category = Category::all();
        return response(['category'=>UserApiResource::collection($category)]);
    }

    // get all sub category
    public function subCategory(){
        $subcategory = SubCategory::all();
        return response(['subcategory'=>UserApiResource::collection($subcategory)]);
    }

    // get all products, subcategory wise
    public function subCategoryProducts($id){
        $product = Product::where('subcat_id',$id)->get();
        $productImage = ProductImage::all();
        $productAttributes = ProductAttributesAssoc::all();
        $proddetails = ["Product"=>$product,"ProductIimage"=>$productImage,"ProductAttr"=>$productAttributes];

        return response()->json($proddetails);
    }

    // get current product details
    public function currentProductsDetails($id){
        $product = Product::with('Images','prodAttr')->find($id);
        return response()->json($product);

    }

    // get user profile details
    public function Profile($user){
        $profile = User::where('email',$user)->first();
        return response()->json(['profile'=>$profile]);

    }

    // update user profile
    public function updateProfile(Request $request){
            $user = User::where('id',$request->id)->update([
                'firstname' => $request->first_name,
                'lastname' => $request->last_name,
                'email' => $request->email
            ]);
            return response()->json([
                'message'=>"profile updated successfully",
                'updatedprofile'=>$user
            ]);
         //return response()->json(['status'=>1,'updatedprofile'=>$user]);
    }

    // change user password
    public function changePassword(Request $request){
        $validator = Validator::make($request->all(),[
            'old_password'=>'required|min:6',
            'new_password'=>'required|min:6',
            'confirm_password'=>'required|min:6|same:new_password',

        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        else {
            $user=User::where('email',$request->email)->first();

            if(Hash::check($request->old_password,$user->password)){
               $user->update([
                   'password'=>Hash::make($request->new_password)
               ]);

            //    send mail
               $data = ['fname' => $user->firstname,'lname' => $user->lastname,'email' => $user->email,'password' => $request->new_password];
                $user['to'] = $request->email;
                Mail::send('email.updatepassword',$data,function($message) use ($user){
                    $message->to($user['to']);
                    $message->subject('Password Changed !');
                });

               return response()->json([
                'message'=>"password successfully updated",
                'status'=>1
                ],200);
            }
           else{
                return response()->json([
                    'message'=>"old password does not match",
                ],400);
           }
        }
        return response()->json([
            'message'=>"password successfully updated",
            'status'=>1
        ]);
    }

    // display cms details
    public function CMSDetails(){
        $data = CMS::all();
        return response(['services'=>UserApiResource::collection($data)]);
    }

    // fetch checkout data
    public function Checkout(Request $req){
        $uemail = $req->uemail;
        $user = User::where('email',$uemail)->first();

        $userdetails = new UserDetails();
        $userdetails->user_id = $user->id;
        $userdetails->email = $req->email;
        $userdetails->firstname = $req->firstname;
        $userdetails->middlename = $req->middlename;
        $userdetails->lastname = $req->lastname;
        $userdetails->address1 = $req->address1;
        $userdetails->address2 = $req->address2;
        $userdetails->zip = $req->zip;
        $userdetails->phone = $req->phone;
        $userdetails->mobilephone =$req->mobilephone;
        $userdetails->shipping = $req->shipping;
        $userdetails->save();

        $userdetail = UserDetails::latest()->first();
        
        $orders = $req->cart;
        foreach($orders as $ord){
            $order = new Order();
            $order->userdetail_id = $userdetail->id;
            $order->product_id = $ord['product_id'];
            $order->save();
        }

        $orderdetail = new OrderDetails();
        $orderdetail->userdetail_id = $userdetail->id;
        $orderdetail->grandtotal = $req->grandtotal;
        $orderdetail->finalTotal = $req->finalTotal;
        $orderdetail->status="Pending";
        
        if($req->coupon){
            $coupon = $req->coupon;
        foreach($coupon as $c){
            $orderdetail->coupon_id =$c['id'];
        }
        }
        $orderdetail->save();
        
        // mail of order
        $data = ['fname' => $req->firstname,'lname' => $req->lastname,'email' => $req->uemail,'password' => $req->upassword, 'address1' => $req->address1, 'zip' => $req->zip,'phone' => $req->phone,'grandtotal' => $req->grandtotal,'finalTotal' => $req->finalTotal];
        $user['to'] = $uemail;
        
        Mail::send('email.order',$data,function($message) use ($user){
            $message->to($user['to']);
            $message->subject('Order Placed !');
        });

        // copy to admin
        $settings = Settings::first();
        if($settings->order == 1){
            Mail::send('email.admincopy',$data,function($message) use ($user){
                $message->to('omshreedalvi98@gmail.com');
                $message->subject('New Order Placed !');
            });
        }
        
        return response()->json(['msg'=>"Order Placed Successfully !"]);
    }

    // add wish list
    public function addWish(Request $req){
        $user = User::where('email',$req->email)->first();
        $wish = new WishList();
        $wish->user_id = $user->id;
        $wish->product_id = $req->pid;
        $wish->save();
        return response()->json(['msg'=>"Product Added to Wish List !"]);
    }

    // get user wish list
    public function getWish($id){
        $wish = WishList::where('user_id',$id)->get();
        foreach($wish as $w){
            $prod = Product::where('id',$w['product_id'])->first();
            $product[] = $prod;
        }
        return response(['wish'=>UserApiResource::collection($product)]);
    }

    // delete user wishlist 
    public function delWish($id){
        WishList::where('product_id',$id)->delete();
        return response()->json(["msg"=>"Wish Deleted !!"]);
    }

    // display coupons
    public function Coupons(){
        $coupon = Coupon::where('couponstatus',1)->get();
        return response(['coupons'=>UserApiResource::collection($coupon)]);
    }

    // fetch user orders
    public function myOrder($id){
        $userdetail = UserDetails::where('user_id',$id)->get();
        $orderdetail = OrderDetails::all();
        $orders = Order::all();
        $orderdetails = ["userdetail"=>$userdetail,"orderdetail"=>$orderdetail,"orders"=>$orders];
        return response()->json($orderdetails);
    }

    // generate JWT Token
    protected function respondWithToken($token){
        return response()->json([
            'access_token'=>$token,
            'token_type'=>'bearer',
            'expires_in'=>auth()->guard('api')->factory()->getTTL()*60
        ]);
    }    

    // News Letter
    public function newsLetter(Request $request){
            $newsltr = new NewaLetter();
            $newsltr->email=$request->email;
            $newsltr->save();
            return response()->json(['msg'=>"we will contact you"]);
    }
}
