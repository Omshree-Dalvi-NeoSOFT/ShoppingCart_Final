<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // display contact page
    public function contactUs(){
        try{
            $contacts = ContactUs::paginate(5)->all();
            return view('contact.showcontact',compact('contacts'));
        }
        catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
    }

    // contact us 
    public function replyContact($id){
        try{
            $contact = ContactUs::where('id',$id)->firstorFail();
            return view('contact.replycontact',compact('contact'));
        }
        catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
    }

    // reply
    public function postreplyContact(Request $req){
        try{
            $validate = $req->validate([
                'subject' => 'required',
                'mailbody' => 'required'
            ]);
            if($validate){
                $data = ['msg' => $req->mailbody,'subjt' => $req->subject];
                $user['to'] = $req->to;
                Mail::send('email.contactreply',$data,function($message) use ($user){
                    $message->to($user['to']);
                    $message->subject("Thank you for your time !");
                });
                ContactUs::where('id',$req->id)->update([
                    'status' => 1
                ]);
    
                return redirect('/contactus');
            }
        }catch(\Illuminate\Database\QueryException $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
    }
}
