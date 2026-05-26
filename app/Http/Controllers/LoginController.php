<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('/home-v2');
        }else{
            return view('auth/login');
        }

    }

    public function actionlogin(Request $request)
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'activate' => 1,
            'role' => 'Administrator'
        ];
        $data2 = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'activate' => 1,
            'role' => 'Guest'
        ];
        $data3 = [
          'email' => $request->input('email'),
          'password' => $request->input('password'),
          'activate' => 1,
          'role' => 'Koordinator'
        ];

        $keyCheck = User::select('activate')
                    ->where(['email' => $request->input('email'), 'activate' => 1])
                    ->exists();
        // echo $keyCheck;
        if (Auth::Attempt($data))
        {
            $user = auth()->user();
            session()->put('parameter', $user->sub_divisi);
            return redirect('/home-v2');
        }
        elseif(Auth::Attempt($data2))
        {
            $user = auth()->user();
            session()->put('parameter', $user->sub_divisi);
            return redirect('/home-v2');
        }
        elseif(Auth::Attempt($data3))
        {
            $user = auth()->user();
            session()->put('parameter', $user->sub_divisi);
            return redirect('/home-v2');
        }
        elseif ($keyCheck != 1)
        {
            Session::flash('error', 'Email Salah, Silahkan periksa kotak masuk email anda, dan verifikasi email anda terlebih dahulu');
            return redirect('/');
        }
        else
        {
            Session::flash('error', 'Email atau Password Salah');
            return redirect('/');
        }
        dd($data);die;
    }

    public function actionlogout()
    {
        Auth::logout();
        return redirect('/');
    }
}
