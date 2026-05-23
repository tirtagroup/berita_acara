<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Panel;
use App\Models\UserLevel;
use App\Models\UserLevelPanelAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Admin pages untuk manage permission system:
 *   - /master/user-level         → CRUD level
 *   - /master/panel              → CRUD panel
 *   - /master/permission-matrix  → matrix level × panel × action + scope
 */
class MasterPermissionController extends Controller
{
    // =========================================================
    // USER LEVEL CRUD
    // =========================================================
    public function levelIndex()
    {
        $items = UserLevel::orderBy('urutan')->withCount('users')->get();
        return view('master.permission.level_index', compact('items'));
    }

    public function levelCreate()
    {
        return view('master.permission.level_form', ['mode' => 'create', 'item' => null]);
    }

    public function levelStore(Request $request)
    {
        $data = $this->validateLevel($request);
        UserLevel::create($data);
        return redirect()->route('master.user-level.index')->with('success', 'Level dibuat.');
    }

    public function levelEdit($id)
    {
        $item = UserLevel::findOrFail($id);
        return view('master.permission.level_form', ['mode' => 'edit', 'item' => $item]);
    }

    public function levelUpdate(Request $request, $id)
    {
        $item = UserLevel::findOrFail($id);
        $item->update($this->validateLevel($request, $id));
        return redirect()->route('master.user-level.index')->with('success', 'Level diupdate.');
    }

    public function levelToggle($id)
    {
        $item = UserLevel::findOrFail($id);
        $item->update(['active' => !$item->active]);
        return back()->with('success', "Level '{$item->nama}' " . ($item->active ? 'aktif' : 'nonaktif') . '.');
    }

    protected function validateLevel(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'kode'      => ['required', 'string', 'max:50', Rule::unique('ms_user_level', 'kode')->ignore($id)],
            'nama'      => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
            'is_super'  => ['nullable', 'boolean'],
            'urutan'    => ['nullable', 'integer', 'min:0'],
            'active'    => ['nullable', 'boolean'],
        ]) + [
            'is_super' => $request->boolean('is_super'),
            'active'   => $request->boolean('active', true),
        ];
    }

    // =========================================================
    // PANEL CRUD
    // =========================================================
    public function panelIndex(Request $request)
    {
        $modul = $request->input('modul');
        $query = Panel::orderBy('modul')->orderBy('urutan');
        if ($modul) $query->where('modul', $modul);
        $items = $query->get();
        return view('master.permission.panel_index', compact('items', 'modul'));
    }

    public function panelCreate()
    {
        return view('master.permission.panel_form', ['mode' => 'create', 'item' => null]);
    }

    public function panelStore(Request $request)
    {
        $data = $this->validatePanel($request);
        Panel::create($data);
        return redirect()->route('master.panel.index')->with('success', 'Panel dibuat.');
    }

    public function panelEdit($id)
    {
        $item = Panel::findOrFail($id);
        return view('master.permission.panel_form', ['mode' => 'edit', 'item' => $item]);
    }

    public function panelUpdate(Request $request, $id)
    {
        $item = Panel::findOrFail($id);
        $item->update($this->validatePanel($request, $id));
        return redirect()->route('master.panel.index')->with('success', 'Panel diupdate.');
    }

    public function panelToggle($id)
    {
        $item = Panel::findOrFail($id);
        $item->update(['active' => !$item->active]);
        return back()->with('success', "Panel '{$item->nama}' " . ($item->active ? 'aktif' : 'nonaktif') . '.');
    }

    protected function validatePanel(Request $request, ?int $id = null): array
    {
        $data = $request->validate([
            'kode'             => ['required', 'string', 'max:50', Rule::unique('ms_panel', 'kode')->ignore($id)],
            'nama'             => ['required', 'string', 'max:100'],
            'parent_id'        => ['nullable', 'integer', 'exists:ms_panel,id'],
            'modul'            => ['required', Rule::in(Panel::MODULS)],
            'url'              => ['nullable', 'string', 'max:255'],
            'icon'             => ['nullable', 'string', 'max:50'],
            'urutan'           => ['nullable', 'integer', 'min:0'],
            'scopable'         => ['nullable', 'boolean'],
            'supported_scopes' => ['nullable', 'string'], // comma-separated
            'active'           => ['nullable', 'boolean'],
        ]);
        $data['scopable'] = $request->boolean('scopable');
        $data['active'] = $request->boolean('active', true);
        // Convert comma-separated to JSON array
        if (!empty($data['supported_scopes'])) {
            $data['supported_scopes'] = array_filter(array_map('trim', explode(',', $data['supported_scopes'])));
        } else {
            $data['supported_scopes'] = null;
        }
        return $data;
    }

    // =========================================================
    // PERMISSION MATRIX (level × panel × action + scope)
    // =========================================================
    public function matrix(Request $request)
    {
        $levelId = $request->input('level_id');
        $levels  = UserLevel::orderBy('urutan')->get();
        $panels  = Panel::where('active', true)->orderBy('modul')->orderBy('urutan')->get();
        $actions = Action::where('active', true)->orderBy('urutan')->get();

        // Default = level pertama bila tidak dipilih
        if (!$levelId && $levels->isNotEmpty()) {
            $levelId = $levels->first()->id;
        }

        // Existing permissions untuk level ini
        $perms = collect();
        if ($levelId) {
            $perms = UserLevelPanelAction::where('level_id', $levelId)
                ->get()
                ->keyBy(fn($p) => "{$p->panel_id}_{$p->action_id}");
        }

        $currentLevel = $levels->firstWhere('id', $levelId);

        return view('master.permission.matrix', compact(
            'levels', 'panels', 'actions', 'perms', 'levelId', 'currentLevel'
        ));
    }

    public function matrixUpdate(Request $request)
    {
        $request->validate([
            'level_id'  => ['required', 'integer', 'exists:ms_user_level,id'],
            'panel_id'  => ['required', 'integer', 'exists:ms_panel,id'],
            'action_id' => ['required', 'integer', 'exists:ms_action,id'],
            'scope'     => ['required', Rule::in(UserLevelPanelAction::SCOPES)],
        ]);

        $levelId  = $request->level_id;
        $panelId  = $request->panel_id;
        $actionId = $request->action_id;
        $scope    = $request->scope;

        if ($scope === 'none') {
            UserLevelPanelAction::where('level_id', $levelId)
                ->where('panel_id', $panelId)
                ->where('action_id', $actionId)
                ->delete();
            return response()->json(['ok' => true, 'action' => 'deleted']);
        }

        UserLevelPanelAction::updateOrCreate(
            ['level_id' => $levelId, 'panel_id' => $panelId, 'action_id' => $actionId],
            ['scope' => $scope, 'active' => true]
        );

        return response()->json(['ok' => true, 'action' => 'upserted', 'scope' => $scope]);
    }
}
