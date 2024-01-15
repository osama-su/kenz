<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompaniesRequest;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompaniesController extends Controller
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
        $this->authorize('read_company');

        $companies = Company::orderBy('created_at', 'desc')->get();

        if ($request->date_from || $request->date_to) {
            $companies = $companies->whereBetween('created_at', [$request->date_from, (new Carbon($request->date_to))->addDay()]);
        }

        return view('dashboard.companies.index', compact('companies'));
    }


    /**
     * @return View
     */
    public function create(): View
    {
        $this->authorize('create_company');

        return view('dashboard.companies.create');
    }


    /**
     * @param CompaniesRequest $request
     * @return RedirectResponse
     */
    public function store(CompaniesRequest $request): RedirectResponse
    {
        $company = Company::create($request->all());

        return redirect()->route('dashboard.companies.edit', ['company' => $company->id])->with(['status' => 'success', 'message' => 'تم الحفظ بنجاج']);

    }

    /**
     * @param Company $company
     * @return View
     */
    public function edit(Company $company): View
    {
        $this->authorize('update_company');

        return view('dashboard.companies.edit', compact('company'));
    }

    /**
     * @param CompaniesRequest $request
     * @param Company $company
     * @return RedirectResponse
     */
    public function update(CompaniesRequest $request, Company $company): RedirectResponse
    {
        $company->update($request->all());

        return redirect()->route('dashboard.companies.index')->with(['status' => 'success', 'message' => 'تم التعديل بنجاح']);

    }

    /**
     * @param Company $company
     * @return JsonResponse
     */
    public function destroy(Company $company): JsonResponse
    {
        $company->delete();

        return response()->json(['status' => 'success', 'message' => 'تم المسح بنجاح']);
    }
}
