<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
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

class ExpensesController extends Controller
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


        $expenses = Expenses::query();

        if ($request->date_from || $request->date_to) {
            $expenses = $expenses->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }
        if ($request->expense_type_id)
        {
            $expenses = $expenses->where('expense_type_id', $request->expense_type_id);
        }

        $expenses = $expenses->get();

        $totalExpenses = $expenses->sum('amount');

        foreach (ExpenseType::all() as $expenseType) {
            $stats[$expenseType->id] = ['name'=>$expenseType->name, 'amount'=> $expenses->where('expense_type_id', $expenseType->id)->sum('amount')];
        }
        $expenseTypes = ExpenseType::all();

        return view('dashboard.expenses.index', compact('expenses', 'totalExpenses', 'stats', 'expenseTypes'));
    }

    /**
     * @param StoreExpensesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreExpensesRequest $request): RedirectResponse
    {

        $data = $request->all();
        $data['title'] = ExpenseType::find($data['expense_type_id'])->name;

        if ($request->hasFile('image')) {
            $data['image'] = $request->image->store('uploads', 'public');
        }

        Expenses::create($data);

        return redirect()->route('dashboard.expenses.index')->with(['status' => 'success', 'message' => 'تم الحفظ بنجاج']);

    }

    /**
     * @return View
     */
    public function create(): View
    {
        $this->authorize('create_product');

        $expenseTypes = ExpenseType::all();

        return view('dashboard.expenses.create', compact('expenseTypes'));
    }

    /**
     * @param Product $product
     * @return View
     */
    public function edit(Expenses $expense): View
    {
        $this->authorize('update_product');

        $expenseTypes = ExpenseType::all();

        return view('dashboard.expenses.edit', compact('expense', 'expenseTypes'));
    }

    /**
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(UpdateExpensesRequest $request, Expenses $expense): RedirectResponse
    {

        $expense->update($request->all());


        return redirect()->route('dashboard.expenses.index')->with(['status' => 'success', 'message' => 'تم التعديل بنجاح']);

    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Expenses $expense): JsonResponse
    {
        $expense->delete();

        return response()->json(['status' => 'success', 'message' => 'تم المسح بنجاح']);
    }
}
