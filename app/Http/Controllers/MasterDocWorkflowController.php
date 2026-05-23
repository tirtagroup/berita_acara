<?php

namespace App\Http\Controllers;

use App\Models\DocWorkflow;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Admin CRUD untuk ms_doc_workflow (in-app help/tutorial docs).
 */
class MasterDocWorkflowController extends Controller
{
    public function index(Request $request)
    {
        $modul    = $request->input('modul');
        $kategori = $request->input('kategori');
        $q        = trim($request->input('q', ''));

        $query = DocWorkflow::query()->orderBy('modul')->orderBy('kategori')->orderBy('urutan');
        if ($modul)    $query->where('modul', $modul);
        if ($kategori) $query->where('kategori', $kategori);
        if ($q !== '') {
            $query->where(function ($w) use ($q) {
                $w->where('judul', 'like', "%{$q}%")
                  ->orWhere('kode', 'like', "%{$q}%");
            });
        }
        $docs = $query->get();

        return view('master.doc_workflow.index', compact('docs', 'modul', 'kategori', 'q'));
    }

    public function create()
    {
        return view('master.doc_workflow.form', ['mode' => 'create', 'doc' => null]);
    }

    public function store(Request $request)
    {
        $data = $this->validateDoc($request);
        $data['created_by'] = auth()->user()->username ?? 'system';
        $data['updated_by'] = $data['created_by'];
        DocWorkflow::create($data);
        return redirect()->route('master.doc-workflow.index')->with('success', 'Dokumentasi dibuat.');
    }

    public function edit($id)
    {
        $doc = DocWorkflow::findOrFail($id);
        return view('master.doc_workflow.form', ['mode' => 'edit', 'doc' => $doc]);
    }

    public function update(Request $request, $id)
    {
        $doc = DocWorkflow::findOrFail($id);
        $data = $this->validateDoc($request, $id);
        $data['updated_by'] = auth()->user()->username ?? 'system';
        $doc->update($data);
        return redirect()->route('master.doc-workflow.index')->with('success', 'Dokumentasi diupdate.');
    }

    public function toggle($id)
    {
        $doc = DocWorkflow::findOrFail($id);
        $doc->update(['active' => !$doc->active, 'updated_by' => auth()->user()->username ?? 'system']);
        return back()->with('success', "Dokumentasi '{$doc->judul}' " . ($doc->active ? 'aktif' : 'nonaktif') . '.');
    }

    public function destroy($id)
    {
        $doc = DocWorkflow::findOrFail($id);
        $doc->delete();
        return back()->with('success', 'Dokumentasi dihapus.');
    }

    protected function validateDoc(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'kode'        => ['required', 'string', 'max:50', 'regex:/^[a-z0-9_-]+$/',
                              Rule::unique('ms_doc_workflow', 'kode')->ignore($id)],
            'modul'       => ['required', Rule::in(DocWorkflow::MODULS)],
            'kategori'    => ['required', Rule::in(DocWorkflow::KATEGORIS)],
            'judul'       => ['required', 'string', 'max:200'],
            'ringkasan'   => ['nullable', 'string', 'max:500'],
            'konten'      => ['required', 'string'],
            'target_role' => ['nullable', Rule::in(DocWorkflow::TARGET_ROLES)],
            'urutan'      => ['nullable', 'integer', 'min:0'],
            'icon'        => ['nullable', 'string', 'max:50'],
            'active'      => ['nullable', 'boolean'],
        ]) + ['active' => $request->boolean('active', true)];
    }
}
