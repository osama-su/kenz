@extends('dashboard.layouts.master')
@section('styles')

@endsection
@section('page_header')
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.users.index')}}" class="text-muted">المستخدمين</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.users.edit',['user'=>$user->id])}}"
               class="text-muted">تعديل</a>
        </li>
    </ul>
@endsection
@section('content')
    <form action="{{route('dashboard.users.update',['user'=>$user->id])}}" method="post" enctype="multipart/form-data">
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
                                       value="{{$user->name??old("name")}}"
                                       class="form-control {{ $errors->has("name") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل الاسم"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("name") ? $errors->first("name") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;">البريد الالكتروني :
                                    <span class="text-danger">*</span></label>
                                <input name="email" type="email"
                                       value="{{$user->email?? old("email") }}"
                                       class="form-control {{ $errors->has("email") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل البريد الالكتروني"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("email") ? $errors->first("email") : null }}
                                    </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label style="float: right;">كلمة المرور:
                                    <span class="text-danger">*</span></label>
                                <input name="password"
                                       type="password"
                                       class="form-control {{ $errors->has("password") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل كلمة المرور"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("password") ? $errors->first("password") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;">تاكيد كلمة المرور :
                                    <span class="text-danger">*</span></label>
                                <input name="password_confirmation" type="password"
                                       value="{{$user->password_confirmation?? old("password_confirmation") }}"
                                       class="form-control {{ $errors->has("password_confirmation") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل تاكيد كلمة المرور"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("password_confirmation") ? $errors->first("password_confirmation") : null }}
                                    </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label style="float: right;"> المحافظة:
                                    <span class="text-danger">*</span></label>
                                <input name="gov"
                                       type="text"
                                       value="{{$user->gov??old('gov')}}"
                                       class="form-control {{$errors->has("gov") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل المحافظة"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("gov") ? $errors->first("gov") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;"> العنوان :
                                    <span class="text-danger">*</span></label>
                                <input name="address" type="text"
                                       value="{{$user->address??old("address") }}"
                                       class="form-control {{ $errors->has("address") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل العنوان"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("address") ? $errors->first("address") : null }}
                                    </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label style="float: right;"> رقم الهاتف:
                                    <span class="text-danger">*</span></label>
                                <input name="mobile"
                                       type="text"
                                       value="{{$user->mobile??old('mobile')}}"
                                       class="form-control {{ $errors->has("mobile") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل  رقم الهاتف"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("mobile") ? $errors->first("mobile") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;"> الملاحظات :
                                    <span class="text-danger">*</span></label>
                                <input name="notes" type="text"
                                       value="{{$user->mobile??old("notes") }}"
                                       class="form-control {{ $errors->has("notes") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل الملاحظات"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("notes") ? $errors->first("notes") : null }}
                                    </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label style="float: right;"> القاعدة:
                                    <span class="text-danger">*</span></label>
                                <select name="role_id"
                                        class="form-control {{ $errors->has("role_id") ? 'is-invalid' : '' }}">
                                    <option value="">اختار</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}"
                                            {{$role->id==$user->role_id?'selected':null}}>{{$role->name??'-'}}</option>
                                    @endforeach
                                </select>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("role_id") ? $errors->first("role_id") : null }}
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
    <div class="row">
        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <!--begin::Form-->
                <div class="card-header">
                    <h3 class="card-title">الفواتير</h3>
                    <h3 class="card-title">مجموع العمولات :
                        {{$user->bills->sum(function ($bill) {
        return $bill->billDetails->sum(function ($billDetail) {
            return optional($billDetail->product)->commission * $billDetail->qty;
        });
    }) }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-separate table-head-custom table-checkable responsive table-responsive" id="kt_datatable3">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم العميل</th>
                            <th>المحافظة</th>
                            <th>رقم هاتف العميل</th>
                            <th>اسم المورد</th>
                            <th>اسم المنتج</th>
                            <th>الكمية</th>
                            <th>اجمالي السعر</th>
                            <th>العمولات</th>
                            <th>تاريخ الانشاء</th>
                            <th>الاحداث</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($user->bills as $bill)
                            <tr id="row-{{ $bill->id }}">
                                <td>{{$bill->id??'-'}}</td>
                                <td>{{$bill->user->name??'-'}}</td>
                                <td>{{$bill->user->gov??'-'}}</td>
                                <td>{{$bill->user->mobile??'-'}}</td>
                                <td>{{$bill->supplier->name??'-'}}</td>
                                <td>{{ rtrim($bill->billDetails->map(function ($billDetails) {
    $product_name = $billDetails->product->name ?? '-';
    return $product_name . '-';
})->implode(''), '-') }}</td>

                                <td>{{ rtrim($bill->billDetails->map(function ($billDetails) {
    $product_qty = $billDetails->qty ?? '-';
    return $product_qty . '-';
})->implode(''), '-') }}</td>
                                <td>{{$bill->price_after }}</td>
                                <td>{{$bill->billDetails->sum(function ($billDetail) {
                                        return optional($billDetail->product)->commission;
                                                                })}}</td>
                                <td>{{ $bill->created_at ?? '-' }}</td>
                                <td>
                                    @can('update_company')
                                        <a href="{{route('dashboard.deliveries.edit', ['delivery' => $bill->id])}}"
                                           class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                            <i class="la la-edit"></i>
                                        </a>
                                    @endcan
                                    @can('delete_company')
                                        <a data-url="{{ route('dashboard.deliveries.destroy',['delivery' => $bill->id]) }}"
                                           data-item-id="{{ $bill->id }}"
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
@endsection
@section('scripts')
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>


    <script>
        $(document).ready(function () {
            $('#kt_datatable3 thead tr').clone(true).appendTo('#kt_datatable3 thead');
            $('#kt_datatable3 thead tr:eq(1) th').each(function (i) {
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
            var table = $('#kt_datatable3').DataTable({
                responsive: true,
                orderBy: [0, 'desc'],
                // Pagination settings
                dom: `<'row'<'col-md-6 text-left'f><'col-md-6 text-right'B>>
			<'row'<'col-md-12'tr>>
			<'row'<'col-md-5'i><'col-md-7 dataTables_pager'lp>>`,
                order: [],
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
    <script src="{{asset('assets/js/pages/crud/forms/widgets/tagify.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/pages/crud/forms/editors/summernote.js')}}"></script>

@endsection
