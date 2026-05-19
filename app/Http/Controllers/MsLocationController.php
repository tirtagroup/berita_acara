<?php

namespace App\Http\Controllers;
use App\Models\MsLocation;
use Illuminate\Http\Request;
use DB;

class MsLocationController extends Controller
{
  public function index(Request $request)
  {
      $user = auth()->user();
      $data = MsLocation::all();

      $last_code = DB::connection('mysql')->select("
          SELECT
          lokasi_code
          FROM ms_lokasi
          order by created_at desc
          LIMIT 1
          ");
          $last_date = DB::connection('mysql')->select("
          SELECT
          created_at
          FROM ms_lokasi
          order by created_at desc
          LIMIT 1
          ");
          $todayDate = date('Y-m-d');
          foreach($last_code as $codes)
          { $kode = $codes->lokasi_code;}
          foreach($last_date as $datess)
          { $tanggal = $datess->created_at;}
          if( $tanggal == $todayDate)
              {
                  $code = $kode + 1;
              }
          else
              {
                  $code = 1;
              }
              $ambilkode=MsLocation::where($request->lokasi_code)->get();
              $nambah=count($ambilkode)+1;
              if ($nambah <10000)
              {
                  $lokasi_code='LOC'. '-'. date('Ydm').'-'."000".$nambah;
              }
          $lokasi = new MsLocation();
          $lokasi->lokasi_code = $lokasi_code;


      return view ('lokasi.master_lokasi', compact('user', 'data', 'lokasi') );
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $user = auth()->user();
    $user = $user->name;

      $ms_asset   =   MsLocation::updateOrCreate(
                  [
                      'id' => $request->id
                  ],
                  [
                      'lokasi_code' => $request->lokasi_code,
                      'lokasi_desc' => $request->lokasi_desc,
                      'lokasi_kota' => $request->lokasi_kota,
                      'no_hp' => $request->no_hp,
                      'area_code' => $request->area_code,
                      'company_code' =>$request->company_code,
                      'user_created' => $user
                  ]);
                  // dd($ms_asset);die;

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
      $ms_asset  = MsLocation::where($where)->first();

      return response()->json($ms_asset);
  }
  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
      $ms_asset = MsLocation::where('id',$request->id)->delete();

      return response()->json(['success' => true]);
  }
}
