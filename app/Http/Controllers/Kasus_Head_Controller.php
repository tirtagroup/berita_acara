<?php

namespace App\Http\Controllers;
use App\Models\Ms_BA_Kasus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class Kasus_Head_Controller extends Controller
{
  public function index()
  {
     $user = auth()->user();
     $data = Ms_BA_Kasus::all();

     if( $user->ms_divisi == 'HR')
     {
      return view ('berita_acara.ms_head_kasus', compact('data', 'user') );
     }
     else if( $user->ms_divisi == 'BOD')
     {
      return view ('berita_acara.ms_head_kasus', compact('data', 'user') );
     }
     else if( $user->ms_divisi == 'General Manager')
     {
      return view ('berita_acara.ms_head_kasus', compact('data', 'user') );
     }
    else
      {
        Session::flash('warning', 'Anda tidak memiliki izin untuk mengakses halaman ini, (Hanya HR yang bisa menambahkan kasus atau detail kasus).');

        return view('berita_acara.error');
      }

  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      $ms_head_kasus  =   Ms_BA_Kasus::updateOrCreate(
                  [
                      'id' => $request->id
                  ],
                  [
                      'ms_type' => $request->ms_type,
                      'ms_jenis_ba_code' => $request->ms_jenis_ba_code,
                      'description' => $request->description,
                      'rec_usercreated' => $request->rec_usercreated,
                      'rec_status' => "1",
                  ]);
      return response()->json(['success' => true]);
  }
  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request)
  {

      $where = array('id' => $request->id);
      $ms_head_kasus  = Ms_BA_Kasus::where($where)->first();

      return response()->json($ms_head_kasus);
  }
  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
      $ms_head_kasus = Ms_BA_Kasus::where('id',$request->id)->delete();

      return response()->json(['success' => true]);
  }
}
