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
            <a href="{{route('dashboard.expenses.index')}}" class="text-muted">المصروفات</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.expenses.create')}}" class="text-muted">انشاء جديد</a>
        </li>
    </ul>
@endsection
@section('content')
    <form action="{{route('dashboard.expenses.store')}}" method="post" enctype="multipart/form-data">
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
                                <label style="float: right;">اسم المصروف:
                                    <span class="text-danger">*</span></label>
                                <input name="title"
                                       value="{{old("title")}}"
                                       class="form-control {{ $errors->has("title") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل الاسم"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("title") ? $errors->first("title") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;"> الكمية :
                                    <span class="text-danger">*</span></label>
                                <input name="amount" type="number"
                                       value="{{ old("amount") }}"
                                       class="form-control {{ $errors->has("amount") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك الكمية"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("amount") ? $errors->first("amount") : null }}
                                    </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label style="float: right;">اسم الصارف:
                                    <span class="text-danger">*</span></label>
                                <input name="created_by"
                                       value="{{old("created_by")}}"
                                       class="form-control {{ $errors->has("created_by") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل الاسم"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("created_by") ? $errors->first("created_by") : null }}
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
