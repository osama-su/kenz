<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BillDetiesRequest;
use App\Http\Requests\CreateBillRequest;
use App\Http\Requests\UpdateBillRequest;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BillsDetilesController extends Controller
{
    /**
     * BillsController constructor.
     */
    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * @param CreateBillRequest $request
     * @return RedirectResponse
     */
    public function store(BillDetiesRequest $request, Bill $bill): RedirectResponse
    {

     $product = Product::where('id',$request->product_id)->first();

      if($product->inventory()->sum('qty')==0||$product->inventory()->sum('qty') < $request->qty){
               return redirect()->back()
           ->with(['status' => 'danger', 'message' => 'عفوا الكمية غير متوفرة']);
        }


        $billDetails = $bill->billDetails()->create([
            'product_id' => $request->product_id,
             'size' =>implode(',',$request->size),
            'color' =>implode(',',$request->color) ,
            'model' =>implode(',',$request->model),
            'qty' => $request->qty,
            'price' => ($request->price * $request->qty),
        ]);


        $billDetails->product->inventory()->create(['bill_id'=>$bill->id,'qty'=>-$request->qty]);


        $price = $bill->billDetails()->sum('price');
        $price_after = $bill->billDetails()->sum('price') + $bill->delivery_fee
        ;

        if ($bill->discount_percentage) {
            $price_after = ($bill->billDetails()->sum('price')
            + $bill->delivery_fee
            ) -($bill->discount_percentage);
        }

        $bill->update(['price' => $price, 'price_after' => $price_after]);



        if($bill->company){
            $companyWallet = $bill->company->wallet();
            $companyWallet->create(['bill_id' => $bill->id, 'amount' => ($bill->price - $bill->discount_percentage), 'type' => 'return']);
        }


        return redirect()->route('dashboard.bills.edit', ['bill' => $bill->id])
            ->with(['status' => 'success', 'message' => 'تم الحفظ بنجاح']);
    }

    /**
     * @param Bill $bill
     * @return View
     */
    public function edit(Bill $bill, BillDetail $billDetail): View
    {
        $this->authorize('update_bill');

        $products = Product::all();

        return view('dashboard.billDetail.edit', compact('bill', 'billDetail', 'products'));
    }

    /**
     * @param UpdateBillRequest $request
     * @param Bill $bill
     * @return RedirectResponse
     */
    public function update(UpdateBillRequest $request, Bill $bill, BillDetail $billDetail): RedirectResponse
    {

       $product = Product::where('id',$request->product_id)->first();

//       dd($product);

        if($product->id == $billDetail->product->id){
      if($product->inventory()->sum('qty')==0||$product->inventory()->sum('qty')< ($billDetail->product->inventory()->sum('qty') - $request->qty)){
               return redirect()->back()
           ->with(['status' => 'danger', 'message' => 'عفوا الكمية غير متوفرة']);
        }
        }


          if ($request->qty > $billDetail->qty) {
               $billDetail->product->inventory()->create(['bill_id'=>$bill->id,'qty'=> -($request->qty-$billDetail->qty)]);
        }elseif ($request->qty < $billDetail->qty) {
               $billDetail->product->inventory()->create(['bill_id'=>$bill->id,'qty'=>($billDetail->qty  - $request->qty)]);
        }
           if ($request->qty != $billDetail->qty) {
            $billDetail->update([
                'price' => ($billDetail->product->price * $request->qty),
            ]);
        }

          if($request->delivery_status!=null){
            if($bill->company==null){
                      return redirect()->back()
           ->with(['status' => 'danger', 'message' => 'من فضلك قم باختيار المندوب لتتكمن من تغير حالة ']);
            }

          }
        $billDetail->update([
            'product_id' => $request->product_id,
             'size' =>implode(',',$request->size),
            'color' =>implode(',',$request->color) ,
            'model' =>implode(',',$request->model),
            'qty' => $request->qty,
        ]);



        $price = $bill->billDetails()->sum('price');
        $price_after = $bill->billDetails()->sum('price')
        + ($bill->delivery_fee)
        ;

        if ($bill->discount_percentage!=null) {
            $price_after = ($price_after) - ($bill->discount_percentage );
        }

        $bill->update(['price' => $price, 'price_after' => $price_after]);

        if ($request->delivery_status == 'no') {


            $billDetail->product->inventory()->create(['bill_id'=>$bill->id,'qty'=>($billDetail->qty)]);

            $bill->update(['price' => ($bill->billDetails()->sum('price') - $billDetail->price),
                'price_after' => ($bill->billDetails()->sum('price')
                + $bill->delivery_fee
                ) - $billDetail->price]);

            if ($bill->discount_percentage != null) {
                $b = Bill::where('id', $bill->id)->first();

                $bill->update([
                    'price' => (($b->billDetails()->sum('price') - $billDetail->price)),
                    'price_after' => ((($b->billDetails()->sum('price') - $billDetail->price)
                    + $b->delivery_fee
                    ) - ($b->discount_percentage)),
                ]);
            }

            $billDetail->delete();
        }

  if($request->delivery_status!=null && $billDetail->delivery_status==null){            if($bill->company){
      $bill=Bill::where('id',$bill->id)->with(['billDetails'=>function($q){
          $q->withTrashed();
      }])->first();

      if($bill->billDetails()->withTrashed()->count()==1){
             $bill->company->wallet()->create(['bill_id'=>$bill->id,'amount' => ($billDetail->product->price * $request->qty)-($bill->discount_percentage),'type'=>$request->delivery_status=='yes'?'done':'return']);
      }else{
                      if($bill->billDetails()->withTrashed()->where('discount_type','yes')->count()==0){
  $bill->company->wallet()->create(['bill_id'=>$bill->id,'amount' =>($billDetail->product->price * $request->qty)-($bill->discount_percentage),'type'=>$request->delivery_status=='yes'?'done':'return']);
}else{
      $bill->company->wallet()->create(['bill_id'=>$bill->id,'amount' =>($billDetail->product->price * $request->qty),'type'=>$request->delivery_status=='yes'?'done':'return']);
}

      }

            }

            }



          $billDetail->update(['delivery_status' => $request->delivery_status,  'discount_type' => $bill->discount_percentage==0||$bill->discount_percentage==null?null:'yes',]);

  if($bill->billDetails()->count()==$bill->billDetails()->where('delivery_status','yes')->count()){
                        $bill->update(['delivery_status'=>'yes']);
                    }
        return redirect()->route('dashboard.bills.edit', ['bill' => $bill->id])
            ->with(['status' => 'success', 'message' => 'تم الحفظ بنجاح']);
    }

    /**
     * @param Bill $bill
     * @return JsonResponse
     */
    public function destroy(Bill $bill, BillDetail $billDetail): JsonResponse
    {
        $billDetail->update(['delivery_status' => 'no']);

         $billDetail->product->inventory()->create(['bill_id'=>$bill->id,'qty'=>$billDetail->qty]);

        $bill->update(['price' => ($bill->billDetails()->sum('price') - $billDetail->price),
            'price_after' => ($bill->billDetails()->sum('price')
            + $bill->delivery_fee
            ) - $billDetail->price]);

        if ($bill->discount_percentage != null) {
            $b = Bill::where('id', $bill->id)->first();

            $bill->update([
                'price' => (($b->billDetails()->sum('price') - $billDetail->price)),
                'price_after' => ((($b->billDetails()->sum('price') - $billDetail->price)
                + $b->delivery_fee
                ) - ($b->discount_percentage)),
            ]);
        }
        if($bill->company){
      $bill=Bill::where('id',$bill->id)->with(['billDetails'=>function($q){
          $q->withTrashed();
      }])->first();

      if($bill->billDetails()->withTrashed()->count()==1){
             $bill->company->wallet()->create(['bill_id'=>$bill->id,'amount' => ($billDetail->product->price * $billDetail->qty)-($bill->discount_percentage),'type'=>'return']);
      }else{
                      if($bill->billDetails()->withTrashed()->where('discount_type','yes')->count()==0){
  $bill->company->wallet()->create(['bill_id'=>$bill->id,'amount' =>($billDetail->product->price * $billDetail->qty)-($bill->discount_percentage),'type'=>'return']);
}else{
      $bill->company->wallet()->create(['bill_id'=>$bill->id,'amount' =>($billDetail->product->price * $billDetail->qty),'type'=>'return']);
}

      }

            }
             $billDetail->update(['delivery_status' => 'no',  'discount_type' => $bill->discount_percentage==0||$bill->discount_percentage==null?null:'yes',]);

        $billDetail->delete();

        return response()->json(['status' => 'success', 'message' => 'تم المسح بنجاح']);
    }

}
