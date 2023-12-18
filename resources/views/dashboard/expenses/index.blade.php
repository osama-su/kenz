@extends('dashboard.layouts.master')
@section('page_vendors_styles')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('page_header')
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.expenses.index')}}" class="text-muted">المصروفات</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="card card-custom">
        <div class="card-header py-3">
            <div class="card-title">
                <h3 class="card-label">المصروفات</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @can('create_product')
                    <a href="{{route('dashboard.expenses.create')}}" class="btn btn-primary font-weight-bolder m-4">
											<span class="svg-icon svg-icon-md">
												<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
												<svg xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                     height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24"/>
														<circle fill="#000000" cx="9" cy="15" r="6"/>
														<path
                                                            d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                                            fill="#000000" opacity="0.3"/>
													</g>
												</svg>
                                                <!--end::Svg Icon-->
											</span>اضافة جديد </a>
                    <a href="{{route('dashboard.expense-types.index')}}" class="btn btn-primary font-weight-bolder">
											<span class="svg-icon svg-icon-md">
												<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
												<svg xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                     height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24"/>
														<circle fill="#000000" cx="9" cy="15" r="6"/>
														<path
                                                            d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                                            fill="#000000" opacity="0.3"/>
													</g>
												</svg>
                                                <!--end::Svg Icon-->
											</span>البنود </a>
            @endcan
            <!--end::Button-->
            </div>
        </div>

        <div class="row">
            <div class="col-xl-4">
                <!--begin::Stats Widget 7-->
                <div class="card card-custom card-stretch gutter-b">
                    <!--begin::Body-->
                    <div class="card-body d-flex flex-column p-0">
                        <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                            <div class="d-flex flex-column mr-2">
                                <a href="{{route('dashboard.users.index')}}"
                                   class="text-dark-75 text-hover-primary font-weight-bolder font-size-h5">إجمالي المصروفات</a>
                            </div>
                            <span class="symbol symbol-light-success symbol-45">
                                <span
                                    class="symbol-label font-weight-bolder font-size-h6">{{$totalExpenses}}</span>
                            </span>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Stats Widget 7-->
            </div>

        </div>
        <div class="row">
            @foreach($stats as $stat)
                <div class="col-xl-3">
                    <!--begin::Stats Widget 7-->
                    <div class="card card-custom card-stretch gutter-b">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                            <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                <div class="d-flex flex-column mr-2">
                                    <a href="{{route('dashboard.users.index')}}"
                                       class="text-dark-75 text-hover-primary font-weight-bolder font-size-h5">{{$stat['name']}}</a>
                                </div>
                                <span class="symbol symbol-light-success symbol-45">
                                <span
                                    class="symbol-label font-weight-bolder font-size-h6">{{$stat['amount']}}</span>
                            </span>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Stats Widget 7-->
                </div>
            @endforeach
        </div>

        <div class="card-body">
            <form action="{{route('dashboard.expenses.index')}}" method="get">
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <label>التاريخ من:</label>
                        <input type="date"
                               name="date_from"
                               class="form-control created_at"
                               placeholder="من فضلك ادخل التاريخ من">
                    </div>
                    <div class="col-lg-6">
                        <label>التاريخ الي:</label>
                        <input type="date"
                               name="date_to"
                               class="form-control updated_at"
                               placeholder="من فضلك ادخل التاريخ الي">
                    </div>
                    <div class="col-md-6">
                        <select name="expense_type_id"
                                class="form-control {{ $errors->has("expense_type_id") ? 'is-invalid' : '' }}">
                            <option value="" disabled selected>اختر نوع المصروف</option>
                            @foreach($expenseTypes as $expenseType)
                                <option
                                    value="{{ $expenseType->id }}" {{ $expense->expense_type_id??old('expense_type_id') == $expenseType->id ? 'selected' : '' }}>
                                    {{ $expenseType->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="form-text text-danger" style="float: right;">
        {{ $errors->has("expense_type_id") ? $errors->first("expense_type_id") : null }}
    </span>
                    </div>
                    <div class="col-lg-12 mt-3">
                        {!! csrf_field() !!}
                        <button class="col-md-12 btn btn-success" type="submit">بحث</button>
                    </div>
                </div>
            </form>
            <div class="mt-3">
                <table class="table table-separate table-head-custom table-checkable" id="kt_datatable1">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>القيمة</th>
                        <th>اسم الصارف</th>
                        <th>تاريخ الإنشاء </th>
                        <th>الاحداث</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($expenses as $expense)
                        <tr id="row-{{ $expense->id }}">
                            <td>{{$expense->id??'-'}}</td>
                            <td>{{$expense->title??'-'}}</td>
                            <td>{{$expense->amount??'-'}}</td>
                            <td>{{$expense->created_by??'-'}}</td>
                            <td>{{ $expense->created_at ?? '-' }}</td>
                            <td>
                                @can('update_product')
                                    <a href="{{route('dashboard.expenses.edit', ['expense' => $expense->id])}}"
                                       class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                        <i class="la la-edit"></i>
                                    </a>
                                @endcan
                                @can('delete_product')
                                    <a data-url="{{ route('dashboard.expenses.destroy',['expense' => $expense->id]) }}"
                                       data-item-id="{{ $expense->id }}"
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
            <!--begin: Datatable-->
            <!--end: Datatable-->
        </div>
    </div>
    @include('dashboard.includes.delete-modal',['action_message' => 'هذا المنتج'])
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/delete-item.js') }}" type="text/javascript"></script>

    <!--begin::Page Vendors(used by this page)-->
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script>
        $(document).ready(function () {

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
        });

    </script>
    <!--end::Page Scripts-->
@endsection
