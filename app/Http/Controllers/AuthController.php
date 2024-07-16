<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        // $hashedPassword = Hash::make($request->password);
        if(Auth::guard('mahasiswa')->attempt(['nim'=>$request->nim,'password'=>$request->password])){
            // echo "berhasil login";
            return redirect('/dashboard');
        }else{
           
             return redirect('/')->with(['warning'=>'Nik / Password salah']);
        }
    }

    public function logout(Request $request){
        if(Auth::guard('mahasiswa')->check()){
            Auth::guard('mahasiswa')->logout();
            return redirect('/');
        }

       
    }

    public function loginadmin(Request $request){

        if(Auth::guard('user')->attempt(['email'=>$request->email,'password'=>$request->password])){
            // echo "berhasil login";
            return redirect('/admin/admindashboard');
        }else{
           
             return redirect('/admin')->with(['warnmes'=>'Email / Password salah']);
        }
    }

    public function adminlogout(Request $request){
        if(Auth::guard('user')->check()){
            Auth::guard('user')->logout();
            return redirect('/admin');
        }
    }
}
