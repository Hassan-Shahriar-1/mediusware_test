<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class my_login extends Controller
{
    public function login_page(){
        return view('auth.login');
    }

    public function login(Request $request){
        $login_check=User::where('email',$request['email'])->where('password',Hash::check($request['password'],'password'))->first();
        if($login_check){
            auth()->attempt(['email'=>$request['email'],'password'=>$request['password']]);
            return redirect('/home');

        }else{
            return back()->withErrors(['login'=>'Email Or password Wrong']);
        }
    }

    public function logout(){
        if(Auth::user()){
            auth()->logout();
            
        }
        return redirect('/');
    }

    public function password_change_page(){
        return view('auth.passwords.reset');
    }

    public function password_change(Request $request){
        if($request['password']==$request['password_confirmation']){
           $check_user= User::where('email',$request['email'])->first();

           if($check_user){
               $check_user->password=bcrypt($request['password']);
               $check_user->save();
               auth()->attempt(['email'=>$request['email'],'password'=>$request['password']]);
               return redirect('/home');

           }else{
               return back()->withErrors(['email'=>'No User Found']);
           }

        }else{
            return back()->withErrors(['password'=>'Password doesnt match']);
        }
    }
}
