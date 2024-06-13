<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function proseslogin(Request $request){
        // $password = 1234;
        // echo Hash::make($password);
        if(Auth::guard('siswa')->attempt(['nisn'=>$request->nisn, 'password'=>$request->password])){
            return redirect('/dashboard');
        }else{
            return redirect('/')->with(['error'=> 'NISN atau Password Salah']);
        }
    }

    public function proseslogout(){
        if(Auth::guard('siswa')->check()){
            Auth::guard('siswa')->logout();
            return redirect('/');
        }
    }

    public function proseslogoutadmin(){
        if(Auth::guard('user')->check()){
            Auth::guard('user')->logout();
            return redirect('/dosman');
        }
    }

    public function prosesloginadmin(Request $request){
        // if(Auth::guard('user')->attempt(['email'=>$request->email, 'password'=>$request->password])){
        //     return redirect('/dosman/dashboardadmin');
        // }else{
        //     return redirect('/dosman')->with(['error'=> 'Email Admin atau Password Salah']);
        // }

        if(Auth::guard('user')->attempt(['name'=>$request->name, 'password'=>$request->password])){
            return redirect('/dosman/dashboardadmin');
        }else{
            return redirect('/dosman')->with(['error'=> 'Email Admin atau Password Salah']);
        }
    }
}
