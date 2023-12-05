<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBillRequest;
use App\Http\Requests\UpdateBillRequest;
use App\Http\Requests\UpdateBillsUsersRequest;
use App\Models\Bill;
use App\Models\Company;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

/**
 * Class BillsController
 * @package App\Http\Controllers\Dashboard
 */
class BillsController extends Controller
{
    /**
     * BillsController constructor.
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
        $this->authorize('read_bill');

//        $bills = Bill::where('created_by', Auth::user()->id)->orderBy('created_at', 'desc');
        $bills = Bill::query();
        $users = User::where('role_id','!=','2')->get();

        $suppliers = Supplier::all();

        $products = Product::all();

        if (Auth::user()->role_id == '1') {
            $bills = Bill::orderBy('created_at', 'desc');
        }

        if ($request->date_from || $request->date_to) {
            $bills = $bills->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }
        if ($request->supplier_id) {
            $bills = $bills->where('supplier_id', $request->supplier_id);
        }


        if ($request->gov) {
            $bills = $bills->whereHas('user', function ($q) use ($request) {
                $q->where('gov', $request->gov);
            });
        }

        if ($request->created_by) {
            $bills = $bills->where('created_by', $request->created_by);
        }

        if ($request->print) {
            $bills = $bills->where('print', $request->print);
        }

        if ($request->product_id) {

            $bills = $bills->whereHas('billDetails', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            });
        }

        $bills = $bills->get();


        return view('dashboard.bills.index', compact('bills', 'users', 'suppliers', 'products'));
    }

    public function show(DataTables $dataTables, Request $request)
    {

//        $model = Bill::where('created_by', Auth::user()->id)->orderBy('created_at', 'desc');
        $model = Bill::query();
        if (Auth::user()->role_id == '1') {
            $model = Bill::orderBy('created_at', 'desc');
        }

        if ($request->date_from || $request->date_to) {
            $model = $model->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }
        if ($request->supplier_id) {
            $model = $model->where('supplier_id', $request->supplier_id);
        }


        if ($request->gov) {
            $model = $model->whereHas('user', function ($q) use ($request) {
                $q->where('gov', $request->gov);
            });
        }

        if ($request->created_by) {
            $model = $model->where('created_by', $request->created_by);
        }

        if ($request->print) {
            $model = $model->where('print', $request->print);
        }

        if ($request->product_id) {

            $model = $model->whereHas('billDetails', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            });
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
            ->editColumn('name', function (Bill $bill) {
                return $bill->user->name ?? '-';
            })
            ->editColumn('gov', function (Bill $bill) {
                return $bill->user->gov ?? '-';
            })->addColumn('supplier', function (Bill $bill) {
                return $bill->supplier->name ?? '-';
            })->addColumn('address', function (Bill $bill) {
                return $bill->user->address ?? '-';
            })->addColumn('mobile', function (Bill $bill) {
                return $bill->user->mobile ?? '-';
            })->addColumn('supplier', function (Bill $bill) {
                return $bill->supplier->name ?? '-';
            })
            ->editColumn('created_by', function (Bill $bill) {
                return \App\Models\User::where('id', $bill->created_by)->first()->name ?? '-';
            })
            ->addColumn('qty', function (Bill $bill) {
                return $bill->billDetails->map(function ($billDetails) {
                    return $billDetails->qty;
                })->implode('-');
            })
            ->addColumn('product_name', function (Bill $bill) {
                return $bill->billDetails->map(function ($billDetails) {

                    $product_name = ($billDetails->product->name ?? '-');

                    return $product_name . '<br>';
                })
                    ->implode('<br>');
            })
            ->addColumn('product_qty', function (Bill $bill) {
                return $bill->billDetails->map(function ($billDetails) {

                    $product_qty = ($billDetails->qty ?? '-');

                    return $product_qty . '<br>';
                })
                    ->implode('<br>');
            })
            ->addColumn('price', function (Bill $bill) {
                return $bill->price;
            })
            ->addColumn('delivery_fee', function (Bill $bill) {
                return $bill->delivery_fee;
            })
            ->editColumn('price_after', function (Bill $bill) {
                return $bill->price_after;
            })
            ->addColumn('profit', function (Bill $bill) {
                // bill's products cost
                $cost = $bill->billDetails->map(function ($billDetails) {
                    return $billDetails->product ? $billDetails->product->wholesale_price * $billDetails->qty : 0;
                })->sum();
                return $bill->price_after - $cost - $bill->delivery_fee;
            })
            ->addColumn('print_status', function (Bill $bill) {
                if ($bill->print == 'yes') {
                    return 'نعم';
                } else {
                    return 'لا';
                }
            })
            ->addColumn('delivery_status', function (Bill $bill) {
                if ($bill->delivery_status == 'yes') {
                    return 'نعم';
                } else {
                    return 'لا';
                }
            })
            ->addColumn('action', function (Bill $bill) {
                return view('dashboard.returnBills.buttons', compact('bill'));
            })
            ->addColumn('select_return', function (Bill $bill) {
                return view('dashboard.returnBills.select', compact('bill'));
            })
            ->addColumn('select', function (Bill $bill) {
                return view('dashboard.bills.select', compact('bill'));
            })
            ->rawColumns(['action', 'product_name', 'product_qty', 'select'])
            ->startsWithSearch()
            ->filterColumn('name', function ($query, $keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            })
            ->filterColumn('mobile', function ($query, $keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('mobile', 'like', '%' . $keyword . '%');
                });
            })
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

            })->make(true);
    }

    /**
     * @param CreateBillRequest $request
     * @return RedirectResponse
     */
    public function store(CreateBillRequest $request): RedirectResponse
    {
        $user = User::updateOrCreate(
            ['mobile' => $request->mobile],
            ['name' => $request->name, 'email' => $request->email, 'address' => $request->address, 'gov' => $request->gov, 'role_id' => '2']);

        $bill = Bill::create([
            'user_id' => $user->id,
            'company_id' => $request->company_id,
            'price' => '0',
            'note' => $request->notes,
            'created_by' => Auth::user()->id,
            'supplier_id' => $request->supplier_id
        ]);

        $product = Product::where('id', $request->product_id)->first();

        if ($product->inventory()->sum('qty') == 0 || $product->inventory()->sum('qty') < $request->qty) {
            return redirect()->back()
                ->with(['status' => 'danger', 'message' => 'عفوا الكمية غير متوف']);
        }

        $billDetails = $bill->billDetails()->create([
            'product_id' => $request->product_id,
            'size' => implode(',', $request->size),
            'color' => implode(',', $request->color),
            'model' => implode(',', $request->model),
            'qty' => $request->qty,
            'price' => ($request->price * $request->qty),
        ]);


        $billDetails->product->inventory()->create(['bill_id' => $bill->id, 'qty' => -$request->qty]);

        $bill->update([
            'price' => $bill->billDetails()->sum('price'),
            'price_after' => $bill->company ? $bill->billDetails()->sum('price') + ($bill->company->gov()->where('gov', 'like', '%%' . $bill->user->gov . '%%')->first()->price ?? null) : $bill->billDetails()->sum('price'),
            'delivery_fee' => $bill->company ? $bill->company->gov()->where('gov', 'like', '%%' . $bill->user->gov . '%%')->first()->price ?? null : 0,
        ]);


        return redirect()->route('dashboard.bills.edit', ['bill' => $bill->id])
            ->with(['status' => 'success', 'message' => 'تم الحفظ بنجاح']);

    }

