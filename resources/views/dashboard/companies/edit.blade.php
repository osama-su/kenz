@extends('dashboard.layouts.master')
@section('styles')

@endsection
@section('page_header')
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.companies.index')}}" class="text-muted">المندوب</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.companies.edit',['company'=>$company->id])}}" class="text-muted">تعديل</a>
        </li>
    </ul>
@endsection
@section('content')
    <form action="{{route('dashboard.companies.update',['company'=>$company->id])}}" method="post"
          enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">تعديل</h3>

                    </div>
                    <!--begin::Form-->
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label style="float: right;">الاسم:
                                    <span class="text-danger">*</span></label>
                                <input name="name"
                                       value="{{$company->name??old("name")}}"
                                       class="form-control {{ $errors->has("name") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل الاسم"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("name") ? $errors->first("name") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;"> رقم الهاتف:
                                    <span class="text-danger">*</span></label>
                                <input name="mobile"
                                       type="text"
                                       value="{{$company->mobile??old('mobile')}}"
                                       class="form-control {{ $errors->has("mobile") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل  رقم الهاتف"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("mobile") ? $errors->first("mobile") : null }}
                                    </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label style="float: right;">اسم الشركة:
                                    <span class="text-danger">*</span></label>
                                <input name="company_name"
                                       value="{{$company->company_name??old("company_name")}}"
                                       class="form-control {{ $errors->has("company_name") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل اسم الشركة"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("company_name") ? $errors->first("company_name") : null }}
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        {!! method_field('PUT') !!}
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-primary mr-2">حفظ</button>
                        <button type="reset" class="btn btn-secondary">الغاء</button>
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Card-->
            </div>
        </div>
    </form>


    <form action="{{route('dashboard.companyWallets.store',['company'=>$company->id])}}" method="post"
          enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">الحساب</h3>

                    </div>
                    <!--begin::Form-->
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label style="float: right;"> القيمة :
                                    <span class="text-danger">*</span></label>
                                <input name="amount"
                                       type="number"
                                       value="{{old('amount')}}"
                                       class="form-control {{ $errors->has("amount") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل القيمة"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("amount") ? $errors->first("amount") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;"> القيمة الكلية :
                                    <span class="text-danger">*</span></label>
                                <input
                                    readonly
                                    type="number"
                                    value="{{$company->wallet()->sum('amount')}}"
                                    class="form-control {{ $errors->has("amount") ? 'is-invalid' : '' }}"
                                    placeholder="من فضلك ادخل القيمة"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("amount") ? $errors->first("amount") : null }}
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-primary mr-2">حفظ</button>
                        <button type="reset" class="btn btn-secondary">الغاء</button>
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Card-->
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <!--begin::Form-->
                <div class="card-body">
                    <table class="table table-separate table-head-custom table-checkable" id="kt_datatable2">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>القيمة</th>
                            <th>تاريخ الانشاء</th>
                            <th>الاحداث</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($company->wallet as $wallet)
                            <tr id="row-{{ $wallet->id }}">
                                <td>{{$wallet->id??'-'}}</td>
                                <td>{{$wallet->amount??'-'}}</td>
                                <td>{{ $wallet->created_at ?? '-' }}</td>
                                <td>
                                    @can('delete_company')
                                        <a data-url="{{ route('dashboard.companyWallets.destroy',['company' => $company->id,'companyWallet' => $wallet->id,]) }}"
                                           data-item-id="{{ $wallet->id }}"
                                           class="btn btn-sm btn-clean btn-icon btn-icon-md delete-button"
                                           data-toggle="modal"
                                           data-target="#delete_modal">
                                            <i class="la la-trash"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>

    <form action="{{route('dashboard.companyGovs.store',['company'=>$company->id])}}" method="post"
          enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">المحافظة</h3>

                    </div>
                    <!--begin::Form-->
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label style="float: right;"> المحافظة:
                                    <span class="text-danger">*</span></label>
                                <select id="gov" class="form-control" name="gov">
                                    <option value="">اختار</option>
                                    <option value="الغربية">الغربية</option>
                                    <option value="الجيزة">الجيزة</option>
                                    <option value="الإسماعيلية">الإسماعيلية</option>
                                    <option value="كفر الشيخ">كفر الشيخ</option>
                                    <option value="مطروح">مطروح</option>
                                    <option value="المنيا">المنيا</option>
                                    <option value="المنوفية">المنوفية</option>
                                    <option value="الوادي الجديد">الوادي الجديد</option>
                                    <option value="شمال سيناء">شمال سيناء</option>
                                    <option value="بورسعيد">بورسعيد</option>
                                    <option value="القليوبية">القليوبية</option>
                                    <option value="قنا">قنا</option>
                                    <option value="البحر الأحمر">البحر الأحمر</option>
                                    <option value="الشرقية">الشرقية</option>
                                    <option value="سوهاج">سوهاج</option>
                                    <option value="جنوب سيناء">جنوب سيناء</option>
                                    <option value="السويس">السويس</option>
                                    <option value="الأقصر">الأقصر</option>
                                    <option value="القاهرة">القاهرة</option>
                                    <option value="الإسكندرية">الإسكندرية</option>
                                    <option value="الفيوم">الفيوم</option>
                                    <option value="أسوان">أسوان</option>
                                    <option value="أسيوط">أسيوط</option>
                                    <option value="البحيرة">البحيرة</option>
                                    <option value="بني سويف">بني سويف</option>
                                    <option value="الدقهلية">الدقهلية</option>
                                    <option value="دمياط">دمياط</option>
                                </select>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("gov") ? $errors->first("gov") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;"> السعر :
                                    <span class="text-danger">*</span></label>
                                <input name="price"
                                       type="number"
                                       value="{{old('price')}}"
                                       class="form-control {{ $errors->has("price") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل السعر"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("price") ? $errors->first("price") : null }}
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-primary mr-2">حفظ</button>
                        <button type="reset" class="btn btn-secondary">الغاء</button>
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Card-->
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <!--begin::Form-->
                <div class="card-body">
                    <table class="table table-separate table-head-custom table-checkable" id="kt_datatable1">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>السعر</th>
                            <th>تاريخ الانشاء</th>
                            <th>الاحداث</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($company->gov as $gov)
                            <tr id="row-{{ $gov->id }}">
                                <td>{{$gov->id??'-'}}</td>
                                <td>{{$gov->gov??'-'}}</td>
                                <td>{{$gov->price??'-'}}</td>
                                <td>{{ $gov->created_at ?? '-' }}</td>
                                <td>
                                    @can('update_company')
                                        <a href="{{route('dashboard.companyGovs.edit', ['company' => $company->id,'companyGov' => $gov->id,])}}"
                                           class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                            <i class="la la-edit"></i>
                                        </a>
                                    @endcan
                                    @can('delete_company')
                                        <a data-url="{{ route('dashboard.companyGovs.destroy',['company' => $company->id,'companyGov' => $gov->id,]) }}"
                                           data-item-id="{{ $gov->id }}"
                                           class="btn btn-sm btn-clean btn-icon btn-icon-md delete-button"
                                           data-toggle="modal"
                                           data-target="#delete_modal">
                                            <i class="la la-trash"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!--end::Form-->
            </div>
            <!--end::Card-->
        </div>
    </div>

    @include('dashboard.includes.delete-modal',['action_message' => 'هذه المحافظة'])
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/delete-item.js') }}" type="text/javascript"></script>

    <!--begin::Page Vendors(used by this page)-->
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script>
        $(document).ready(function () {
            $('#kt_datatable1 thead tr').clone(true).appendTo('#kt_datatable1 thead');
            $('#kt_datatable1 thead tr:eq(1) th').each(function (i) {
                var title = $(this).text();
                $(this).html('<input type="text" class="col-md-6" />');

                $('input', this).on('keyup change', function () {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            });
            var table = $('#kt_datatable1').DataTable({
                responsive: true,
                // Pagination settings
                dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                buttons: [
                    'print',
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5',
                ], language: {
                    "sEmptyTable": "ليست هناك بيانات متاحة في الجدول",
                    "sLoadingRecords": "جارٍ التحميل...",
                    "sProcessing": "جارٍ التحميل...",
                    "sLengthMenu": "أظهر _MENU_ مدخلات",
                    "sZeroRecords": "لم يعثر على أية سجلات",
                    "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                    "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                    "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                    "sInfoPostFix": "",
                    "sSearch": "ابحث:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "الأول",
                        "sPrevious": "السابق",
                        "sNext": "التالي",
                        "sLast": "الأخير"
                    },
                    "oAria": {
                        "sSortAscending": ": تفعيل لترتيب العمود تصاعدياً",
                        "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
                    }
                }
            });
        });

    </script>
    <!--end::Page Scripts-->
    <script>
        $(document).ready(function () {
          
            var table = $('#kt_datatable2').DataTable({
                responsive: true,
                // Pagination settings
                dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                buttons: [
                    'print',
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5',
                ], language: {
                    "sEmptyTable": "ليست هناك بيانات متاحة في الجدول",
                    "sLoadingRecords": "جارٍ التحميل...",
                    "sProcessing": "جارٍ التحميل...",
                    "sLengthMenu": "أظهر _MENU_ مدخلات",
                    "sZeroRecords": "لم يعثر على أية سجلات",
                    "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                    "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                    "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                    "sInfoPostFix": "",
                    "sSearch": "ابحث:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "الأول",
                        "sPrevious": "السابق",
                        "sNext": "التالي",
                        "sLast": "الأخير"
                    },
                    "oAria": {
                        "sSortAscending": ": تفعيل لترتيب العمود تصاعدياً",
                        "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
                    }
                }
            });
            
              $('#kt_datatable2 thead tr').clone(true).appendTo('#kt_datatable2 thead');
            $('#kt_datatable2 thead tr:eq(1) th').each(function (i) {
                var title = $(this).text();
                $(this).html('<input type="text" class="col-md-6" />');

                $('input', this).on('keyup change', function () {
                    if (table.column(i).search() !== this.value) {
                        table
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            });
        });

    </script>

    <script src="{{asset('assets/js/pages/crud/forms/widgets/tagify.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/pages/crud/forms/editors/summernote.js')}}"></script>
@endsection
