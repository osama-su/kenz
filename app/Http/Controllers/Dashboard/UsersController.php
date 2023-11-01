<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUsersRequest;
use App\Http\Requests\UpdateUsersRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request): View
    {
        $this->authorize('read_user');

        $users = User::where('role_id','!=','2')->orderBy('created_at', 'desc')->get();

        if ($request->date_from || $request->date_to) {
            $users = $users->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }

        return view('dashboard.users.index', compact('users'));
    }


    /**
     * @return View
     */
    public function create(): View
    {
        $this->authorize('create_user');

        $roles = Role::all();

        return view('dashboard.users.create', compact('roles'));
    }


    /**
     * @param CreateUsersRequest $request
     * @return RedirectResponse
     */
    public function store(CreateUsersRequest $request): RedirectResponse
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'gov' => $request->gov,
            'address' => $request->address,
            'role_id' => $request->role_id,
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('dashboard.users.index')->with(['status' => 'success', 'message' => 'تم الحفظ بنجاح']);

    }

    /**
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        $this->authorize('update_user');

        $roles = Role::all();

        return view('dashboard.users.edit', compact('user', 'roles'));
    }

    /**
     * @param UpdateUsersRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateUsersRequest $request, User $user): RedirectResponse
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'gov' => $request->gov,
            'address' => $request->address,
            'role_id' => $request->role_id,
        ]);

        if ($request->password) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('dashboard.users.index')->with(['status' => 'success', 'message' => 'تم التعديل بنجاح']);

    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(['status' => 'success', 'message' => 'تم المسح بنجاح']);
    }
}
