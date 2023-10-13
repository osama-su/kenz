<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function index($bill)
    {
        $bills = Bill::withTrashed()->where('id', $bill)->first();

        $bills->update(['delivery_status' => 'no', 'deleted_type' => 'return']);

        $bills->billDetails()->update(['delivery_status' => 'no']);

        if ($bills->deleted_at == null) {

            $bills->billDetails()->delete();

            $bills->delete();
        }

        return view('dashboard.returnBills.success');
    }

    public function autocomplete(Request $request)
    {
        $movies = [];

        if ($request->has('q')) {
            $search = $request->q;

            $movies = Bill::with('user')->whereHas('user', function ($q) use ($search) {
                $q->where("mobile", "like", "%$search%");
            })->orwhere('id', "like", "%$search%")->get();
        }
        return response()->json($movies);

    }
}
