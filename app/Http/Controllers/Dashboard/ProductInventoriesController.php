<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryRequest;
use App\Models\Product;
use App\Models\ProductQty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class ProductInventoriesController
 * @package App\Http\Controllers\Dashboard
 */
class ProductInventoriesController extends Controller
{
    /**
     * ProductInventoriesController constructor.
     */
    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(InventoryRequest $request, Product $product)
    {
        $product->inventory()->create(['qty' => $request->qty]);

        return redirect()->route('dashboard.products.edit', ['product' => $product->id])->with(['status' => 'success', 'message' => 'تم الحفظ بنجاح']);

    }

    /**
     * @param Product $product
     * @param ProductInventory $productInventory
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Product $product, ProductQty $productQty)
    {
        return view('dashboard.productInventories.edit', compact('product', 'productQty'));
    }

    /**
     * @param Request $request
     * @param Product $product
     * @param ProductInventory $productInventory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(InventoryRequest $request, Product $product, ProductQty $productQty)
    {
        $productQty->update($request->all());

        return redirect()->route('dashboard.products.edit', ['product' => $product->id])->with(['status' => 'success', 'message' => 'تم التعديل بنجاح']);

    }

    /**
     * @param Product $product
     * @param ProductInventory $productInventory
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Product $product, ProductQty $productQty)
    {
        $productQty->delete();

        return response()->json(['status' => 'success', 'message' => 'تم المسح بنجاح']);

    }

}
