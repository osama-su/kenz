<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\StoreExpensesRequest;
use App\Http\Requests\UpdateExpensesRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Expenses;
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

        $expenses = $expenses->get();

        return view('dashboard.expenses.index', compact('expenses'));
    }

    /**
     * @param StoreExpensesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreExpensesRequest $request): RedirectResponse
    {

        $data = $request->all();

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

        return view('dashboard.expenses.create');
    }

    /**
     * @param Product $product
     * @return View
     */
    public function edit(Expenses $expense): View
    {
        $this->authorize('update_product');

        return view('dashboard.expenses.edit', compact('expense'));
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
