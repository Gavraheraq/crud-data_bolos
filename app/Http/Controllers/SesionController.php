<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class SesionController extends Controller
{
    function index()
    {
        return view("sesi/index");

    }
    
    function login(Request $request)
    {
        Session::flash('email', $request->email);
        $request->validate([
            'email'=> 'required',
            'password'=> 'required',
        ], [
            'email.required'=>'Email wajib diisi',
            'password.required'=>'Password wajib diisi',
        ]);
        
        $infologin = [
            'email'=> $request->email,
            'password'=> $request->password,
            
        ];
        
        if(Auth::attempt($infologin)){
            return redirect('siswa')->with('success', 'Berhasil Login');
        }else{
            return redirect('sesi')->withErrors('Username dan Password yang dimasukkan tidak valid');
        }
    }

            function logout()
            {
                Auth::logout();
                return redirect('sesi')->with('success', 'Berhasil logout');
            }
            function register()
            {
                return view('sesi/register');
            }
            function create(Request $request)

            {
                Session::flash('email', $request->email);
                Session::flash('name', $request->name);
                $request->validate([
                    'name'=> 'required',
                    'email'=> 'required',
                    'password'=> 'required|min:3',
                ],[
                    'name.required'=>'Name wajib diisi',
                    'email.required'=>'Email wajib diisi',
                    'password.required'=>'Password wajib diisi',
                    'password.min'=>'Minimal 3 ',
                ]);

                $data = [
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>Hash::make($request->password),
                ];

                User::create($data);
                
                $infologin = [

                    'email'=> $request->email,
                    'password'=>$request->password,
                    
                ];
                
                if(Auth::attempt($infologin)){
                    return redirect('sesi')->with('success', 'Silahkan Login');
                }else{
                    return redirect('sesi')->withErrors('Username dan Password yang dimasukkan tidak valid');
                }
            }

}
