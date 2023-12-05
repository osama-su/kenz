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
                <h3 class="card-label">الفواتير</h3>
            </div>
            <div class="card-toolbar">
                <!--begin::Button-->
                @can('create_bill')
                    <a href="{{route('dashboard.bills.create')}}" class="btn btn-primary font-weight-bolder">
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
                @endcan
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <form action="{{route('dashboard.bills.index')}}" method="get">
                <div class="row mt-3">
                    <div class="col-lg-6 mt-3">
                        <label style="float: right;">التاريخ من:</label>
                        <input type="date"
                               name="date_from"
                               value="{{Request()->date_from}}"
                               class="form-control created_at"
                               placeholder="من فضلك ادخل التاريخ من">
                    </div>
                    <div class="col-lg-6 mt-3">
                        <label style="float: right;">التاريخ الي:</label>
                        <input type="date"
                               name="date_to"
                               value="{{Request()->date_to}}"
                               class="form-control updated_at"
                               placeholder="من فضلك ادخل التاريخ الي">
                    </div>
                    <div class="col-lg-6 mt-3">
                        <label style="float: right;"> الموارد:</label>
                        <select name="supplier_id" class="form-control ">
                            <option value="">اختار</option>
                            @if($suppliers->count())
                                @foreach($suppliers as $supplier)
                                    <option
                                        value="{{$supplier->id}}" {{Request()->supplier_id==$supplier->id?'selected':null}}>{{$supplier->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label style="float: right;"> المحافظة:
                        </label>
                        <select id="gov" class="form-control" name="gov">
                            <option value="">اختار</option>
                            <option value="الغربية" {{Request()->gov=='الغربية'?'selected':null}}>الغربية</option>
                            <option value="الجيزة"{{Request()->gov=='الجيزة'?'selected':null}}>الجيزة</option>
                            <option value="الإسماعيلية"{{Request()->gov=='الإسماعيلية'?'selected':null}}>الإسماعيلية
                            </option>
                            <option value="كفر الشيخ"{{Request()->gov=='كفر الشيخ'?'selected':null}}>كفر الشيخ</option>
                            <option value="مطروح"{{Request()->gov=='مطروح'?'selected':null}}>مطروح</option>
                            <option value="المنيا"{{Request()->gov=='المنيا'?'selected':null}}>المنيا</option>
                            <option value="المنوفية"{{Request()->gov=='المنوفية'?'selected':null}}>المنوفية</option>
                            <option value="الوادي الجديد"{{Request()->gov=='الوادي الجديد'?'selected':null}}>الوادي
                                الجديد
                            </option>
                            <option value="شمال سيناء"{{Request()->gov=='شمال سيناء'?'selected':null}}>شمال سيناء
                            </option>
                            <option value="بورسعيد"{{Request()->gov=='بورسعيد'?'selected':null}}>بورسعيد</option>
                            <option value="القليوبية"{{Request()->gov=='القليوبية'?'selected':null}}>القليوبية</option>
                            <option value="قنا"{{Request()->gov=='قنا'?'selected':null}}>قنا</option>
                            <option value="البحر الأحمر"{{Request()->gov=='البحر الأحمر'?'selected':null}}>البحر
                                الأحمر
                            </option>
                            <option value="الشرقية"{{Request()->gov=='الشرقية'?'selected':null}}>الشرقية</option>
                            <option value="سوهاج"{{Request()->gov=='سوهاج'?'selected':null}}>سوهاج</option>
                            <option value="جنوب سيناء"{{Request()->gov=='جنوب سيناء'?'selected':null}}>جنوب سيناء
                            </option>
                            <option value="السويس"{{Request()->gov=='السويس'?'selected':null}}>السويس</option>
                            <option value="الأقصر"{{Request()->gov=='الأقصر'?'selected':null}}>الأقصر</option>
                            <option value="القاهرة"{{Request()->gov=='القاهرة'?'selected':null}}>القاهرة</option>
                            <option value="الإسكندرية"{{Request()->gov=='الإسكندرية'?'selected':null}}>الإسكندرية
                            </option>
                            <option value="الفيوم"{{Request()->gov=='الفيوم'?'selected':null}}>الفيوم</option>
                            <option value="أسوان"{{Request()->gov=='أسوان'?'selected':null}}>أسوان</option>
                            <option value="أسيوط"{{Request()->gov=='أسيوط'?'selected':null}}>أسيوط</option>
                            <option value="البحيرة"{{Request()->gov=='البحيرة'?'selected':null}}>البحيرة</option>
                            <option value="بني سويف"{{Request()->gov=='بني سويف'?'selected':null}}>بني سويف</option>
                            <option value="الدقهلية"{{Request()->gov=='الدقهلية'?'selected':null}}>الدقهلية</option>
                            <option value="دمياط"{{Request()->gov=='دمياط'?'selected':null}}>دمياط</option>
                        </select>
                        <span
                            class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("gov") ? $errors->first("gov") : null }}
                                    </span>
                    </div>
                    <div class="col-lg-6 mt-3">
                        <label style="float: right;"> المنتج :</label>
                        <select name="product_id" class="form-control ">
                            <option value="">اختار</option>
                            @if($products->count())
                                @foreach($products as $product)
                                    <option
                                        value="{{$product->id}}" {{Request()->product_id==$product->id?'selected':null}}> {{$product->name??'-'}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-6 mt-3">
                        <label style="float: right;"> المستخدم:</label>
                        <select name="created_by" class="form-control ">
                            <option value="">اختار</option>

                            @if($users->count())
                                @foreach($users as $user)
                                    <option
                                        value="{{$user->id}}" {{Request()->created_by==$user->id?'selected':null}}>{{$user->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-lg-6 mt-3">
                        <label style="float: right;"> حالة الطباعة:</label>
                        <select name="print" class="form-control ">
                            <option value="">الكل</option>
                            <option value="yes" {{Request()->print=='yes'?'selected':null}}>مطبوعة</option>
                            <option value="no" {{Request()->print=='no'?'selected':null}}>عير مطبوعة</option>
                        </select>
                    </div>
                    <div class="col-lg-12 mt-3">
                        {!! csrf_field() !!}
                        <button class="col-md-12 btn btn-primary" type="submit">بحث</button>
                    </div>
                </div>
            </form>
            <div class="mt-3">
                <form action="{{route('dashboard.generate_pdf')}}" method="post">


                    <table class="table table-separate table-head-custom table-checkable responsive" id="kt_datatable">
                        <thead>
                        <tr>
                                                        @can('print_bill')
                            <th>اختار</th>
                                                        @endcan
                            <th>#</th>
                            <th>اسم العميل</th>
                            <th>المحافظة</th>
                            <th>عنوان لعميل</th>
                            <th>رقم هاتف العميل</th>
                            <th>اسم المورد</th>
                            <th>اسم المنتج</th>
                            <th>الكمية</th>
                            <th>السعر</th>
                            <th>الشحن</th>
                            <th>اجمالي السعر</th>
                                                            @if(auth()->user()->role_id == 1)
                                                                <th>الربح</th>
                                                            @endif
                            <th>حالة الطبع</th>
                            <th>تاريخ الإنشاء</th>
                                                        @can('update_delivery')
                            <th>حالة التسليم الكلي</th>
                                                        @endcan
                            <th>حاله التسليم</th>
                            <th>الاحداث</th>
                        </tr>
                        </thead>
                    </table>

                    <div class="col-md-12 mt-5">
                        @include('dashboard.includes.company-modal',['action_message' => ''])
                    </div>
                </form>
                <form action="{{route('dashboard.all_pdf',['date_from'=>Request()->date_from,
'date_to'=>Request()->date_to,'gov'=>Request()->gov,'created_by'=>Request()->created_by,
'print'=>Request()->print,'product_id'=>Request()->product_id,])}}" method="post">
                    @include('dashboard.includes.all_company-modal',['action_message' => ''])
                </form>
                @can('print_bill')

                    <div class="row d-flex justify-content-between">
                        <a class="btn btn-primary col-md-12 mt-5 company-button"
                           data-toggle="modal"
                           data-target="#company_modal">
                            اطبع المحدد
                        </a>
                        <a class="btn btn-primary col-md-12 mt-5 company-button"
                           data-toggle="modal"
                           data-target="#company_modal">
                            تحميل شيت المحدد
                        </a>
                    </div>

                @endcan
            </div>
            <!--end: Datatable-->
        </div>
    </div>
    @include('dashboard.includes.trash-modal',['action_message' => ' هذه الفاتورة '])
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/delete-item.js') }}" type="text/javascript"></script>

    <!--begin::Page Vendors(used by this page)-->
    <script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
    <!--end::Page Vendors-->
    <!--begin::Page Scripts(used by this page)-->
    <script>
        // begin first table

        var array = [
            // {data: 'select', name: 'select', defaultContent: '-'},
            {data: 'id', name: 'id', defaultContent: '-'},
            {data: 'name', name: 'name', defaultContent: '-'},
            {data: 'gov', name: 'gov', defaultContent: '-'},
            {data: 'address', name: 'address', defaultContent: '-'},
            {data: 'mobile', name: 'mobile', defaultContent: '-'},
            {data: 'supplier', name: 'supplier', defaultContent: '-'},
            {data: 'product_name', name: 'product_name', defaultContent: '-'},
            {data: 'product_qty', name: 'product_qty', defaultContent: '-'},
            {data: 'price', name: 'price', defaultContent: '-'},
            {data: 'delivery_fee', name: 'delivery_fee', defaultContent: '-'},
            {data: 'price_after', name: 'price_after', defaultContent: '-'},
            @if(auth()->user()->role_id == 1)
            {data: 'profit', name: 'profit', defaultContent: '-'},
            @endif
            {data: 'print_status', name: 'print_status', defaultContent: '-'},
            {data: 'created_by', name: 'created_by', defaultContent: '-'},
            {data: 'select_return', name: 'select_return', defaultContent: '-'},
            {data: 'action', orderable: false, searchable: false, className: 'text-center'},

        ];

        @can('print_bill')
        var array = [
            {data: 'select', name: 'select', defaultContent: '-'},
            {data: 'id', name: 'id', defaultContent: '-'},
            {data: 'name', name: 'name', defaultContent: '-'},
            {data: 'gov', name: 'gov', defaultContent: '-'},
            {data: 'address', name: 'address', defaultContent: '-'},
            {data: 'mobile', name: 'mobile', defaultContent: '-'},
            {data: 'supplier', name: 'supplier', defaultContent: '-'},
            {data: 'product_name', name: 'product_name', defaultContent: '-'},
            {data: 'product_qty', name: 'product_qty', defaultContent: '-'},
            {data: 'price', name: 'price', defaultContent: '-'},
            {data: 'delivery_fee', name: 'delivery_fee', defaultContent: '-'},
            {data: 'price_after', name: 'price_after', defaultContent: '-'},
            @if(auth()->user()->role_id == 1)
            {data: 'profit', name: 'profit', defaultContent: '-'},
            @endif
            {data: 'print_status', name: 'print_status', defaultContent: '-'},
            {data: 'created_by', name: 'created_by', defaultContent: '-'},
            {data: 'select_return', name: 'select_return', defaultContent: '-'},
            {data: 'delivery_status', name: 'delivery_status', defaultContent: '-'},
            {data: 'action', orderable: false, searchable: false, className: 'text-center'},

        ];

        @endcan
        $('#kt_datatable thead tr').clone(true).appendTo('#kt_datatable thead');
        $('#kt_datatable thead tr:eq(1) th').each(function (i) {
            if (i === 1 || i === 2 || i === 5) {
                $(this).html('<input type="text" class="form-control" />');

                var title = $(this).text();
                $(this).html('<input type="text" class="col-md-12" />');

                $('input', this).on('keyup change', function () {
                    // console.log(table1.column(i).key());
                    if (table1.column(i).search() !== this.value) {
                        table1
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            } else {
                $(this).html('');
            }
        });
        var table1 = $('#kt_datatable').DataTable({
            serverSide: true,
            orderCellsTop: true,
            fixedHeader: true,
            language: {
                // url: "//cdn.datatables.net/plug-ins/1.11.3/i18n/ar.json",
            },
            processing: true,
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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 16]

                    }
                },
                'print',
                'copyHtml5', 'csvHtml5', 'pdfHtml5',],
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            order: [[0, "desc"]],
            ajax: {
                url: '{{ route('dashboard.bills.show',['date_from'=>Request()->date_from,'date_to'=>Request()->date_to,'supplier_id'=>Request()->supplier_id,'gov'=>Request()->gov,'product_id'=>Request()->product_id,'created_by'=>Request()->created_by,'print'=>Request()->print,]) }}',
                data: function (d) {
                    d.name = $('#name').val();
                    d.gov = $('#gov').val();
                    d.mobile = $('#mobile').val();
                    d.created_by = $('#created_by').val();
                    d.delivery_status = $('#delivery_status').val();
                    d.qty = $('#qty').val();
                    d.delivery_now_status = $('#delivery_now_status').val();
                    d.price_after = $('#price_after').val();
                }
            },
            columns: array, createdRow: function (row, data, index) {
                $(row).attr('id', 'row-' + data['id']);
            },
        });
        $('#name').on('keyup change', function () {
            $('#kt_datatable').DataTable().draw(true);
        });
        // $('#gov').on('keyup change', function () {
        //     $('#kt_datatable').DataTable().draw(true);
        // });
        // $('#created_by').on('keyup change', function () {
        //     $('#kt_datatable').DataTable().draw(true);
        // });
        // $('#delivery_status').on('keyup change', function () {
        //     $('#kt_datatable').DataTable().draw(true);
        // });
        // $('#qty').on('keyup change', function () {
        //     $('#kt_datatable').DataTable().draw(true);
        // });
        // $('#delivery_now_status').on('keyup change', function () {
        //     $('#kt_datatable').DataTable().draw(true);
        // });

        // $('#price_after').on('keyup change', function () {
        //     $('#kt_datatable').DataTable().draw(true);
        // });

        // $('#delivery_status_type').on('keyup change', function () {
        //     $('#kt_datatable').DataTable().draw(true);
        // });

        // $('.deliveryStatus').on('change', function () {
        //     $.post($(this).data('url'), {delivery_status: $(this).val()}, function (data, status) {
        //         location.reload();
        //     });
        // });
    </script>

    <!--end::Page Scripts-->
@endsection
