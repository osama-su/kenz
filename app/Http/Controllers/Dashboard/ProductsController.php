<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductsController extends Controller
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


        $products = Product::orderBy('created_at', 'desc');

        if ($request->date_from || $request->date_to) {
            $products = $products->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }

        $products = $products->get();

        $productsَQty = 0;
        foreach ($products as $product) {
            $productsَQty += $product->qties->sum('qty');
        }
        $totalCost = 0;
        foreach ($products as $product) {
            $totalCost += $product->qties->sum('qty') * $product->wholesale_price;
        }
        $totalValue = 0;
        foreach ($products as $product) {
            $totalValue += $product->qties->sum('qty') * $product->price;
        }

        return view('dashboard.products.index', compact('products', 'productsَQty', 'totalCost', 'totalValue'));
    }


    /**
     * @return View
     */
    public function create(): View
    {
        $this->authorize('create_product');

        return view('dashboard.products.create');
    }


    /**
     * @param CreateProductRequest $request
     * @return RedirectResponse
     */
    public function store(CreateProductRequest $request): RedirectResponse
    {
        $product = Product::create($request->all());

 if($request->qty){
         $product->qties()->create(['qty'=>$request->qty]);
         }
        return redirect()->route('dashboard.products.index')->with(['status' => 'success', 'message' => 'تم الحفظ بنجاج']);

    }

    /**
     * @param Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        $this->authorize('update_product');

        return view('dashboard.products.edit', compact('product'));
    }

    /**
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {

        $product->update($request->all());


        return redirect()->route('dashboard.products.index')->with(['status' => 'success', 'message' => 'تم التعديل بنجاح']);

    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(['status' => 'success', 'message' => 'تم المسح بنجاح']);
    }
}
