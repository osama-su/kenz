@extends('dashboard.layouts.master')
@section('styles')
@endsection
@section('page_header')
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.deliveries.index')}}" class="text-muted">الفواتير</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.bills.create')}}" class="text-muted">تعديل</a>
        </li>
    </ul>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12">
            <!--begin::Card-->
            <form action="{{route('dashboard.deliveries.userUpdate', ['delivery' => $delivery->id])}}" method="post">
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">العميل</h3>

                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label style="float: right;">الاسم:
                                <span class="text-danger">*</span></label>
                            <input name="name"
                                   value="{{$delivery->user->name??old("name")}}"
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
                            <input name="email" type="text"
                                   value="{{$delivery->user->email?? old("email") }}"
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
                            <label style="float: right;"> المحافظة:
                                <span class="text-danger">*</span></label>
                            <input name="gov"
                                   type="text"
                                   value="{{$delivery->user->gov??old('gov')}}"
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
                                   value="{{$delivery->user->address??old("address") }}"
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
                                   value="{{$delivery->user->mobile??old('mobile')}}"
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
                                   value="{{$delivery->note??old("notes") }}"
                                   class="form-control {{ $errors->has("notes") ? 'is-invalid' : '' }}"
                                   placeholder="من فضلك ادخل الملاحظات"/>
                            <span
                                class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("notes") ? $errors->first("notes") : null }}
                                    </span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-primary mr-2">حفظ</button>
                    <button type="reset" class="btn btn-secondary">الغاء</button>
                </div>
            </div>
            </form>
        </div>

        {{--        <div class="col-md-12">--}}
        {{--            <!--begin::Card-->--}}

        {{--            <div class="card card-custom gutter-b example example-compact">--}}
        {{--                <div class="card-header">--}}
        {{--                    <h3 class="card-title">المندوب</h3>--}}
        {{--                </div>--}}
        {{--                <div class="card-body">--}}
        {{--                    <div class="form-group row">--}}
        {{--                        <div class="col-md-6">--}}
        {{--                            <label style="float: right;"> الاسم :--}}
        {{--                                <span class="text-danger">*</span></label>--}}
        {{--                            <input readonly--}}
        {{--                                   value="{{$delivery->company->name??'-'}}"--}}
        {{--                                   class="form-control"--}}
        {{--                                   placeholder="من فضلك ادخل الاسم"/>--}}
        {{--                            <input type="hidden" name="company_id"--}}
        {{--                                   value="{{$delivery->company->id??'-'}}"--}}
        {{--                                   class="form-control"--}}
        {{--                                   placeholder="من فضلك ادخل "/>--}}
        {{--                            <span--}}
        {{--                                class="form-text text-danger" style="float: right;">--}}
        {{--                                    </span>--}}
        {{--                        </div>--}}
        {{--                        <div class="col-md-6">--}}
        {{--                            <label style="float: right;"> رقم الهاتف :--}}
        {{--                                <span class="text-danger">*</span></label>--}}
        {{--                            <input readonly--}}
        {{--                                   value="{{$delivery->company->mobile??'-'}}"--}}
        {{--                                   class="form-control"--}}
        {{--                                   placeholder="من فضلك ادخل رقم الهاتف"/>--}}
        {{--                            <span--}}
        {{--                                class="form-text text-danger" style="float: right;">--}}
        {{--                                    </span>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <div class="col-md-12">
            <!--begin::Card-->

            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title">المورد</h3>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label style="float: right;"> الاسم :
                                <span class="text-danger">*</span></label>
                            <input readonly
                                   value="{{$delivery->user->name??'-'}}"
                                   class="form-control"
                                   placeholder="من فضلك ادخل الاسم"/>
                            <span
                                class="form-text text-danger" style="float: right;">
                                    </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <!--begin::Card-->
               <form action="{{route('dashboard.deliveries.billDetail.store',['delivery'=>$delivery->id])}}" method="post"
                  enctype="multipart/form-data">
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">اضافة منتج الي الفاتورة</h3>

                    </div>
                    <!--begin::Form-->
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label style="float: right;">المنتج:
                                    <span class="text-danger">*</span></label>
                                <select name="product_id"
                                        class="form-control product_id {{ $errors->has("product_id") ? 'is-invalid' : '' }}">
                                    <option value="">اختار</option>
                                    @if($products->count())
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("product_id") ? $errors->first("product_id") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;"> الكمية :
                                    <span class="text-danger">*</span></label>
                                <input name="qty" type="number"
                                       value="{{ old("qty") }}"
                                       class="form-control {{ $errors->has("qty") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل الكمية"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("qty") ? $errors->first("qty") : null }}
                                    </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label style="float: right;">الحجم :
                                    <span class="text-danger">*</span></label>
                                <select name="size[]" multiple
                                        class="form-control size {{ $errors->has("size") ? 'is-invalid' : '' }}">
                                </select>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("size") ? $errors->first("size") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;">الموديل:
                                    <span class="text-danger">*</span></label>
                                <select name="model[]" multiple
                                        class="form-control model {{ $errors->has("model") ? 'is-invalid' : '' }}">
                                </select>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("model") ? $errors->first("model") : null }}
                                    </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label style="float: right;"> اللون:
                                    <span class="text-danger">*</span></label>
                                <select name="color[]" multiple
                                        class="form-control color {{ $errors->has("color") ? 'is-invalid' : '' }}">
                                </select>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("color") ? $errors->first("color") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;"> السعر :
                                    <span class="text-danger">*</span></label>
                                <input name="price" type="number"
                                       value="{{ old("price") }}"
                                       class="form-control price {{ $errors->has("price") ? 'is-invalid' : '' }}"
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
            </form>
        </div>

        <div class="col-md-12">
            <!--begin::Card-->
                <form action="{{route('dashboard.deliveries.storePrice',['delivery'=>$delivery->id])}}" method="post"
                  enctype="multipart/form-data">
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">معلومات الفاتورة</h3>

                    </div>
                    <!--begin::Form-->
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label style="float: right;"> السعر :
                                    <span class="text-danger">*</span></label>
                                <input name="price" type="number"
                                       value="{{$delivery->price?? old("price") }}"
                                       class="form-control  {{ $errors->has("price") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل السعر"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("price") ? $errors->first("price") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;"> قيمة الخصم :
                                    <span class="text-danger">*</span></label>
                                <input name="discount_percentage" type="number"
                                       value="{{ $delivery->discount_percentage?? old("discount_percentage") }}"
                                       class="form-control {{ $errors->has("discount_percentage") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل قيمة الخصم"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("discount_percentage") ? $errors->first("discount_percentage") : null }}
                                    </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label style="float: right;"> مصاريف الشحن :
                                    <span class="text-danger">*</span></label>
                                <input name="delivery_fee" type="number"
                                       value="{{ $delivery->company?($delivery->company->gov()->where('gov','like','%%'.$delivery->user->gov.'%%')->first()->price??0):$delivery->delivery_fee}}"
                                       class="form-control {{ $errors->has("delivery_fee") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل مصاريف الشحن "/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("delivery_fee") ? $errors->first("delivery_fee") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;"> السعر الاجمالي:
                                    <span class="text-danger">*</span></label>
                                <input name="price_after" type="number" readonly
                                       value="{{$delivery->price_after?? old("price_after") }}"
                                       class="form-control  {{ $errors->has("price_after") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل السعر"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("price") ? $errors->first("price") : null }}
                                    </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label style="float: right;"> حالة التسليم الكلي :
                                    <span class="text-danger">*</span></label>
                                <select name="delivery_status"
                                        class="form-control {{ $errors->has("delivery_status") ? 'is-invalid' : '' }}">
                                    <option value="">اختار</option>
                                    <option value="yes" {{$delivery->delivery_status=='yes'?'selected':null}}>نعم</option>
                                    <option value="no" {{$delivery->delivery_status=='no'?'selected':null}}>لا</option>
                                </select>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("delivery_status") ? $errors->first("delivery_status") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;"> نوع التسليم :
                                    <span class="text-danger">*</span></label>
                                <select name="delivery_receive"
                                        class="form-control delivery_receive {{ $errors->has("delivery_status") ? 'is-invalid' : '' }}">
                                    <option value="">اختار</option>
                                    <option value="now" {{$delivery->delivery_receive=='now'?'selected':null}}>فوري</option>
                                    <option value="later" {{$delivery->delivery_receive=='later'?'selected':null}}>مؤاجل
                                    </option>
                                </select>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("delivery_status") ? $errors->first("delivery_status") : null }}
                                    </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 date_receive_div @if($delivery->delivery_receive!='later') d-none @endif">
                                <label style="float: right;">تاريخ التسليم:
                                    <span class="text-danger">*</span></label>
                                <input name="date_receive" type="date"
                                       value="{{$delivery->date_receive??old('date_receive')}}"
                                       class="form-control date_receive {{ $errors->has("date_receive") ? 'is-invalid' : '' }}">
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("date_receive") ? $errors->first("date_receive") : null }}
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
            </form>
            <!--end::Card-->
        </div>

        <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-body">

                                 <table class="table table-separate table-head-custom table-checkable" id="kt_datatable1">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>المنتج</th>
                            <th>اللون</th>
                            <th>الحجم</th>
                            <th>الموديل</th>
                            <th>السعر</th>
                            <th>الكمية</th>
                            <th>تاريخ الإنشاء </th>
                            <th>الاحداث</th>
                        </tr>
                        </thead>
                        <tbody class="">
                           @foreach($delivery->billDetails()->withTrashed()->get() as $deliveryDetail)
                            <tr id="row-{{ $deliveryDetail->id }}"
                                class=" @if($deliveryDetail->deleted_at!=null)table-danger @endif">
                                <td>{{$deliveryDetail->id??'-'}}</td>
                                <td>{{$deliveryDetail->product->name??'-'}}</td>
                                <td>{{$deliveryDetail->color??'-'}}</td>
                                <td>{{$deliveryDetail->size??'-'}}</td>
                                <td>{{$deliveryDetail->model??'-'}}</td>
                                <td>{{$deliveryDetail->price??'-'}}</td>
                                <td>{{$deliveryDetail->qty??'-'}}</td>
                                <td>{{ $deliveryDetail->created_at ?? '-' }}</td>

                                                                <td>
                                    @can('update_bill')
                                        @if($deliveryDetail->deleted_at==null)
                                            <a href="{{route('dashboard.deliveries.billDetail.edit', ['delivery' => $delivery->id,'billDetail'=>$deliveryDetail->id])}}"
                                               class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                                <i class="la la-edit"></i>
                                            </a>
                                        @endif
                                    @endcan
                                    @can('delete_bill')
                                        @if($deliveryDetail->deleted_at==null)
                                            <a data-url="{{ route('dashboard.deliveries.billDetail.destroy', ['delivery' => $delivery->id,'billDetail'=>$deliveryDetail->id]) }}"
                                               data-item-id="{{ $deliveryDetail->id }}"
                                               class="btn btn-sm btn-clean btn-icon btn-icon-md delete-button"
                                               data-toggle="modal"
                                               data-target="#delete_modal">
                                                <i class="la la-trash"></i>
                                            </a>
                                        @endif
                                    @endcan
                                </td>
                                </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!--end::Card-->
        </div>
    </div>
    @include('dashboard.includes.delete-modal',['action_message' => 'هذا المنتج'])

@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"
            integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g=="
            crossorigin="anonymous"></script>
    <script>
        $('.product_id').on('click', function () {
            $.get("{{route('dashboard.single_product_size')}}", {id: $(this).val()}, function (data) {
                $('.size').replaceWith(data)
            });
            $.get("{{route('dashboard.single_product_price')}}", {id: $(this).val()}, function (data) {
                $('.price').replaceWith(data)
            });
            $.get("{{route('dashboard.single_product_color')}}", {id: $(this).val()}, function (data) {
                $('.color').replaceWith(data)
            });
            $.get("{{route('dashboard.single_product_model')}}", {id: $(this).val()}, function (data) {
                $('.model').replaceWith(data)
            });
        });
    </script>

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
    <script>
        $('.delivery_receive').on('change', function () {
            if ($('.delivery_receive').val() == 'later') {
                $('.date_receive_div').removeClass('d-none');
                $('.date_receive').val('');
            } else {
                $('.date_receive_div').addClass('d-none');
                $('.date_receive').val('');
            }
        });
    </script>
    <!--end::Page Scripts-->
@endsection
