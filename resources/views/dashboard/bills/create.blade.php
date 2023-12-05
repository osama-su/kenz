@extends('dashboard.layouts.master')
@section('styles')
@endsection
@section('page_header')
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.bills.index')}}" class="text-muted">الفواتير</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.bills.create')}}" class="text-muted">انشاء جديد</a>
        </li>
    </ul>
@endsection
@section('content')
    <form action="{{route('dashboard.bills.store')}}" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">انشاء جديد</h3>

                    </div>
                    <!--begin::Form-->
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label style="float: right;">الاسم:
                                    <span class="text-danger">*</span></label>
                                <input name="name"
                                       value="{{old("name")}}"
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
                                       value="{{ old("email") }}"
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
                                <label style="float: right;"> العنوان :
                                    <span class="text-danger">*</span></label>
                                <input name="address" type="text"
                                       value="{{ old("address") }}"
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
                                       value="{{old('mobile')}}"
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
                                       value="{{old("notes") }}"
                                       class="form-control {{ $errors->has("notes") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل الملاحظات"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("notes") ? $errors->first("notes") : null }}
                                    </span>
                            </div>
                        </div>
                    </div>
                    <!--end::Form-->
                </div>
{{--                <div class="card card-custom gutter-b example example-compact">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="form-group row">--}}
{{--                            <div class="col-md-12">--}}
{{--                                <label style="float: right;">المندوب:--}}
{{--                                    <span class="text-danger">*</span></label>--}}
{{--                                <select name="company_id"--}}
{{--                                        class="form-control company_id {{ $errors->has("company_id") ? 'is-invalid' : '' }}">--}}
{{--                                    <option value="">اختار</option>--}}
{{--                                    @if($companies->count())--}}
{{--                                        @foreach($companies as $company)--}}
{{--                                            <option value="{{$company->id}}">{{$company->name}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    @endif--}}
{{--                                </select>--}}
{{--                                <span--}}
{{--                                    class="form-text text-danger" style="float: right;">--}}
{{--                                        {{ $errors->has("company_id") ? $errors->first("company_id") : null }}--}}
{{--                                    </span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label style="float: right;">المورد:
                                    <span class="text-danger">*</span></label>
                                <select name="supplier_id"
                                        class="form-control created_by {{ $errors->has("supplier_id") ? 'is-invalid' : '' }}">
                                    <option value="">اختار</option>
                                    @if($users->count())
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("supplier_id") ? $errors->first("supplier_id") : null }}
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-custom gutter-b example example-compact">
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
                                <select name="size[]"  multiple
                                        class="form-control size  {{ $errors->has("size") ? 'is-invalid' : '' }}">
                                </select>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("size") ? $errors->first("size") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;">الموديل:
                                    <span class="text-danger">*</span></label>
                                <select name="model[]"  multiple
                                        class="form-control model  {{ $errors->has("model") ? 'is-invalid' : '' }}">
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
                                        class="form-control color  {{ $errors->has("color") ? 'is-invalid' : '' }}">
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
                                       placeholder="من فضلك السعر"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("price") ? $errors->first("price") : null }}
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        {!! csrf_field() !!}
                        <button type="submit" id="btnSubmit" class="btn btn-primary mr-2">حفظ</button>
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

$("form").submit(function(){

$("#btnSubmit").attr("disabled", true);

});
    </script>
@endsection
