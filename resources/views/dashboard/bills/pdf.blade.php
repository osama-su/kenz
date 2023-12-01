<?php

use App\Models\Bill;
use App\Models\Company;

if (Request()->printer != null) {
    $bills = Bill::withTrashed()->whereIn('id', Request()->printer)->get();
} else {

    $bills = Bill::where('created_by', Auth::user()->id)->orderBy('created_at', 'desc');


    if (Auth::user()->role_id == '1') {
        $bills = Bill::orderBy('created_at', 'desc');
    }

    if (Request()->date_from || Request()->date_to) {
        $bills = $bills->whereBetween('created_at', [Request()->date_from, Request()->date_to]);
    }

    if (Request()->gov) {
        $bills = $bills->whereHas('user', function ($q) {
            $q->where('gov', Request()->gov);
        });
    }

    if (Request()->created_by) {
        $bills = $bills->where('created_by', Request()->created_by);
    }

    if (Request()->print) {
        $bills = $bills->where('print', Request()->print);
    }

    if (Request()->product_id) {

        $bills = $bills->whereHas('billDetails', function ($q) {
            $q->where('product_id', Request()->product_id);
        });
    }

    $bills = $bills->get();
}
$company = Company::where('id', Request()->company_id)->first();

?>
    <!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <title>فاتورة</title>
    <style>
        body {
            direction: rtl;
            font-family: 'examplefont', sans-serif;
        }

        #invoice-POS {
            /*box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);*/
            padding: 2mm;
            margin: 0 auto;
            /*background: #FFF;*/

        }

        #invoice-POS ::selection {
            background: #f31544;
            color: #FFF;
        }

        #invoice-POS ::moz-selection {
            background: #f31544;
            color: #FFF;
        }

        #invoice-POS h1 {
            font-size: 1.5em;
            color: #222;
        }

        #invoice-POS h2 {
            font-size: 0.9em;
        }

        #invoice-POS h3 {
            font-size: 1.2em;
            font-weight: 300;
            line-height: 2em;
        }

        #invoice-POS p {
            font-size: 0.7em;
            color: #666;
            line-height: 1.2em;
        }

        #invoice-POS #top, #invoice-POS #mid, #invoice-POS #bot {
            /* Targets all id with 'col-' */
            border-bottom: 1px solid #EEE;
        }

        #invoice-POS #top {
            min-height: 100px;
        }

        #invoice-POS #mid {
            min-height: 80px;
        }

        #invoice-POS #bot {
            min-height: 50px;
        }

        #invoice-POS #top .logo {
            height: 60px;
            width: 60px;
            background: url(http://michaeltruong.ca/images/logo1.png) no-repeat;
            background-size: 60px 60px;
        }

        #invoice-POS .clientlogo {
            float: left;
            height: 60px;
            width: 60px;
            background: url(http://michaeltruong.ca/images/client.jpg) no-repeat;
            background-size: 60px 60px;
            border-radius: 50px;
        }

        #invoice-POS .info {
            display: inline;
            margin-left: 0;
        }

        #invoice-POS .title {
            float: right;
        }

        #invoice-POS .title p {
            text-align: right;
        }

        #invoice-POS table {
            width: 100%;
            border-collapse: collapse;
        }

        #invoice-POS .tabletitle {
            font-size: 0.5em;
            background: #EEE;
        }

        #invoice-POS .service {
            border-bottom: 1px solid #EEE;
        }

        #invoice-POS .item {
            width: 24mm;
        }

        #invoice-POS .itemtext {
            font-size: 0.5em;
        }
    </style>