    /**
     * @return View
     */
    public function create(): View
    {
        $this->authorize('create_bill');

        $products = Product::all();

        $companies = Company::all();

        $users = Supplier::all();

        return view('dashboard.bills.create', compact('products', 'users', 'companies'));
    }

    /**
     * @param UpdateBillRequest $request
     * @param Bill $bill
     * @return RedirectResponse
     */
    public function update(UpdateBillRequest $request, Bill $bill): RedirectResponse
    {
        $billDetails = $bill->update([
            'product_id' => $request->product_id,
            'size' => implode(',', $request->size),
            'color' => implode(',', $request->color),
            'model' => implode(',', $request->model),
            'qty' => $request->qty,
            'price' => ($request->price * $request->qty),
        ]);

        $bill->update([
            'price' => $bill->billDetails()->sum('price'),
            'price_after' => $bill->billDetails()->sum('price')
                + $bill->delivery_fee
        ]);


        return redirect()->route('dashboard.bills.index')->with(['status' => 'success', 'message' => 'تم التعديل بنجاح']);
    }

    /**
     * @param Bill $bill
     * @return View
     */
    public function edit(Bill $bill): View
    {
        $this->authorize('update_bill');

        $products = Product::all();

        $companies = Company::all();

        $users = Supplier::all();

        return view('dashboard.bills.edit', compact('bill', 'users', 'companies', 'products'));
    }

