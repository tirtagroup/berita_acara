<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\mailsendresetpassword;
use DB;

class ForgotPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth/forgotpassword');
    }

    public function actionForgotPassword(request $request)
    {
        $str = Str::random(100);
        
        $user = User::where('email', $request->email)
            ->update([
                'verify_key' => $str
            ]);

        $keyCheck = User::select('email')
                    ->where('email', $request->email)
                    ->exists();
        
        $verifykeyData = DB::select("SELECT verify_key FROM users WHERE email = ? LIMIT 1", [$request->email]);

        
        // $email = $request->email;
     
        $verifykey = $verifykeyData[0]->verify_key; 
        if(!$verifykey)
        {   
            Session::flash('message', 'Email Masih belum terdaftar, Hubungi HR untuk Pendaftaran');
            return redirect('ForgotPassword');
        }else{
            $details = [
                'url' => request()->getHttpHost().'/forgotpassword/update/'.$verifykey
            ];

            Mail::to($request->email)->send(new mailsendresetpassword($details));
            
            Session::flash('status', 'Link reset password telah dikirim ke Email Anda. Silahkan Cek Email Anda untuk Mereset password');
            return redirect('ForgotPassword');
        }
    }

public function resetpassword(string $email)
{
    $verifykey = DB::select("select email from users where verify_key = ?", [$email]);

    if (count($verifykey) > 0) {
        // Konversi objek jadi array
        $user = json_decode(json_encode($verifykey[0]), true);
        return view('auth.resetpassword', ['email' => $user['email']]);
    } else {
        // Jika tidak ada data, bisa handle error atau redirect
        return redirect()->back()->withErrors(['email' => 'Email tidak ditemukan']);
    }
}


    public function updatepassword(request $request)
    {
        $password = DB::select("select password from users where email = '$request->email'");
        $password_enjson =  json_encode($password[0]);
        $password_dejson = json_decode($password_enjson, true);
        $password_hash = $password_dejson['password'];
        
        if($request->password != $request->password_confirmation)
        {
            $verifykey = DB::select("select verify_key from users where email = '$request->email'");
            $str_json =  json_encode($verifykey[0]);
            $strde_json = json_decode($str_json, true);
            Session::flash('error', 'Password yang anda konfirmasi masih belum sesuai dengan password baru anda!!');
            return redirect('forgotpassword/update/'.$strde_json['verify_key']);
        }
        else if(Hash::check($request->password, $password_hash))
        {
            $verifykey = DB::select("select verify_key from users where email = '$request->email'");
            $str_json =  json_encode($verifykey[0]);
            $strde_json = json_decode($str_json, true);
            Session::flash('error', 'Password yang anda masukkan sudah pernah digunakan pada akun tersebut sebelumnya!!');
            return redirect('forgotpassword/update/'.$strde_json['verify_key']);
        }
        else
        {
            $user = User::where('email', $request->email)
            ->update([
                'password' => Hash::make($request->password)
            ]);

            Session::flash('message', 'Password anda sudah diatur ulang');
            return redirect('/');
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
