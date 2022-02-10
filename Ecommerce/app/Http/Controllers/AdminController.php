<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{ 
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // Add user page
    public function addUser(){
        try{
            $roles = Role::all();
            return view('users.adduser',compact('roles'));
        }catch(\Illuminate\Database\QueryException $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }  
    }

    // show users
    public function showUser(){
        try{
            $users = User::paginate(10)->except(Auth::id());
            $roles = Role::all();
            return view('users.showuser',compact('users','roles'));
        }
        catch(\Exception $exception){
            return view('layouts.pagenotfound')->with('error', $exception->getMessage());
        }
    
    }

    // add user
    public function postAddUser(Request $req){
        
            $validateData = $req->validate([
                'firstname' => ['required', 'string', 'max:255'],
                'lastname' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'password_confirmation' => ['required'],
                'role_id' => ['required'],
                'status' => ['required']
            ]);
    
            if($validateData){
                try{
                    User::create([
                        'firstname' => $req->firstname,
                        'lastname' => $req->lastname,
                        'email' => $req->email,
                        'password' => Hash::make($req->password),
                        'role_id' => $req->role_id,
                        'status' => $req->status
                    ]);
    
                    $data = ['fname' => $req->firstname,'lname' => $req->lastname,'email' => $req->email,'password' => $req->password];
                    $user['to'] = $req->email;
    
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
    
                    return back()->with('success','User Registered Successfully !!');

                }catch(\Illuminate\Database\QueryException $e){
                    $errorCode = $e->errorInfo[1];
                        if($errorCode == 1062){
                            return view('category.duplicate');
                        }
                }
            }
            else{
                return back()->with('error','Fail to Register User');
            }
    }

    // display edit user 
    public function editUser($id){
        try{
            $user = User::where('id',$id)->firstorFail();
            $userrole = Role::where('role_id',$user->role_id)->firstorFail();
            $roles = Role::all();
            return view('users.edituser',compact('user','userrole','roles'));
        }catch(\Exception $exception){
            return view('layouts.pagenotfound')->with('error', $exception->getMessage());
        }
        
        
    }

    // update user (edited)
    public function postEditUser(Request $req){
        $validateData = $req->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$req->id],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
            'role_id' => ['required'],
            'status' => ['required']
        ]);
        if($validateData){
            try{
            User::where('id',$req->id)->update([
                'firstname' => $req->firstname,
                'lastname' => $req->lastname,
                'email' => $req->email,
                'password' => Hash::make($req->password),
                'role_id' => $req->role_id,
                'status' => $req->status
            ]);
            return back()->with('success','User Updated Successfully !!');
            }catch(\Illuminate\Database\QueryException $e){
                return view('layouts.pagenotfound')->with('error', $e->getMessage());
            }
        }
    }

    // delete user
    public function deleteUser(Request $req){
        try{
            User::where('id',$req->aid)->delete();
            return back()->with('status',"User deleted successfully");
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
    }

    // user settings
    public function userSettings(){
        try{
            $settings = Settings::first();
            return view('settings.usersettings',compact('settings'));
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
    }

    public function updateSettings(Request $req){
        try{
            if($req->registration == 'on'){
                Settings::where('id',1)->update([
                    'registration' => 1
                ]);
            }
            else{
                Settings::where('id',1)->update([
                    'registration' => 0
                ]);
            }
    
            if($req->orders == 'on'){
                Settings::where('id',1)->update([
                    'order' => 1
                ]);
            }
            else{
                Settings::where('id',1)->update([
                    'order' => 0
                ]);
            }
    
            if($req->contact == 'on'){
                Settings::where('id',1)->update([
                    'contact' => 1
                ]);
            }
            else{
                Settings::where('id',1)->update([
                    'contact' => 0
                ]);
            }
    
            return back()->with('status',"Settings changed !!");
        }catch(\Exception $ex){
            return view('layouts.pagenotfound')->with('error', $ex->getMessage());
        }
        
    }
}