</head>
<body>
@if($bills->count())
    @foreach($bills as $bill)
        @php
            if(Request()->company_id!=$bill->company_id){
             $bill->update(['company_id' => Request()->company_id]);
            if($bill->delivery_fee==null||$bill->delivery_fee==0){
              $bill->update(['company_id' => Request()->company_id,
                            'delivery_fee' => $company ? ($company->gov()->where('gov', 'like', '%%' . $bill->user->gov . '%%')->first()->price ?? 0) : 0]);
            }

                        $price = -$bill->price;

                        if ($bill->discount_percentage) {
                            $price = -($bill->price-$bill->discount_percentage);
                        }

                        $bill->company->wallet()->create(['amount'=>$price,'bill_id'=>$bill->id]);

                        }
                        $bill->update(['print' => 'yes','price_after'=>($bill->price-$bill->discount_percentage)+($bill->delivery_fee)]);
            $createdBy = \App\Models\User::where('id', $bill->created_by)->first()->name ?? '-';


        @endphp
        <div id="invoice-POS">

            <div id="top" style="text-align: center;">

                <img
                    src="data:image/png;base64, {{ base64_encode(QrCode::encoding('UTF-8')->format('png')->margin(1)->size(100)->generate(route('dashboard.bills.return',['bill'=>$bill->id]))) }}">


                <div class="info">
                    <h2>رقم الفاتورة :{{$bill->id??'-'}}</h2>
                    <h2>تاريخ التشاء :{{$bill->created_at??'-'}}</h2>
                </div><!--End Info-->
            </div><!--End InvoiceTop-->

            <div id="mid">
                <div class="info" style="display: flex; flex-direction: row; justify-content: space-between;">
                    <table>
                        <tr>
                            <th colspan="2"> <span>معلومات الفاتورة</span></th>
                        </tr>
                        <tr>
                            <td>الاسم</td>
                            <td>{{$bill->user->name??'-'}}</td>
                        </tr>
                        <tr>
                            <td>رقم الهاتف</td>
                            <td>{{$bill->user->mobile??'-'}}</td>
                        </tr>
                        <tr>
                            <td>البريد الالكتروني</td>
                            <td>{{$bill->user->email??'-'}}</td>
                        </tr>
                        <tr>
                            <td>المحافظة</td>
                            <td>{{$bill->user->gov??'-'}}</td>
                        </tr>
                        <tr>
                            <td>العنوان</td>
                            <td>{{$bill->user->address??'-'}}</td>
                        </tr>
                        <tr>
                            <td>اسم المندوب</td>
                            <td>{{$bill->company->name??'-'}}</td>
                        </tr>
                        <tr>
                            <td>اسم المورد</td>
                            <td>{{ $bill->supplier->name??'-'  }}</td>
                        </tr>
                        <tr>
                            <td>اسم البائع</td>
                            <td>{{ $createdBy  }}</td>
                        </tr>


                    </table>
                </div>
            </div><!--End Invoice Mid-->

            <div id="bot">

                <div id="table">
                    <table>
                        <tr class="tabletitle">
                            <td class="item"><h5>المنتج</h5></td>
                            <td class="Rate"><h5>الكمية</h5></td>
                            <td class="Rate"><h5>لون</h5></td>
                            <td class="Rate"><h5>المقاس</h5></td>
                            <td class="Hours"><h5>السعر</h5></td>
                        </tr>
                        @if($bill->billDetails->count())
                            @foreach($bill->billDetails as $billDetails)
                                <tr class="service">
                                    <td class="tableitem"><p class="itemtext">{{$billDetails->product->name??'-'}}</p>
                                    </td>
                                    <td class="tableitem"><p class="itemtext">{{$billDetails->qty}}</p></td>
                                    <td class="tableitem"><p class="itemtext">{{$billDetails->color??'-'}}</p>
                                    </td>
                                    <td class="tableitem"><p class="itemtext">{{$billDetails->size??'-'}}</p>
                                    </td>
                                    <td class="tableitem"><p class="itemtext">{{$billDetails->price}} ج.م </p></td>
                                </tr>
                            @endforeach
                        @endif


                        <tr class="tabletitle">
                            <td></td>
                            <td class="Rate"><h5> السعر قبل</h5></td>
                            <td class="payment"><h5>{{$bill->price??'-'}} ج.م</h5></td>
                        </tr>

                        <tr class="tabletitle">
                            <td></td>
                            <td class="Rate"><h5>نسبة الخصم</h5></td>
                            <td class="payment"><h5>{{$bill->discount_percentage??'-'}} ج.م</h5></td>
                        </tr>
                        <tr class="tabletitle">
                            <td></td>
                            <td class="Rate"><h5>مصاريف الشحن</h5></td>
                            <td class="payment"><h5>{{$bill->delivery_fee??'0'}} ج.م</h5></td>
                        </tr>
                        <tr class="tabletitle">
                            <td></td>
                            <td class="Rate"><h5>السعر الاجمالي</h5></td>
                            <td class="payment"><h5>{{$bill->price_after??'-'}} ج.م</h5></td>
                        </tr>

                    </table>
                </div><!--End Table-->

                <div id="legalcopy">
                    <p class="legal"><strong>ملاحظة</strong> {{$bill->note??'-'}}
                    </p>
                </div>

            </div><!--End InvoiceBot-->
        </div><!--End Invoice-->
    @endforeach
@endif
</body>
</html>
