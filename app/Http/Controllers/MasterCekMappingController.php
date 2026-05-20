<?php

namespace App\Http\Controllers;

use App\Models\BaKategori;
use App\Models\CekFlagMapping;
use Illuminate\Http\Request;

/**
 * Admin CRUD untuk ms_cek_flag_mapping —
 * pemetaan flag legacy Cek* → kategori v2.
 */
class MasterCekMappingController extends Controller
{
    public function index()
    {
        $mappings = CekFlagMapping::orderBy('legacy_flag')->get();
        $kategori = BaKategori::where('active', true)->orderBy('nama')->get(['id', 'kode', 'nama']);
        return view('master.cek_mapping.index', compact('mappings', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_kode' => ['required', 'string', 'exists:ms_ba_kategori,kode'],
            'opsi_kode'     => ['nullable', 'string', 'max:50'],
            'active'        => ['nullable', 'boolean'],
            'notes'         => ['nullable', 'string', 'max:1000'],
        ]);

        $row = CekFlagMapping::findOrFail($id);
        $row->update([
            'kategori_kode' => $request->kategori_kode,
            'opsi_kode'     => $request->opsi_kode,
            'active'        => $request->boolean('active'),
            'notes'         => $request->notes,
        ]);

        return back()->with('success', "Mapping {$row->legacy_flag} tersimpan.");
    }

    public function toggle($id)
    {
        $row = CekFlagMapping::findOrFail($id);
        $row->active = !$row->active;
        $row->save();
        return back()->with('success', "Mapping {$row->legacy_flag} " . ($row->active ? 'aktif' : 'nonaktif') . '.');
    }
}
