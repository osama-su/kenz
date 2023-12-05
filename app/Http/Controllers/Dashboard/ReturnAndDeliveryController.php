<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBillRequest;
use App\Models\Bill;
use App\Models\Company;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;


class ReturnAndDeliveryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->authorize('read_delivery');

        $bills = Bill::withTrashed()->where('created_by', Auth::user()->id)->with(['billDetails' => function ($q) {
            $q->withTrashed();
        }])->where('deleted_type', '!=', 'cancel')->get();
        if (Auth::user()->role_id == '1') {

            $bills = Bill::withTrashed()->with(['billDetails' => function ($q) {
                $q->withTrashed();
            }])->where('deleted_type', '!=', 'cancel')->get();

        }
        if ($request->date_from || $request->date_to) {
            $bills = $bills->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }


        return view('dashboard.returnBills.index', compact('bills'));
    }

    public function show(DataTables $dataTables, Request $request)
    {
        $model = Bill::withTrashed()->where('created_by', Auth::user()->id)->with(['billDetails' => function ($q) {
            $q->withTrashed();
        }])->where('deleted_type', '!=', 'cancel');
        if (Auth::user()->role_id == '1') {

            $model = Bill::withTrashed()->with(['billDetails' => function ($q) {
                $q->withTrashed();
            }])->where('deleted_type', '!=', 'cancel');

        }
        if ($request->search['value'] != null) {
            $model = $model->where('id', 'like', '%' . $request->search['value'] . '%')
                ->orWhereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search['value'] . '%');
                })
                ->orWhereHas('user', function ($q) use ($request) {
                    $q->where('gov', 'like', '%' . $request->search['value'] . '%');
                })
                ->orWhereHas('user', function ($q) use ($request) {
                    $q->where('address', 'like', '%' . $request->search['value'] . '%');
                })
                ->orWhereHas('user', function ($q) use ($request) {
                    $q->where('mobile', 'like', '%' . $request->search['value'] . '%');
                })
                ->orWhereHas('supplier', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search['value'] . '%');
                });
        }

        return $dataTables->eloquent($model)->addIndexColumn()
            ->editColumn('id', function (Bill $bill) {
                return $bill->id ?? '-';
            })
            ->addColumn('qr', function (Bill $bill) {
                return view('dashboard.returnBills.qr', compact('bill'));
            })
            ->editColumn('name', function (Bill $bill) {
                return $bill->user->name ?? '-';
            })
            ->editColumn('gov', function (Bill $bill) {
                return $bill->user->gov ?? '-';
            })
            ->editColumn('created_by', function (Bill $bill) {
                return \App\Models\User::where('id', $bill->created_by)->first()->name ?? '-';
            })
            ->addColumn('qty', function (Bill $bill) {
                return $bill->billDetails->map(function ($billDetails) {
                    return $billDetails->qty;
                })->implode('-');
            })
            ->addColumn('billDetails', function (Bill $bill) {
                return $bill->billDetails->map(function ($billDetails) {

                    $product_name = ($billDetails->product->name ?? '-');
                    if ($billDetails->delivery_status != null) {
                        if ($billDetails->delivery_status == 'yes') {
                            $status = 'تم التسليم';
                        } else {
                            $status = 'لم يتم التسليم';
                        }
                    } else {
                        $status = null;
                    }
                    return $product_name . '-' . $status;
                })
                    ->implode('-');
            })
            ->editColumn('delivery_status', function (Bill $bill) {
                return $bill->billDetails->map(function ($billDetail) {
                    $name = $billDetail->product->name ?? '-';
                    if ($billDetail->delivery_status != null) {
                        $name = $billDetail->product->name . '-' . ($billDetail->delivery_status === 'yes' ? 'تم التسليم' : 'لم يتم التسليم');
                    }
                    return $name ?? '-';
                })->implode("-");
            })
            ->addColumn('delivery_now_status', function (Bill $bill) {
                if ($bill->delivery_status != null) {
                    if ($bill->deleted_at != null) {
                        $status = 'مرتجع';
                    } else {
                        $status = 'تسليم';
                    }
                } else {
                    $status = '-';
                }
                return $status;
            })
            ->editColumn('price_after', function (Bill $bill) {
                return $bill->price_after;
            })
            ->addColumn('delivery_status_type', function (Bill $bill) {
                if ($bill->billDetails()->where('delivery_status', 'yes')
                        ->count() == $bill->billDetails->count() || $bill->billDetails()->withTrashed()
                        ->where('delivery_status', 'no')->count() == $bill->billDetails()->withTrashed()->count()) {
                    $type = ' كلي';
                } else {
                    $type = 'جزئي';
                }
                return $type;
            })
            ->addColumn('select', function (Bill $bill) {
                return view('dashboard.returnBills.select', compact('bill'));
            })
            ->addColumn('action', function (Bill $bill) {
                return view('dashboard.returnBills.buttons', compact('bill'));
            })
            ->rawColumns(['action'])
            ->startsWithSearch()
            ->filter(function ($query) use ($request) {
                if ($request->name) {
                    $query->whereHas('user', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->name . '%');
                    });;
                }
                if ($request->gov) {
                    $query->whereHas('user', function ($q) use ($request) {
                        $q->where('gov', 'like', '%' . $request->gov . '%');
                    });;
                }
                if ($request->created_by) {
                    $user = \App\Models\User::where('name', 'like', '%' . $request->created_by . '%')->first() ?? '-';
                    $query->whereHas('user', function ($q) use ($user) {
                        $q->where('created_by', $user->id);
                    });;
                }
                if ($request->delivery_status) {
                    $query->whereHas('billDetails', function ($q) use ($request) {
                        $q->whereHas('product', function ($q) use ($request) {
                            $q->where('name', 'like', '%' . $request->delivery_status . '%');
                        });
                    });
                }
                if ($request->qty) {
                    $query->whereHas('billDetails', function ($q) use ($request) {
                        $q->where('qty', 'like', '%' . $request->qty . '%');
                    });
                }
                if ($request->delivery_now_status) {
                    if ($request->delivery_now_status == 'مرتجع') {
                        $query->where('deleted_at', '!=', null);
                    }
                    if ($request->delivery_now_status == 'تسليم') {
                        $query->where('deleted_at', null)->where('delivery_status ', '!=', null);
                    }
                }
                if ($request->price_after) {
                    $query->where('price_after', 'like', '%' . $request->price_after . '%');
                }
                if ($request->delivery_status_type) {
                    if ($request->delivery_status_type == 'كلي') {
                        $query->whereHas('billDetails', function ($q) {
                            $q->withTrashed()->where('delivery_status', 'yes');
                        });
                    }
                    if ($request->delivery_status_type == 'جزئي') {
                        $query->whereHas('billDetails', function ($q) {
                            $q->withTrashed()->where('delivery_status', '!=', 'yes');
                        });
                    }
                }
                if ($request->date_to) {
                    $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
                }

            })->make(true);
    }


    public function edit(Bill $delivery): View
    {
        $this->authorize('update_delivery');

//        if (auth()->user()->cannot('update', $delivery)) {
//            abort(403);
//        }
        $products = Product::all();

        $companies = Company::all();

        $users = User::where('role_id', '1')->get();

        return view('dashboard.returnBills.edit', compact('delivery', 'users', 'companies', 'products'));
    }

    public function totalPrice(Bill $delivery, Request $request)
    {
        $price = $request->price + $request->delivery_fee;


        $price_wallet = $request->price;

        if ($request->discount_percentage) {
            $price = ($request->price + $request->delivery_fee) - ($request->discount_percentage);

            $price_wallet = ($request->price) - ($request->discount_percentage);
        }


        if ($request->delivery_status != null) {
            if ($delivery->company == null) {
                return redirect()->back()
                    ->with(['status' => 'danger', 'message' => 'من فضلك قم باختيار المندوب لتتكمن من تغير حالة التسليم ']);
            }
        }

        if ($request->delivery_status != null) {
            if ($delivery->company) {
                if ($request->delivery_status != $delivery->delivery_status) {
                    if ($delivery->company->wallet()->where('bill_id', $delivery->id)->where('type', 'return')->count() == 0) {
                        if ($delivery->company->wallet()->where('bill_id', $delivery->id)->where('type', 'done')->count() == 0) {

                            $delivery->company->wallet()->create(['bill_id' => $delivery->id, 'amount' => $price_wallet, 'type' => $request->delivery_status == 'yes' ? 'done' : 'return']);

                        }
                    }
                }
            }

        }

        $delivery->update([
            'delivery_status' => $request->delivery_status,
            'delivery_receive' => $request->delivery_receive,
            'discount_percentage' => $request->discount_percentage,
            'delivery_fee' => $request->delivery_fee,
            'date_receive' => $request->date_receive,
            'price_after' => $price,
        ]);

        if ($request->delivery_status == 'yes') {
            $delivery->billDetails()->update(['delivery_status' => 'yes']);

        }
        if ($request->delivery_status == 'no') {
            $delivery->billDetails()->update(['delivery_status' => 'no']);
            // if ($delivery->company->count()) {
            //     $delivery->company->wallet()->update(['bill_id'=>$delivery->id,'amount' => $price,'type'=>$request->delivery_status=='yes'?'done':'return']);
            // }

            if ($delivery->billDetails->count()) {
                foreach ($delivery->billDetails as $dit) {
                    $dit->product->inventory()->create(['bill_id' => $delivery->id, 'qty' => $dit->qty]);

                }
            }

            $delivery->billDetails()->delete();

            $delivery->delete();

            return redirect()->route('dashboard.deliveries.index')
                ->with(['status' => 'success', 'message' => 'تم الحفظ بنجاح']);
        }

        return redirect()->route('dashboard.deliveries.edit', ['delivery' => $delivery->id])
            ->with(['status' => 'success', 'message' => 'تم الحفظ بنجاح']);
    }

    public function update(UpdateBillRequest $request, Bill $delivery): RedirectResponse
    {
        $billDetails = $delivery->update([
            'product_id' => $request->product_id,
            'size' => $request->size,
            'color' => $request->color,
            'model' => $request->model,
            'qty' => $request->qty,
            'price' => ($request->price * $request->qty),
        ]);

        $delivery->update([
            'price' => $delivery->billDetails()->sum('price'),
            'price_after' => $delivery->billDetails()->sum('price') + $delivery->delivery_fee
        ]);


        return redirect()->route('dashboard.returnBills.index')->with(['status' => 'success', 'message' => 'تم التعديل بنجاح']);
    }

    public function destroy(Bill $delivery): RedirectResponse
    {
        $this->authorize('delete_delivery');

        $delivery->delete();

        return redirect()->route('dashboard.deliveries.index')->with(['status' => 'success', 'message' => 'تم الحذف بنجاح']);
    }

    public function userUpdate(Request $request, Bill $delivery)
    {

        $delivery->user()->update($request->except('_token'));

        return redirect()->route('dashboard.bills.edit', ['bill' => $delivery->id])
            ->with(['status' => 'success', 'message' => 'تم الحفظ بنجاح']);
    }
}
