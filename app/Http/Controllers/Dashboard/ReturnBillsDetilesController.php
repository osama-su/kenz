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

class ReturnBillsDetilesController extends Controller
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
    public function store(BillDetiesRequest $request, Bill $delivery)
    {
        
        
   $product = Product::where('id',$request->product_id)->first();

      if($product->inventory()->sum('qty')==0||$product->inventory()->sum('qty') < $request->qty){
               return redirect()->back()
           ->with(['status' => 'danger', 'message' => 'عفوا الكمية غير متوفرة']);
        }
        
        
        $billDetails = $delivery->billDetails()->create([
            'product_id' => $request->product_id,
             'size' =>implode(',',$request->size),
            'color' =>implode(',',$request->color) ,
            'model' =>implode(',',$request->model),
            'qty' => $request->qty,
            'price' => ($request->price * $request->qty),
        ]);
     
       
        $billDetails->product->inventory()->create(['bill_id'=>$delivery->id,'qty'=>-$request->qty]);

       
        $price = $delivery->billDetails()->sum('price');
        $price_after = $delivery->billDetails()->sum('price') 
        + $delivery->delivery_fee
        ;

        if ($delivery->discount_percentage) {
            $price_after = ($delivery->billDetails()->sum('price') 
            + $delivery->delivery_fee
            ) -($delivery->discount_percentage);
        }

        $delivery->update(['price' => $price, 'price_after' => $price_after]);


        return redirect()->back()->with(['status' => 'success', 'message' => 'تم لحفظ بنجاح']);
    }

    /**
     * @param Bill $bill
     * @return View
     */
    public function edit(Bill $delivery, BillDetail $billDetail): View
    {
        $this->authorize('update_bill');

        $products = Product::all();

        return view('dashboard.returnBillDetail.edit', compact('delivery', 'billDetail', 'products'));
    }

    /**
     * @param UpdateBillRequest $request
     * @param Bill $bill
     * @return RedirectResponse
     */
    public function update(UpdateBillRequest $request, Bill $delivery, BillDetail $billDetail): RedirectResponse
    {
        
       $product = Product::where('id',$request->product_id)->first();

      if($product->inventory()->sum('qty')==0||$product->inventory()->sum('qty')< ($billDetail->product->inventory()->sum('qty') - $request->qty)){
               return redirect()->back()
           ->with(['status' => 'danger', 'message' => 'عفوا الكمية غير متوفرة']);
        }
        
     
          if ($request->qty > $billDetail->qty) {

               $billDetail->product->inventory()->create(['bill_id'=>$delivery->id,'qty'=> -($request->qty-$billDetail->qty)]);
        }
        
      elseif ($request->qty < $billDetail->qty) {
               $billDetail->product->inventory()->create(['bill_id'=>$delivery->id,'qty'=>($billDetail->qty  - $request->qty)]);
        }
           if ($request->qty != $billDetail->qty) {
            $billDetail->update([
                'price' => ($billDetail->product->price * $request->qty),
            ]);
        }
        
          if($request->delivery_status!=null){
            if($delivery->company==null){
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
     
    
        
        $price = $delivery->billDetails()->sum('price');
        $price_after = $delivery->billDetails()->sum('price') 
        + ($delivery->delivery_fee)
        ;

        if ($delivery->discount_percentage!=null) {
            $price_after = ($price_after) - ($delivery->discount_percentage );
        }

        $delivery->update(['price' => $price, 'price_after' => $price_after]);

        if ($request->delivery_status == 'no') {
            

            $billDetail->product->inventory()->create(['bill_id'=>$delivery->id,'qty'=>($billDetail->qty)]);
  
            $delivery->update(['price' => ($delivery->billDetails()->sum('price') - $billDetail->price),
                'price_after' => ($delivery->billDetails()->sum('price')
                + $delivery->delivery_fee
                ) - $billDetail->price]);

            if ($delivery->discount_percentage != null) {
                $b = Bill::where('id', $delivery->id)->first();

                $delivery->update([
                    'price' => (($b->billDetails()->sum('price') - $billDetail->price)),
                    'price_after' => ((($b->billDetails()->sum('price') - $billDetail->price)
                    + $b->delivery_fee
                    ) - ($b->discount_percentage)),
                ]);
            }

            $billDetail->delete();
        }
        if($request->delivery_status!=null && $billDetail->delivery_status==null){
            if($delivery->company){
                 $delivery=Bill::where('id',$delivery->id)->with(['billDetails'=>function($q){
          $q->withTrashed();
      }])->first();

      if($delivery->billDetails()->withTrashed()->count()==1){
             $delivery->company->wallet()->create(['bill_id'=>$delivery->id,'amount' => ($billDetail->product->price * $request->qty)-($delivery->discount_percentage),'type'=>$request->delivery_status=='yes'?'done':'return']);
      }else{
                    if($delivery->billDetails()->withTrashed()->where('discount_type','yes')->count()==0){
  $delivery->company->wallet()->create(['bill_id'=>$delivery->id,'amount' =>($billDetail->product->price * $request->qty)-($delivery->discount_percentage),'type'=>$request->delivery_status=='yes'?'done':'return']);   
}else{
      $delivery->company->wallet()->create(['bill_id'=>$delivery->id,'amount' =>($billDetail->product->price * $request->qty),'type'=>$request->delivery_status=='yes'?'done':'return']);   
}

      }                    
               
                  
            }
                  
        }

  $billDetail->update(['delivery_status' => $request->delivery_status,      'discount_type' => $delivery->discount_percentage==0||$delivery->discount_percentage==null?null:'yes']);
  
  
    if($delivery->billDetails()->count()==$delivery->billDetails()->where('delivery_status','yes')->count()){
                        $delivery->update(['delivery_status'=>'yes']);
                    }
        return redirect()->back()->with(['status' => 'success', 'message' => 'تم لحفظ بنجاح']);
    }

    /**
     * @param Bill $delivery
     * @return JsonResponse
     */
  public function destroy(Bill $delivery, BillDetail $billDetail): JsonResponse
    {
        $billDetail->update(['delivery_status' => 'no']);

         $billDetail->product->inventory()->create(['bill_id'=>$delivery->id,'qty'=>$billDetail->qty]);

        $delivery->update(['price' => ($delivery->billDetails()->sum('price') - $billDetail->price),
            'price_after' => ($delivery->billDetails()->sum('price')
            + $delivery->delivery_fee
            ) - $billDetail->price]);

        if ($delivery->discount_percentage != null) {
            $b = Bill::where('id', $delivery->id)->first();

            $delivery->update([
                'price' => (($b->billDetails()->sum('price') - $billDetail->price)),
                'price_after' => ((($b->billDetails()->sum('price') - $billDetail->price) 
                + $b->delivery_fee
                ) - ($b->discount_percentage)),
            ]);
        }

 if($delivery->company){
      $delivery=Bill::where('id',$delivery->id)->with(['billDetails'=>function($q){
          $q->withTrashed();
      }])->first();

      if($delivery->billDetails()->withTrashed()->count()==1){
             $delivery->company->wallet()->create(['bill_id'=>$delivery->id,'amount' => ($billDetail->product->price * $billDetail->qty)-($delivery->discount_percentage),'type'=>'return']);
      }else{
                      if($delivery->billDetails()->withTrashed()->where('discount_type','yes')->count()==0){
  $delivery->company->wallet()->create(['bill_id'=>$delivery->id,'amount' =>($billDetail->product->price * $billDetail->qty)-($delivery->discount_percentage),'type'=>'return']);   
}else{
      $delivery->company->wallet()->create(['bill_id'=>$delivery->id,'amount' =>($billDetail->product->price * $billDetail->qty),'type'=>'return']);   
}

      }
                  
            }
             $billDetail->update(['delivery_status' => 'no',  'discount_type' => $delivery->discount_percentage==0||$delivery->discount_percentage==null?null:'yes',]);

        $billDetail->delete();

        return response()->json(['status' => 'success', 'message' => 'تم المسح بنجاح']);
    }

}
