@extends('dashboard.layouts.master')
@section('page_vendors_styles')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('page_header')
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.bills.index')}}" class="text-muted">الفواتير</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="card card-custom">
        <div class="card-header py-3">
            <div class="card-title">
                <h3 class="card-label">التقاير</h3>
            </div>
            <div class="card-toolbar">
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <div>
                <div class="col-xl-12">
                    <!--begin::Stats Widget 7-->
                    <div class="card card-custom card-stretch gutter-b">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column p-0">
                            <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                <div class="d-flex flex-column mr-2">
                                    <a href="{{route('dashboard.users.index')}}"
                                       class="text-dark-75 text-hover-primary font-weight-bolder font-size-h5">الفواتير</a>
                                    <span class="text-muted font-weight-bold mt-2">عدد الفواتير</span>
                                </div>
                                <span class="symbol symbol-light-success symbol-45">
														<span
                                                            class="symbol-label font-weight-bolder font-size-h6">{{$bills->count()}}</span>
													</span>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Stats Widget 7-->
                </div>

            </div>
            <div class="mt-3">
                <form action="{{route('dashboard.reports.generate_pdf')}}" method="post">

                    <table class="table table-separate table-head-custom table-checkable" id="kt_datatable1">
                        <thead>
                        <tr>
                            <th>اختار</th>
                            <th>#</th>
                            <th>اسم العميل</th>
                            <th>المحافظة</th>
                            <!--<th>اسم</th>-->
                            <th>اسم المندوب</th>
                            <th>رقم هاتف المندوب</th>
                            <th>اسم المنتج</th>
                            <th>الكمية</th>
                            <th> السعر</th>
                            <th>الشحن</th>
                            <th>اجمالي السعر</th>
                            <th>الربح</th>
                            <th>حالة الطبع</th>
                            <th>تاريخ الانشاء</th>
                            <th>حاله التسليم</th>
                            <th>الاحداث</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bills as $bill)
                            <tr id="row-{{ $bill->id }}" class="

                            @if($bill->billDetails->count())
                            @foreach($bill->billDetails as $billDetail)
                            @if($billDetail->deleted_at!=null)
                             table-danger
                            @endif
                            @endforeach
                            @endif
                            ">
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" name="printer[]" type="checkbox"
                                               value="{{$bill->id}}"
                                               id="bill-{{$bill->id}}">
                                        <label class="form-check-label" for="bill-{{$bill->id}}">
                                        </label>
                                    </div>
                                </td>
                                <td>{{$bill->id??'-'}}</td>
                                <td>{{$bill->user->name??'-'}}</td>
                                <td>{{$bill->user->gov??'-'}}</td>
                                <!--<td>{{\App\Models\User::where('id',$bill->created_by)->first()->name??'-'}}</td>-->
                                <td>{{$bill->company->name??'-'}}</td>
                                <td>{{$bill->company->mobile??'-'}}</td>
                                <td>
                                    @if($bill->billDetails->count())
                                        @foreach($bill->billDetails as $bi)
                                            {{$bi->product->name??'-'}}<br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if($bill->billDetails->count())
                                        @foreach($bill->billDetails as $bi)
                                            {{$bi->qty??'-'}}<br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{$bill->price??'-'}}</td>
                                <td>{{$bill->delivery_fee??'-'}}</td>
                                <td>{{$bill->price_after??'-'}}</td>
                                <td>{{
    $bill->price_after-$bill->billDetails->map(function ($billDetails) {
                    return $billDetails->product ? $billDetails->product->wholesale_price * $billDetails->qty : 0;
                })->sum()-$bill->delivery_fee
    }}</td>
                                <td>@if($bill->print=='yes')
                                        نعم
                                    @else
                                        لا
                                    @endif
                                </td>
                                <td>{{ $bill->created_at ?? '-' }}</td>
                                <td>{{ $bill->delivery_status == 'yes' ? 'نعم' : 'لا' }}</td>
                                <td>
                                    @can('update_bill')
                                        <a href="{{route('dashboard.bills.edit', ['bill' => $bill->id])}}"
                                           class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                            <i class="la la-edit"></i>
                                        </a>
                                    @endcan
                                    @can('delete_bill')
                                        <a data-url="{{ route('dashboard.bills.destroy',['bill' => $bill->id]) }}"
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
                    <div class="col-md-12 mt-5">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-primary col-md-12">اطبع</button>
                    </div>
                </form>
            </div>
            <!--end: Datatable-->
        </div>
    </div>
    @include('dashboard.includes.delete-modal',['action_message' => 'هذا الفاتورة'])
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/delete-item.js') }}" type="text/javascript"></script>

    <!--begin::Page Vendors(used by this page)-->
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script>
        $(document).ready(function () {
            // $('#kt_datatable1 thead tr').clone(true).appendTo('#kt_datatable1 thead');
            // $('#kt_datatable1 thead tr:eq(1) th').each(function (i) {
            //     var title = $(this).text();
            //     $(this).html('<input type="text" class="col-md-6" />');
            //
            //     $('input', this).on('keyup change', function () {
            //         if (table.column(i).search() !== this.value) {
            //             table
            //                 .column(i)
            //                 .search(this.value)
            //                 .draw();
            //         }
            //     });
            // });
            var table = $('#kt_datatable1').DataTable({
                responsive: true,
                // Pagination settings
                dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
                select: {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                buttons: [
                    {
                        extend: 'excel',
                        title: 'الفواتير',
                        exportOptions: {
                            modifiers: {
                                selected: true
                            },
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]

                        }
                    },
                    'print',
                    'copyHtml5',
                    'csvHtml5',
                    'pdfHtml5',
                ], language: {
                    "sEmptyTable": "ليست هناك بيانات متاحة في الجدول",
                    "sLoadingRecords": "جارٍ التحميل...",
                    "print": "جارٍ التحميل...",
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
@endsection
