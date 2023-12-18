<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpensesRequest;
use App\Http\Requests\UpdateExpensesRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Expenses;
use App\Models\ExpenseType;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExpenseTypesController extends Controller
{
    /**
     * ProductsController constructor.
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
        $this->authorize('read_product');


        $expenseTypes = ExpenseType::all();

        return view('dashboard.expense-types.index', compact( 'expenseTypes'));
    }

    /**
     * @param StoreExpensesRequest $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {

        $data = $request->validate([
            'name' => 'required',
        ]);

        ExpenseType::create($data);

        return redirect()->route('dashboard.expense-types.index')->with(['status' => 'success', 'message' => 'تم الحفظ بنجاج']);

    }

    /**
     * @return View
     */
    public function create(): View
    {
        $this->authorize('create_product');

        $expenseTypes = ExpenseType::all();

        return view('dashboard.expense-types.create', compact('expenseTypes'));
    }

    /**
     * @param Product $product
     * @return View
     */
    public function edit(ExpenseType $expenseType): View
    {
        $this->authorize('update_product');


        return view('dashboard.expense-types.edit', compact('expenseType'));
    }

    /**
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(UpdateExpensesRequest $request, Expenses $expense): RedirectResponse
    {

        $expense->update($request->all());


        return redirect()->route('dashboard.expense-types.index')->with(['status' => 'success', 'message' => 'تم التعديل بنجاح']);

    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(ExpenseType $expenseType): JsonResponse
    {
        $expenseType->delete();

        return response()->json(['status' => 'success', 'message' => 'تم المسح بنجاح']);
    }
}
