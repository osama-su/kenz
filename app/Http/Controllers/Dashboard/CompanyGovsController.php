<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompaniesRequest;
use App\Http\Requests\CompanyGovRequest;
use App\Models\Company;
use App\Models\CompanyGov;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyGovsController extends Controller
{
    /**
     * ProductsController constructor.
     */
    public function __construct()
    {
        return $this->middleware('auth');
    }

    /**
     * @param CompaniesRequest $request
     * @return RedirectResponse
     */
    public function store(Company $company, CompanyGovRequest $request): RedirectResponse
    {
        $company->gov()->create([
            'price' => $request->price,
            'gov' => $request->gov
        ]);

        return redirect()->back()->with(['status' => 'success', 'message' => 'تم الحفظ بنجاج']);

    }

    /**
     * @param Company $company
     * @return View
     */
    public function edit(Company $company, CompanyGov $companyGov): View
    {
        $this->authorize('update_company');

        return view('dashboard.companyGov.edit', compact('company', 'companyGov'));
    }

    /**
     * @param CompaniesRequest $request
     * @param Company $company
     * @return RedirectResponse
     */
    public function update(CompanyGovRequest $request, Company $company, CompanyGov $companyGov): RedirectResponse
    {
        $companyGov->update([
            'price' => $request->price,
            'gov' => $request->gov
        ]);

        return redirect()->route('dashboard.companies.edit', ['company' => $company->id])->with(['status' => 'success', 'message' => 'تم التعديل بنجاح']);

    }

    /**
     * @param Company $company
     * @return JsonResponse
     */
    public function destroy(Company $company, CompanyGov $companyGov): JsonResponse
    {
        $companyGov->delete();

        return response()->json(['status' => 'success', 'message' => 'تم المسح بنجاح']);
    }
}
