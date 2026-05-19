<?php

namespace App\Http\Controllers;
use App\Models\Ms_BA_Category;
use Illuminate\Http\Request;

class Kategori_BA_Controller extends Controller
{
  public function index()
  {
     $user = auth()->user();
     $data = Ms_BA_Category::all();
      return view ('berita_acara.ms_kategori', compact('data', 'user') );
  }
  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      $ms_type  =   Ms_type_sp::updateOrCreate(
                  [
                      'id' => $request->id
                  ],
                  [
                      'type_code' => $request->type_code,
                      'description' => $request->description,
                      'user_created' => $request->user_created,
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
      $ms_type  = Ms_type_sp::where($where)->first();

      return response()->json($ms_type);
  }
  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Product  $product
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
      $ms_asset = Ms_type_sp::where('id',$request->id)->delete();

      return response()->json(['success' => true]);
  }
}
