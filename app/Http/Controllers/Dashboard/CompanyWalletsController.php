<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyWalletRequest;
use App\Models\Company;
use App\Models\CompanyWallet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CompanyWalletsController extends Controller
{
    /**
     * ProductsController constructor.
     */
    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * @param CompanyWalletRequest $request
     * @return RedirectResponse
     */
    public function store(Company $company, CompanyWalletRequest $request): RedirectResponse
    {
        $company->wallet()->create([
            'amount' => $request->amount,
        ]);

        return redirect()->back()->with(['status' => 'success', 'message' => 'تم الحفظ بنجاج']);

    }

    /**
     * @param Company $company
     * @return JsonResponse
     */
    public function destroy(Company $company, CompanyWallet $companyWallet): JsonResponse
    {
        $companyWallet->delete();

        return response()->json(['status' => 'success', 'message' => 'تم المسح بنجاح']);
    }
}