    /**
     * @param Bill $bill
     * @return JsonResponse
     */
    public function destroy(Bill $bill): JsonResponse
    {

        if ($bill->company) {
            if ($bill->company->wallet()->where('bill_id', $bill->id)->where('type', 'return')->count() == 0) {
                if ($bill->company->wallet()->where('bill_id', $bill->id)->where('type', 'done')->count() == 0) {
                    $bill->company->wallet()->create(['bill_id' => $bill->id, 'amount' => ($bill->price - $bill->discount_percentage), 'type' => 'return']);
                }
            }
        }

        if ($bill->billDetails->count()) {
            foreach ($bill->billDetails as $dit) {
                $dit->product->inventory()->create(['bill_id' => $bill->id, 'qty' => $dit->qty]);

            }
        }

        $bill->billDetails()->update(['delivery_status' => 'no']);

        $bill->update(['delivery_status' => 'no', 'deleted_type' => Request()->deleted_type]);

        $bill->billDetails()->delete();

        $bill->delete();

        return response()->json(['status' => 'success', 'message' => 'تم المسح بنجاح']);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function single_product_size(Request $request)
    {
        $product = Product::where('id', $request->id)->first();

        return response()->view('dashboard.bills.size', compact('product'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function single_product_model(Request $request)
    {
        $product = Product::where('id', $request->id)->first();

        return response()->view('dashboard.bills.model', compact('product'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function single_product_color(Request $request)
    {
        $product = Product::where('id', $request->id)->first();

        return response()->view('dashboard.bills.color', compact('product'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function single_product_price(Request $request)
    {
        $product = Product::where('id', $request->id)->first();

        return response()->view('dashboard.bills.price', compact('product'));
    }

    /**
     * @param Bill $bill
     * @param Request $request
     * @return RedirectResponse
     */
    public function totalPrice(Bill $bill, Request $request)
    {
        $price = $request->price + $request->delivery_fee;

        $price_wallet = $request->price;

        if ($request->discount_percentage) {
            $price = ($request->price + $request->delivery_fee) - ($request->discount_percentage);

            $price_wallet = ($request->price) - ($request->discount_percentage);
        }

        if ($request->delivery_status != null) {
            if ($bill->company == null) {
                return redirect()->back()
                    ->with(['status' => 'danger', 'message' => 'من فضلك قم باختيار المندوب لتتكمن من تغير حالة التسليم ']);
            }
        }
        if ($request->delivery_status != null) {
            if ($bill->company) {
                if ($request->delivery_status != $bill->delivery_status) {
                    if ($bill->company->wallet()->where('bill_id', $bill->id)->where('type', 'return')->count() == 0) {
                        if ($bill->company->wallet()->where('bill_id', $bill->id)->where('type', 'done')->count() == 0) {

                            $bill->company->wallet()->create(['bill_id' => $bill->id, 'amount' => $price_wallet, 'type' => $request->delivery_status == 'yes' ? 'done' : 'return']);

                        }
                    }
                }
            }

        }


        $bill->update([
            'delivery_status' => $request->delivery_status,
            'delivery_receive' => $request->delivery_receive,
            'discount_percentage' => $request->discount_percentage,
            'delivery_fee' => $request->delivery_fee,
            'date_receive' => $request->date_receive,
            'price_after' => $price,
            'price' => $request->price,

        ]);

        if ($request->delivery_status == 'yes') {
            $bill->billDetails()->update(['delivery_status' => 'yes']);

        }


        if ($request->delivery_status == 'no') {

            if ($bill->billDetails->count()) {
                foreach ($bill->billDetails as $dit) {
                    $dit->product->inventory()->create(['bill_id' => $bill->id, 'qty' => $dit->qty]);

                }
            }
            $bill->update(['deleted_type' => 'return']);

            $bill->billDetails()->update(['delivery_status' => 'no']);

            $bill->billDetails()->delete();

            $bill->delete();

            return redirect()->route('dashboard.bills.index')
                ->with(['status' => 'success', 'message' => 'تم الحفظ بنجاح']);
        }

        return redirect()->route('dashboard.bills.edit', ['bill' => $bill->id])
            ->with(['status' => 'success', 'message' => 'تم الحفظ بنجاح']);
    }

    /**
     * @param Bill $bill
     * @return mixed
     */
    function generate_pdf(Request $request)
    {
        if ($request->company_id == null) {
            return redirect()->route('dashboard.bills.index')->with(['status' => 'danger', 'message' => 'من فضلك اختار المندوب اولا']);
        }

        if (!$request->printer) {
            return redirect()->route('dashboard.bills.index')->with(['status' => 'danger', 'message' => 'عفوا اختار الفاتورة اولا']);
        }

        $bills = Bill::withTrashed()->whereIn('id', $request->printer)->get();

        $bill = $bills->first();
//        dd($bills->first()->company->id, $request->all());

//        if ($bills->first()->company->id != $request->company_id) {
//            if ($bill->company) {
//                if ($bill->company->wallet()->where('bill_id', $bill->id)->where('type', 'return')->count() == 0) {
//                    if ($bill->company->wallet()->where('bill_id', $bill->id)->where('type', 'done')->count() == 0) {
//                        $bill->company->wallet()->create(['bill_id' => $bill->id, 'amount' => ($bill->price - $bill->discount_percentage), 'type' => 'return']);
//                    }
//                }
//            }
//        }


        $pdf = \PDF::loadView('dashboard.bills.pdf', $bills->first());
        return $pdf->stream('bill_' . $bills->first()->id . '.pdf');

        // return redirect()->back();
    }


    public function all_pdf(Request $request)
    {

        if ($request->company_id == null) {
            return redirect()->route('dashboard.bills.index')->with(['status' => 'danger', 'message' => 'من فضلك اختار المندوب اولا']);
        }

        $bills = Bill::where('created_by', Auth::user()->id)->orderBy('created_at', 'desc');


        if (Auth::user()->role_id == '1') {
            $bills = Bill::orderBy('created_at', 'desc');
        }

        if ($request->date_from || $request->date_to) {
            $bills = $bills->whereBetween('created_at', [$request->date_from, $request->date_to]);
        }

        if ($request->gov) {
            $bills = $bills->whereHas('user', function ($q) use ($request) {
                $q->where('gov', $request->gov);
            });
        }

        if ($request->created_by) {
            $bills = $bills->where('created_by', $request->created_by);
        }

        if ($request->print) {
            $bills = $bills->where('print', $request->print);
        }

        if ($request->product_id) {

            $bills = $bills->whereHas('billDetails', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            });
        }

        $bills = $bills->get();


        if ($bills->count()) {
            foreach ($bills as $bill) {

                $pdf = \PDF::loadView('dashboard.bills.pdf', $bill);

                $pdf->stream('bill_' . $bill->id . '.pdf');

                $bill->update(['print' => 'yes']);
            }
        } else {
            return redirect()->route('dashboard.bills.index')->with(['status' => 'danger', 'message' => 'عفوا لا يوجد بيانات']);
        }
        return redirect()->back();
    }

    public function deliveryStatus($bill, Request $request)
    {

        $bills = Bill::withTrashed()->where('id', $bill)->first();

        if ($bills->company) {
            if ($bills->company->wallet()->where('bill_id', $bills->id)->where('type', 'return')->count() == 0) {
                if ($bills->company->wallet()->where('bill_id', $bills->id)->where('type', 'done')->count() == 0) {
                    $bills->company->wallet()->create(['bill_id' => $bills->id, 'amount' => ($bills->price - $bills->discount_percentage), 'type' => 'return']);
                }
            }
        }
        $bills->update(['delivery_status' => $request->delivery_status, 'deleted_at' => null, 'deleted_type' => '-']);

        if ($request->delivery_status == 'no') {
            $bills->update(['deleted_type' => 'return']);

            $bills->billDetails()->withTrashed()->update(['delivery_status' => 'no']);
            // if ($bills->company) {
            //     $bills->wallet()->create(['amount' => $bills->billDetails()->withTrashed()->sum('price')]);
            // }
            if ($bills->billDetails->count()) {
                foreach ($bills->billDetails as $billDetail) {
                    $billDetail->product->inventory()->create(['bill_id' => $bills->id, 'qty' => $billDetail->qty]);
                }
            }


            $bills->billDetails()->withTrashed()->delete();

            $bills->delete();
        } else {
            $bills->billDetails()->withTrashed()->update(['delivery_status' => 'yes', 'deleted_at' => null,]);

        }


    }

    public function userEdit(UpdateBillsUsersRequest $request, Bill $bill)
    {

        $bill->user()->update([
            'name' => $request->name,
            'email' => $request->email,
            'gov' => $request->gov,
            'address' => $request->address,
            'mobile' => $request->mobile,
            'notes' => $request->notes,
        ]);

        return redirect()->route('dashboard.bills.edit', ['bill' => $bill->id])
            ->with(['status' => 'success', 'message' => 'تم الحفظ بنجاح']);

    }
}
