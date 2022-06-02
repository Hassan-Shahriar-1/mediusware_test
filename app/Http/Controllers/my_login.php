<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class my_login extends Controller
{

    public function page(){
        return view('auth.login');
    }
    public function login(Request $request){

        $this->validate($request, [
            'email'=> 'required|max:255|email',
            
        ]);
        $credentials = [
            'email' => $request['email'],
            'password' => $request['password'],
        ];
        //dd($credentials);
//dd(Hash::make($request->password));
       $check_user=User::where('email',$request['email'])->where('password',Hash::check($request->password,'password'))->first();
       //dd($check_user);
       if($check_user==true){
           auth()->attempt($credentials);
            return redirect('/home');

       }else{
           return redirect()->to('/login');
       }


    }

    public function reset(){
        return view('auth.passwords.reset');
    }


    public function reset_password(Request $request){

        $this->validate($request,[
            'email'=> 'required|max:255|email',
            'password' => 'required|min:8'
        ]);

        $chking_user=User::where('email',$request['email'])->first();
        if($chking_user==true){
            if($request['password']==$request['password_confirmation']){
                $chking_user->password=bcrypt($request['password']);
                $chking_user->save();
                auth()->attempt(['email'=>$request['email'],'password'=>$request['password']]);
                return redirect('/home');
            }else{
                return redirect()->back()->withErrors([
                    'error' => 'Password Not matched',
                ]);
            }

        }else{
            return redirect()->back()->withErrors([
                'error' => 'Account Not found',
            ]);
        }


    }

    public function register(Request $request){

    }

    public function logout(){
        $user=Auth::user();
        if($user){
            auth()->logout();
            return redirect('/');
        }else{
            return redirect('/');
        }
    }
}
