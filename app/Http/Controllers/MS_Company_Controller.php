<?php

namespace App\Http\Controllers;
use App\Models\Ms_Company;
use Illuminate\Http\Request;

class MS_Company_Controller extends Controller
{
    public function index()
    {
       $user = auth()->user();
       $data = Ms_Company::all();
        return view ('lokasi.company', compact('data', 'user') );
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ms_type  =   Ms_Company::updateOrCreate(
                    [
                        'id' => $request->id
                    ],
                    [
                        'company_code' => $request->company_code,
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
        $ms_type  = Ms_Company::where($where)->first();

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
        $ms_asset = Ms_Company::where('id',$request->id)->delete();

        return response()->json(['success' => true]);
    }
}
