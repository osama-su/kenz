@extends('dashboard.layouts.master')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput-typeahead.css" integrity="sha512-wu4jn1tktzX0SHl5qNLDtx1uRPSj+pm9dDgqsrYUS16AqwzfdEmh1JR8IQL7h+phL/EAHpbBkISl5HXiZqxBlQ==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" />
    <style>
        .label.label-info {
            color: #FFFFFF;
            background-color: #6d90ea;
            width: fit-content;
            max-width: fit-content;
        }
        .label {
            padding: 10px;
            margin: 3px;
            display: -webkit-inline-box;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            height: 20px;
            width: 20px;
            border-radius: 0%;
            font-size: 0.8rem;
            background-color: #EBEDF3;
            color: #3F4254;
            font-weight: 400;
            height: 20px;
            width: 20px;
            font-size: 0.8rem;
        }
        .bootstrap-tagsinput input {
            border: none;
            box-shadow: none;
            outline: none;
            background-color: transparent;
            padding: 0 6px;
            margin: 0;
            width: 583px;
            max-width: inherit;
        }
    </style>
@endsection
@section('page_header')
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.products.index')}}" class="text-muted">المنتجات</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.products.edit',['product'=>$product->id])}}" class="text-muted">تعديل</a>
        </li>
    </ul>
@endsection
@section('content')

        <div class="row">
               <form action="{{route('dashboard.products.update',['product'=>$product->id])}}" method="post"
          enctype="multipart/form-data">
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
                                       value="{{$product->name??old("name")}}"
                                       class="form-control {{ $errors->has("name") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل الاسم"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("name") ? $errors->first("name") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;"> القيمة :
                                    <span class="text-danger">*</span></label>
                                <input  type="number" readonly
                                       value="{{ $product->inventory()->sum('qty')??old("qty") }}"
                                       class="form-control "
                                       placeholder="من فضلك الكمية"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                    </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label style="float: right;">الحجم :
                                    <span class="text-danger">*</span></label>
                                <input name="size"
                                       type="text"
                                       data-role="tagsinput"
                                       value="{{$product->size??old('size')}}"
                                       class="form-control {{ $errors->has("size") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل الحجم"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("size") ? $errors->first("size") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;">الموديل:
                                    <span class="text-danger">*</span></label>
                                <input name="model" type="text"
                                       data-role="tagsinput"
                                       value="{{ $product->model??old("model") }}"
                                       class="form-control {{ $errors->has("model") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل الموديل"/>
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
                                <input name="color"
                                       type="text"
                                       data-role="tagsinput"
                                       value="{{$product->color??old('color')}}"
                                       class="form-control {{ $errors->has("color") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل اللون"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("color") ? $errors->first("color") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;"> سعر الجملة :
                                    <span class="text-danger">*</span></label>
                                <input name="wholesale_price" type="number"
                                       value="{{$product->wholesale_price??old("wholesale_price") }}"
                                       class="form-control {{ $errors->has("wholesale_price") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل سعر الجملة"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("wholesale_price") ? $errors->first("wholesale_price") : null }}
                                    </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label style="float: right;"> السعر :
                                    <span class="text-danger">*</span></label>
                                <input name="price"
                                       type="number"
                                       value="{{$product->price??old('price')}}"
                                       class="form-control {{ $errors->has("price") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل  السعر"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("price") ? $errors->first("price") : null }}
                                    </span>
                            </div>
                            <div class="col-md-4">
                                <label style="float: right;"> الصورة :
                                    <span class="text-danger">*</span></label>
                                <input name="image" type="file"
                                       value="{{old("image") }}"
                                       class="form-control {{ $errors->has("image") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل الصورة"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("image") ? $errors->first("image") : null }}
                                    </span>
                            </div>
                            <div class="col-md-2">
                                @if($product->image)
                                    @if(Storage::disk('public')->exists($product->image))
                                        <img src="{{Storage::url($product->image)}}"
                                             style="width: 100px;height: 100px;">
                                    @else
                                        لا توجد صورة
                                    @endif
                                @else
                                    لا توجد صورة
                                @endif
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
                </form>


                        <div class="col-md-12">
            <div class="card card-custom gutter-b example example-compact card-body">
                               <form class=""
                          action="{{ route('dashboard.productInventories.store',['product'=>$product->id]) }}"
                          enctype="multipart/form-data"
                          method="POST">
                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <div class="form-group m-form__group">
                                        <label for="name" style="float: right;">الكمية :
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" value="{{old('qty') }}"
                                               class="form-control m-input {{ $errors->has('qty') ? 'is-invalid' : '' }}"
                                               id="qty" name="qty"
                                               aria-describedby="emailHelp" placeholder="من فضلك ادخل الكمية ">
                                        @if ($errors->has('qty'))
                                            <span class="m-form__help text-danger" style="float: right;">
                                        <strong>{{ $errors->first('qty') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! csrf_field() !!}
                    <div class="card-footer">

                        <button type="submit" class="btn btn-primary mr-2">حفظ</button>
                        <button type="reset" class="btn btn-secondary">الغاء</button>
                    </div>
                    </form>


                 <div class="card-body">
            <div class="mt-3">
                <table class="table table-separate table-head-custom table-checkable" id="kt_datatable1">
                    <thead>
                    <tr>
                                                <th>#</th>

                        <th>الكمية</th>
                        <th>الفاتورة رقم</th>
                        <th>التاريخ</th>


                    </tr>
                    </thead>
                    <tbody>
                        @if($product->qties->count())
                        @foreach($product->qties()->where('bill_id',null)->get() as $qty)
                        <tr id="row-{{ $qty->id }}">
                                                        <td>{{$qty->id??'-'}}</td>
                            <td>{{$qty->qty??'-'}}</td>

                            <td>{{$qty->bill_id??'-'}}</td>
                            <td>{{$qty->created_at??'-'}}</td>

                       </tr>
                       @endforeach
                       @endif
                    </tbody>
                </table>

            </div>

        </div>
        </div>

            </div>

        </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous"></script>

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
