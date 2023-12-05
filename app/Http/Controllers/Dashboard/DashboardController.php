<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Product;
use APP\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display dashboard home page.
     *
     * @return View
     */
    public function index(): View
    {
        $users = User::whereHas('role')->count();

        $products = Product::count();

        $bills = Bill::count();

        return view('dashboard.index', compact('users', 'bills', 'products'));
    }
}
