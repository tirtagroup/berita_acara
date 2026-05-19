<?php

namespace App\Http\Controllers;

use App\Models\PicaKategori;
use App\Models\PicaPertanyaanMaster;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MasterPicaController extends Controller
{
    // ============================================================
    // KATEGORI PICA CRUD
    // ============================================================

    public function kategoriIndex()
    {
        $kategori = PicaKategori::orderBy('nama')->get();
        return view('master.pica.kategori.index', compact('kategori'));
    }

    public function kategoriCreate()
    {
        return view('master.pica.kategori.form', ['mode' => 'create', 'kategori' => null]);
    }

    public function kategoriStore(Request $request)
    {
        $data = $request->validate([
            'kode'      => ['required', 'string', 'max:50', 'regex:/^[A-Z0-9_]+$/', 'unique:ms_pica_kategori,kode'],
            'nama'      => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string', 'max:255'],
            'active'    => ['sometimes', 'boolean'],
        ]);
        PicaKategori::create($data + ['active' => $request->boolean('active', true)]);
        return redirect()->route('master.pica.kategori.index')->with('success', 'Kategori PICA dibuat.');
    }

    public function kategoriEdit($id)
    {
        $kategori = PicaKategori::findOrFail($id);
        return view('master.pica.kategori.form', ['mode' => 'edit', 'kategori' => $kategori]);
    }

    public function kategoriUpdate(Request $request, $id)
    {
        $kategori = PicaKategori::findOrFail($id);
        $data = $request->validate([
            'kode'      => ['required', 'string', 'max:50', 'regex:/^[A-Z0-9_]+$/', Rule::unique('ms_pica_kategori', 'kode')->ignore($id)],
            'nama'      => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string', 'max:255'],
            'active'    => ['sometimes', 'boolean'],
        ]);
        $kategori->update($data + ['active' => $request->boolean('active', true)]);
        return redirect()->route('master.pica.kategori.index')->with('success', 'Kategori PICA diupdate.');
    }

    public function kategoriToggle($id)
    {
        $kategori = PicaKategori::findOrFail($id);
        $kategori->update(['active' => !$kategori->active]);
        return back()->with('success', 'Status toggled.');
    }

    // ============================================================
    // PERTANYAAN MASTER CRUD
    // ============================================================

    public function pertanyaanIndex(Request $request)
    {
        $query = PicaPertanyaanMaster::query();
        if ($request->filled('scope'))  $query->where('scope', $request->scope);
        if ($request->filled('tipe'))   $query->where('tipe', $request->tipe);
        if ($request->filled('q'))      $query->where('pertanyaan', 'like', '%' . $request->q . '%');

        $items = $query->orderBy('scope')->orderBy('urutan')->orderBy('id')->get();
        return view('master.pica.pertanyaan.index', compact('items', 'request'));
    }

    public function pertanyaanCreate()
    {
        return view('master.pica.pertanyaan.form', ['mode' => 'create', 'item' => null]);
    }

    public function pertanyaanStore(Request $request)
    {
        $data = $request->validate([
            'kode'       => ['required', 'string', 'max:50', 'unique:ms_pica_pertanyaan_master,kode'],
            'pertanyaan' => ['required', 'string'],
            'tipe'       => ['required', Rule::in(PicaPertanyaanMaster::TIPES)],
            'scope'      => ['required', Rule::in(PicaPertanyaanMaster::SCOPES)],
            'urutan'     => ['nullable', 'integer', 'min:0'],
            'active'     => ['sometimes', 'boolean'],
        ]);
        PicaPertanyaanMaster::create($data + [
            'active' => $request->boolean('active', true),
            'urutan' => $request->input('urutan', 0),
        ]);
        return redirect()->route('master.pica.pertanyaan.index')->with('success', 'Pertanyaan master dibuat.');
    }

    public function pertanyaanEdit($id)
    {
        $item = PicaPertanyaanMaster::findOrFail($id);
        return view('master.pica.pertanyaan.form', ['mode' => 'edit', 'item' => $item]);
    }

    public function pertanyaanUpdate(Request $request, $id)
    {
        $item = PicaPertanyaanMaster::findOrFail($id);
        $data = $request->validate([
            'kode'       => ['required', 'string', 'max:50', Rule::unique('ms_pica_pertanyaan_master', 'kode')->ignore($id)],
            'pertanyaan' => ['required', 'string'],
            'tipe'       => ['required', Rule::in(PicaPertanyaanMaster::TIPES)],
            'scope'      => ['required', Rule::in(PicaPertanyaanMaster::SCOPES)],
            'urutan'     => ['nullable', 'integer', 'min:0'],
            'active'     => ['sometimes', 'boolean'],
        ]);
        $item->update($data + [
            'active' => $request->boolean('active', true),
            'urutan' => $request->input('urutan', 0),
        ]);
        return redirect()->route('master.pica.pertanyaan.index')->with('success', 'Pertanyaan master diupdate.');
    }

    public function pertanyaanToggle($id)
    {
        $item = PicaPertanyaanMaster::findOrFail($id);
        $item->update(['active' => !$item->active]);
        return back()->with('success', 'Status toggled.');
    }
}
