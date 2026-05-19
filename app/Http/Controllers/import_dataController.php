<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportCandidate;
use App\Models\tr_import_data;
use Session;
use DB;
class import_dataController extends Controller
{
  public function import_data(Request $request)
  {
    // $kandidat = tr_import_data::all();
    $kandidat = DB::connection('mysql')->select("
      SELECT
      *
      FROM tr_import_data
      where shortlisted is null
      ");


    return view('hrd.import_data', compact('kandidat'));
  }

  public function import(Request $request)
    {

          $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
          ]);

          // menangkap file excel
          $file = $request->file('file');

          // membuat nama file unik
          $nama_file = rand().$file->getClientOriginalName();

          // upload ke folder file_siswa di dalam folder public
          $file->move('file_kandidat',$nama_file);
          // dd($file);die;
          // import data
          Excel::import(new ImportCandidate, public_path('/file_kandidat/'.$nama_file));

          // notifikasi dengan session
          // Session::flash('sukses','Data Kandidat Berhasil Diimport!');

          $kandidat = DB::connection('mysql')->select("
          SELECT
          *
          FROM tr_import_data
          where shortlisted is null
          ");

          // dd($kandidat);die;
          return view('hrd.import_data', compact('kandidat'));
          }
}
