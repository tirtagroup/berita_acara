<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Ms_Company;
use App\Models\MsBranch;
use Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\MailSend;

class RegisterController extends Controller
{
    public function register()
    {
        $ms_company= Ms_Company::all();
        $ms_branch = MsBranch::all();
        // dd($ms_branch);die;
        return view('auth/register', compact('ms_company','ms_branch'));
    }

    public function actionregister(Request $request)
    {
        $str = Str::random(100);

        $keyCheck = User::select('email')
                    ->where('email', $request->email)
                    ->exists();
        // echo $keyCheck;
        if($keyCheck)
        {
            Session::flash('error', 'Email sudah terdaftar!!');
            return redirect('register');
        }else{
            $user = User::create([
                'email' => $request->email,
                'name' => $request->name,
                'username' => $request->username,
                'ms_divisi' => $request->ms_divisi,
                'sub_divisi' => $request->sub_divisi,
                'ms_company' => $request->ms_company,
                'ms_branch' => $request->ms_branch,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'verify_key' => $str


            ]);
            $details = [
                'name' => $request->name,
                'username' => $request->username,
                'ms_divisi' => $request->ms_divisi,
                'sub_divisi' => $request->sub_divisi,
                'ms_company' => $request->ms_company,
                'ms_branch' => $request->ms_branch,
                'role' => $request->role,
                'website' => 'testing.tirta-group.com',
                'datetime' => date('Y-m-d H:i:s'),
                'url' => request()->getHttpHost().'/register/verify/'.$str
            ];


            Mail::to($request->email)->send(new MailSend($details));

            Session::flash('message', 'Link verifikasi telah dikirim ke Email Anda. Silahkan Cek Email Anda untuk Mengaktifkan Akun');
            return redirect('register');
        }
    }

    public function verify($verify_key)
    {
        $keyCheck = User::select('verify_key')
                    ->where('verify_key', $verify_key)
                    ->exists();

        if ($keyCheck) {
            $user = User::where('verify_key', $verify_key)
            ->update([
                'activate' => 1
            ]);
            Session::flash('message', 'Verifikasi Berhasil. Akun Anda sudah aktif.');
            return redirect('/');
        }else{
            return "Key tidak valid!";
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
