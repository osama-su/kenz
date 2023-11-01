<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RolesController extends Controller
{

    /**
     * RolesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $this->authorize('read_role');

        $roles = Role::all();

        if ($request->date_from || $request->date_to) {
            $roles = $roles->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }

        return view('dashboard.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $this->authorize('create_role');

        $permissions = Permission::where('model', '!=', 'permission')->get()->groupBy('model');
        return view('dashboard.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return RedirectResponse
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        $role = Role::create($request->except('permissions'));

        $role->permissions()->sync($request->permissions);

        return redirect()->back()->with(['status' => 'success', 'message' => 'تم الحفظ بنجاح']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return View
     */
    public function edit(Role $role): View
    {
        $this->authorize('update_role');

        $permissions = Permission::where('model', '!=', 'permission')->get()->groupBy('model');

        return view('dashboard.roles.edit', compact('permissions', 'role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        $role->update($request->except('permissions'));

        $role->permissions()->sync($request->permissions);

        return redirect()->back()->with(['status' => 'success', 'message' => 'تم التعديل بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Role $role): JsonResponse
    {
        $this->authorize('delete_role');

        $role->delete();

        return response()->json(['status' => 'success', 'message' => 'تم المسح بنجاح']);
    }
}
