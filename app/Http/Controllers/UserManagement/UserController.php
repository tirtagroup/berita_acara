<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

/**
 * Admin page untuk manage user account: list, edit user-level, toggle active.
 *
 * URL prefix: /user-management/users
 * Permission anchor: `usermgmt.user.manage`
 *
 * Scope T1:
 *   - List users dengan filter (search, company, divisi, level, status active)
 *   - Edit user-level + activate flag
 *   - TIDAK include: reset password, edit email, change name — itu via self-service / IT
 *
 * Related:
 *   - User-level CRUD masih di MasterPermissionController (migrate ke namespace ini di Phase 2)
 *   - Permission matrix masih di MasterPermissionController
 */
class UserController extends Controller
{
    public function index(Request $request)
    {
        $search   = trim((string) $request->input('q', ''));
        $company  = $request->input('company');
        $divisi   = $request->input('divisi');
        $levelId  = $request->input('level_id');
        $aktif    = $request->input('aktif'); // '1', '0', or null = all

        $query = User::query()->with('userLevel');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name',     'LIKE', "%{$search}%")
                  ->orWhere('username','LIKE', "%{$search}%")
                  ->orWhere('email',   'LIKE', "%{$search}%");
            });
        }
        if ($company)    $query->where('ms_company', $company);
        if ($divisi)     $query->where('ms_divisi', $divisi);
        if ($levelId === 'null') {
            $query->whereNull('level_id');
        } elseif ($levelId) {
            $query->where('level_id', $levelId);
        }
        if ($aktif === '1' || $aktif === '0') {
            $query->where('activate', $aktif);
        }

        $users = $query->orderBy('name')->paginate(50)->withQueryString();

        // Filter dropdown options (distinct values from data)
        $companies = User::query()
            ->select('ms_company')
            ->whereNotNull('ms_company')
            ->where('ms_company', '!=', '')
            ->distinct()
            ->orderBy('ms_company')
            ->pluck('ms_company');

        $divisis = User::query()
            ->select('ms_divisi')
            ->whereNotNull('ms_divisi')
            ->where('ms_divisi', '!=', '')
            ->distinct()
            ->orderBy('ms_divisi')
            ->pluck('ms_divisi');

        $levels = UserLevel::orderBy('urutan')->get();

        // Stats untuk header
        $stats = [
            'total'      => User::count(),
            'no_level'   => User::whereNull('level_id')->count(),
            'inactive'   => User::where('activate', 0)->count(),
        ];

        return view('user-management.users.index', compact(
            'users', 'companies', 'divisis', 'levels', 'stats',
            'search', 'company', 'divisi', 'levelId', 'aktif'
        ));
    }

    public function edit($id)
    {
        $user = User::with('userLevel')->findOrFail($id);
        $levels = UserLevel::orderBy('urutan')->get();
        return view('user-management.users.edit', compact('user', 'levels'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'level_id' => ['nullable', 'integer', Rule::exists('ms_user_level', 'id')],
            'activate' => ['nullable', 'boolean'],
        ]);

        $user->level_id = $data['level_id'] ?? null;
        $user->activate = $request->boolean('activate');
        $user->save();

        return redirect()
            ->route('user-management.users.index')
            ->with('success', "User '{$user->name}' diupdate (level + status).");
    }

    public function toggleActive($id)
    {
        $user = User::findOrFail($id);
        $user->activate = $user->activate ? 0 : 1;
        $user->save();

        return back()->with(
            'success',
            "User '{$user->name}' status diubah jadi " . ($user->activate ? 'aktif' : 'nonaktif') . '.'
        );
    }
}
