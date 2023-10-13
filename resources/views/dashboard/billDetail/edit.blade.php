@extends('dashboard.layouts.master')
@section('styles')
@endsection
@section('page_header')
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.bills.index')}}" class="text-muted">الفواتير</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.bills.create')}}" class="text-muted">تعديل</a>
        </li>
    </ul>
@endsection
@section('content')
    <form action="{{route('dashboard.billDetail.update',
['bill'=>$bill->id,'billDetail'=>$billDetail->id])}}"
          method="post" enctype="multipart/form-data">
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
                                <label style="float: right;">المنتج:
                                    <span class="text-danger">*</span></label>
                                <select name="product_id"
                                        class="form-control product_id {{ $errors->has("product_id") ? 'is-invalid' : '' }}">
                                    <option value="">اختار</option>
                                    @if($products->count())
                                        @foreach($products as $product)
                                            <option value="{{$product->id}}"
                                                {{$billDetail->product_id==$product->id?'selected':null}}>
                                                {{$product->name}}</option>
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
                                       value="{{$billDetail->qty?? old("qty") }}"
                                       class="form-control {{ $errors->has("qty") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك الكمية"/>
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
                    
                                    @if($billDetail->product->size)
                                        @foreach(explode(',',$billDetail->product->size) as $size)
                                            <option value="{{$size}}"
                                               @foreach(explode(',',$billDetail->size) as $value)
                                                {{$value==$size?'selected':null}}
                                                 @endforeach>
                                                {{$size}}</option>
                                        @endforeach
                                    @endif
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
                                    @if($billDetail->product->model)
                                        @foreach(explode(',',$billDetail->product->model) as $model)
                                            <option value="{{$model}}"
                                             @foreach(explode(',',$billDetail->model) as $value)
                                                {{$value==$model?'selected':null}}
                                                    @endforeach>
                                                {{$model}}</option>
                                        @endforeach
                                    @endif
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
                                    @if($billDetail->product->color)
                                        @foreach(explode(',',$billDetail->product->color) as $color)
                                            <option value="{{$color}}"
                                             @foreach(explode(',',$billDetail->color) as $value)
                                             {{$value==$color?'selected':null}}
                                               @endforeach
                                             >
                                                {{$color}}</option>
                                        @endforeach
                                    @endif
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
                                       value="{{$billDetail->price?? old("price") }}"
                                       class="form-control price {{ $errors->has("price") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك السعر"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("price") ? $errors->first("price") : null }}
                                    </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label style="float: right;"> حالة التسليم :
                                    <span class="text-danger">*</span></label>
                                <select name="delivery_status"
                                        class="form-control {{ $errors->has("delivery_status") ? 'is-invalid' : '' }}">
                                    <option value="">اختار</option>
                                    <option value="yes" {{$billDetail->delivery_status=='yes'?'selected':null}}>نعم
                                    </option>
                                    <option value="no" {{$billDetail->delivery_status=='no'?'selected':null}}>لا
                                    </option>
                                </select>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("delivery_status") ? $errors->first("delivery_status") : null }}
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
    <!--end::Page Scripts-->
@endsection
