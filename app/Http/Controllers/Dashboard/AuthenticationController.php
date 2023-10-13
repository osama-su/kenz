<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticationController extends Controller
{
    /**
     * AuthenticationController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Handel The Request For Return Home Page
     * @return View
     */
    public function index(): View
    {
        return view('dashboard.login');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request): RedirectResponse
    {

        if (Auth::attempt($request->only(['email', 'password']))) {

            return redirect()->intended(route('dashboard.index'));
        }

        return redirect()->back()->with(['status' => 'danger', 'message' => 'البريد الالكتروني او رقم الهاتف خطا']);

    }


    /**
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();

        return redirect()->route('dashboard.login.index');
    }

}
