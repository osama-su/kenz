<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSuppliersRequest;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SuppliersController extends Controller
{
    /**
     * SuppliersController constructor.
     */
    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * @return View
     */
    public function index(Request $request): View
    {
        $this->authorize('read_supplier');


        $suppliers = Supplier::orderBy('created_at', 'desc')->get();

        if ($request->date_from || $request->date_to) {
            $suppliers = $suppliers->whereBetween('created_at', [$request->date_from, (new Carbon($request->date_to))->addDay()]);
        }

        return view('dashboard.suppliers.index', compact('suppliers'));
    }


    /**
     * @return View
     */
    public function create(): View
    {
        $this->authorize('create_supplier');

        return view('dashboard.suppliers.create');
    }


    /**
     * @param CreateProductRequest $request
     * @return RedirectResponse
     */
    public function store(CreateSuppliersRequest $request): RedirectResponse
    {
        $product = Supplier::create($request->all());

        return redirect()->route('dashboard.suppliers.index')->with(['status' => 'success', 'message' => 'تم الحفظ بنجاج']);

    }

    /**
     * @param Product $product
     * @return View
     */
    public function edit(Supplier $supplier): View
    {
        $this->authorize('update_supplier');

        return view('dashboard.suppliers.edit', compact('supplier'));
    }

    /**
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(CreateSuppliersRequest $request, Supplier $supplier): RedirectResponse
    {
        $supplier->update($request->all());

        return redirect()->route('dashboard.suppliers.index')->with(['status' => 'success', 'message' => 'تم التعديل بنجاح']);

    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Supplier $supplier): JsonResponse
    {
        $supplier->delete();

        return response()->json(['status' => 'success', 'message' => 'تم المسح بنجاح']);
    }
}
