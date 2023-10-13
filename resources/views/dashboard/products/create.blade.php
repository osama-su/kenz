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
            <a href="{{route('dashboard.products.create')}}" class="text-muted">انشاء جديد</a>
        </li>
    </ul>
@endsection
@section('content')
    <form action="{{route('dashboard.products.store')}}" method="post" enctype="multipart/form-data">
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
                                <input name="size"
                                       type="text"
                                       value="{{old('size')}}"
                                       data-role="tagsinput"
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
                                       value="{{ old("model") }}"
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
                                       value="{{old('color')}}"
                                       class="form-control {{ $errors->has("color") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل اللون"
                                       data-role="tagsinput"
                                />
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("color") ? $errors->first("color") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;"> سعر الجملة :
                                    <span class="text-danger">*</span></label>
                                <input name="wholesale_price" type="number"
                                       value="{{old("wholesale_price") }}"
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
                                       value="{{old('price')}}"
                                       class="form-control {{ $errors->has("price") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل  السعر"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("mobile") ? $errors->first("mobile") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous"></script>
@endsection
