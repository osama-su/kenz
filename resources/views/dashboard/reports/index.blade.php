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
            <form action="{{route('dashboard.reports.show')}}" method="get">
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
                                        <div class="col-lg-6 mt-3">
                        <label style="float: right;"> المستخدم:</label>
                        <select name="created_by" class="form-control ">
                            <option value="">اختار</option>

                            @if($users->count())
                                @foreach($allUsers as $user)
                                    <option
                                        value="{{$user->id}}" {{Request()->created_by==$user->id?'selected':null}}>{{$user->name}}</option>
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
                        <label style="float: right;"> حالة الطباعة:</label>
                        <select name="print" class="form-control ">
                            <option value="">الكل</option>
                            <option value="yes" {{Request()->print=='yes'?'selected':null}}>مطبوعة</option>
                            <option value="no" {{Request()->print=='no'?'selected':null}}>عير مطبوعة</option>
                        </select>
                    </div>
                    <div class="col-lg-6 mt-3">
                        <label style="float: right;"> حالة التسليم:</label>
                        <select name="delivery_status" class="form-control ">
                            <option value="">اختار</option>
                            <option value="yes" {{Request()->delivery_status=='yes'?'selected':null}}>تم التسليم
                            </option>
                            <option value="no" {{Request()->delivery_status=='no'?'selected':null}}> مرتجع</option>
                             <option value="cancel" {{Request()->delivery_status=='cancel'?'selected':null}}> الغاء</option>
                        </select>
                    </div>
                    <div class="col-lg-6 mt-3">
                        <label style="float: right;"> المندوب:</label>
                        <select name="company_id" class="form-control ">
                            <option value="">اختار</option>
                            @if($companies->count())
                                @foreach($companies as $company)
                                    <option value="{{$company->id}}">{{$company->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-6 mt-3">
                        <label style="float: right;"> العميل:</label>
                        <select name="user_m" class="form-control selectpicker" data-live-search="true">
                            <option value="">اختار</option>
                            @if($users->count())
                                @foreach($users_m as $user_m)
                                    <option value="{{$user_m->id}}">{{$user_m->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-12 mt-3">
                        {!! csrf_field() !!}
                        <button class="col-md-12 btn btn-primary" type="submit">بحث</button>
                    </div>
                </div>
            </form>
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
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 16]

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
