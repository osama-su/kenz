@extends('dashboard.layouts.master')
@section('page_vendors_styles')
    <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('page_header')
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.deliveries.index')}}" class="text-muted">التسليمات و المرتجعات</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="card card-custom">
        <div class="card-header py-3">
            <div class="card-title">
                <h3 class="card-label">التسليمات و المرتجعات</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
            {{--                @can('create_delivery')--}}
            {{--                    <a href="{{route('dashboard.deliveries.create')}}" class="btn btn-primary font-weight-bolder">--}}
            {{--											<span class="svg-icon svg-icon-md">--}}
            {{--												<!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->--}}
            {{--												<svg xmlns="http://www.w3.org/2000/svg"--}}
            {{--                                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"--}}
            {{--                                                     height="24px" viewBox="0 0 24 24" version="1.1">--}}
            {{--													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">--}}
            {{--														<rect x="0" y="0" width="24" height="24"/>--}}
            {{--														<circle fill="#000000" cx="9" cy="15" r="6"/>--}}
            {{--														<path--}}
            {{--                                                            d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"--}}
            {{--                                                            fill="#000000" opacity="0.3"/>--}}
            {{--													</g>--}}
            {{--												</svg>--}}
            {{--                                                <!--end::Svg Icon-->--}}
            {{--											</span>اضافة جديد </a>--}}
            {{--            @endcan--}}
            <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <div class="row mt-1">
                <div class="col-md-3 mt-1">
                    <label style="float: right;">اسم العميل:
                    </label>
                    <input name="name" id="name"
                           value="{{old("name")}}"
                           class="form-control "
                    />

                </div>
                <div class="col-md-3 mt-1">
                    <label style="float: right;">المحافظة:
                    </label>
                    <input name="gov" id="gov"
                           value="{{old("gov")}}"
                           class="form-control "
                    />

                </div>
                <div class="col-md-3 mt-1">
                    <label style="float: right;">اسم المورد:
                    </label>
                    <input name="created_by" id="created_by"
                           value="{{old("created_by")}}"
                           class="form-control "
                    />

                </div>
                <div class="col-md-3 mt-1">
                    <label style="float: right;">اسم المنتج:
                    </label>
                    <input name="delivery_status" id="delivery_status"
                           value="{{old("delivery_status")}}"
                           class="form-control "
                    />

                </div>
                <div class="col-md-3 mt-1">
                    <label style="float: right;">الكمية:
                    </label>
                    <input name="qty" id="qty"
                           value="{{old("qty")}}"
                           class="form-control "
                    />

                </div>
                <div class="col-md-3 mt-1">
                    <label style="float: right;">الحالة:
                    </label>
                    <select name="delivery_now_status" id="delivery_now_status"
                            class="form-control ">
                        <option value="">اختار</option>
                        <option value="مرتجع">مرتجع</option>
                        <option value="تسليم">تسليم</option>
                    </select>

                </div>
                <div class="col-md-3 mt-1">
                    <label style="float: right;">السعر:
                    </label>
                    <input name="price_after" id="price_after"
                           value="{{old("price_after")}}"
                           class="form-control "
                    />

                </div>
                <div class="col-md-3 mt-1">
                    <label style="float: right;">النوع:
                    </label>
                    <select name="delivery_status_type" id="delivery_status_type"
                            class="form-control ">
                        <option value="">اختار</option>
                        <option value="كلي">كلي</option>
                        <option value="جزئي">جزئي</option>
                    </select>

                </div>

            </div>

            <div class="mt-3">
                <table class="table table-separate table-head-custom table-checkable responsive" id="kt_datatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>كيو ار</th>
                        <th>اسم العميل</th>
                        <th>المحافظة</th>
                        <th>اسم المورد</th>
                        <th>اسم المنتج</th>
                        <th>الكمية</th>
                        <th>الحالة</th>
                        <th>اجمالي السعر</th>
                        <th>النوع</th>
                        @can('update_delivery')
                            <th>حالة التسليم الكلي</th>
                        @endcan
                        <th>الاحداث</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <!--end: Datatable-->
        </div>
    </div>
    @include('dashboard.includes.delete-modal',['action_message' => 'هذا الفاتورة'])
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/delete-item.js') }}" type="text/javascript"></script>

    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>

    <script>
        // begin first table
        var table1 = $('#kt_datatable').DataTable({
            serverSide: true,
            orderCellsTop: true,
            fixedHeader: true,
            language: {
                @if(App::getLocale()=='ar')
                url: "//cdn.datatables.net/plug-ins/1.11.3/i18n/ar.json",
                @else
                url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/English.json",
                @endif
            },
            processing: true,
            dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
                      <'row'<'col-sm-12'tr>>
                      <'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            buttons: ['print', 'copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5',],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            order: [[0, "desc"]],
            ajax: {
                url: '{{ route('dashboard.deliveries.bill.show') }}',
                data: function (d) {
                    d.name = $('#name').val();
                    d.gov = $('#gov').val();
                    d.created_by = $('#created_by').val();
                    d.delivery_status = $('#delivery_status').val();
                    d.qty = $('#qty').val();
                    d.delivery_now_status = $('#delivery_now_status').val();
                    d.price_after = $('#price_after').val();
                    d.delivery_status_type = $('#delivery_status_type').val();
                }

            },
            columns: [
                {data: 'id', name: 'id', defaultContent: '-'},
                {data: 'qr', name: 'qr', defaultContent: '-'},
                {data: 'name', name: 'name', defaultContent: '-'},
                {data: 'gov', name: 'gov', defaultContent: '-'},
                {data: 'created_by', name: 'created_by', defaultContent: '-'},
                {data: 'delivery_status', name: 'delivery_status', defaultContent: '-'},
                {data: 'qty', name: 'qty', defaultContent: '-'},
                {data: 'delivery_now_status', name: 'delivery_now_status', defaultContent: '-'},
                {data: 'price_after', name: 'price_after', defaultContent: '-'},
                {data: 'delivery_status_type', name: 'delivery_status_type', defaultContent: '-'},
                {data: 'select', name: 'select', defaultContent: '-'},
                {data: 'action', orderable: false, searchable: false, className: 'text-center'}

            ], createdRow: function (row, data, index) {
                $(row).attr('id', 'row-' + data['id']);
            },
        });
        $('#name').on('keyup change', function () {
            $('#kt_datatable').DataTable().draw(true);
        });
        $('#gov').on('keyup change', function () {
            $('#kt_datatable').DataTable().draw(true);
        });
        $('#created_by').on('keyup change', function () {
            $('#kt_datatable').DataTable().draw(true);
        });
        $('#delivery_status').on('keyup change', function () {
            $('#kt_datatable').DataTable().draw(true);
        });
        $('#qty').on('keyup change', function () {
            $('#kt_datatable').DataTable().draw(true);
        });
        $('#delivery_now_status').on('keyup change', function () {
            $('#kt_datatable').DataTable().draw(true);
        });

        $('#price_after').on('keyup change', function () {
            $('#kt_datatable').DataTable().draw(true);
        });

        $('#delivery_status_type').on('keyup change', function () {
            $('#kt_datatable').DataTable().draw(true);
        });

        $('.deliveryStatus').on('change', function () {
            $.post($(this).data('url'), {delivery_status: $(this).val()}, function (data, status) {
                location.reload();
            });
        });
    </script>

@endsection
