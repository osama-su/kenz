<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Company;
use App\Models\Product;
use App\Models\User;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->authorize('read_report');

        $users = User::where('role_id', '1')->get();

       $suppliers = Supplier::all();

        $products = Product::all();

        $companies = Company::all();

        $users_m = User::where('role_id', '!=', '1')->get();

        $allUsers = User::all();

        return view('dashboard.reports.index', compact('allUsers','users_m', 'suppliers','users', 'products', 'companies'));
    }

    public function show(Request $request)
    {
        $this->authorize('read_report');

        $bills = Bill::withTrashed()->with(['billDetails' => function ($q) {
            $q->withTrashed();
        }])->orderBy('created_at', 'desc');

        if ($request->date_from || $request->date_to) {
            $bills = $bills->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }

        if ($request->gov) {
            $bills = $bills->whereHas('user', function ($q) use ($request) {
                $q->where('gov', $request->gov);
            });
        }

        if ($request->created_by) {
            $bills = $bills->where('created_by', $request->created_by);
        }

        if ($request->supplier_id) {
            $bills = $bills->where('supplier_id', $request->supplier_id);
        }


        if ($request->print) {
            $bills = $bills->where('print', $request->print);
        }
        if ($request->user_m) {
            $bills = $bills->where('user_id', $request->user_m);
        }
        if ($request->company_id) {

            $bills = $bills->where('company_id', $request->company_id);
        }
        if ($request->product_id) {

            $bills = $bills->whereHas('billDetails', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);

                if($request->delivery_status=='no'){
               $q->withTrashed()->where('delivery_status', 'no');
                }
                     if($request->delivery_status=='yes'){
               $q->withTrashed()->where('delivery_status', 'yes')->where('delivery_status',null);
                }
            });
        }
        if ($request->product_id==null) {

        if ($request->delivery_status) {
            $bills = $bills->wherehas('billDetails', function ($q) use($request) {
                $q->withTrashed()->where('delivery_status', $request->delivery_status);
            });
        }
}
        if ($request->delivery_status == 'cancel') {
            $bills = $bills->where('deleted_type', 'cancel');

        }

        $bills = $bills->get();

        return view('dashboard.reports.show', compact('bills'));
    }

        function generate_pdf(Request $request)
    {
        if(!$request->printer){
                    return redirect()->back()->with(['status' => 'danger', 'message' => 'من فضلك اختار الفاتورة ']);

        }

        $bills = Bill::withTrashed()->whereIn('id', $request->printer)->get();


      $pdf = \PDF::loadView('dashboard.bills.pdf', $bills->first());

      return $pdf->stream('bill_' . $bills->first()->id . '.pdf');

        // return redirect()->back();
    }

}
