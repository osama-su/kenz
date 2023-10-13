@extends('dashboard.layouts.master')
@section('styles')

@endsection
@section('page_header')
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.suppliers.index')}}" class="text-muted">المورد</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.suppliers.edit',['supplier'=>$supplier->id])}}"
               class="text-muted">تعديل</a>
        </li>
    </ul>
@endsection
@section('content')
    <form action="{{route('dashboard.suppliers.update',['supplier'=>$supplier->id])}}" method="post" enctype="multipart/form-data">
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
                            <div class="col-md-12">
                                <label style="float: right;">الاسم:
                                    <span class="text-danger">*</span></label>
                                <input name="name"
                                       value="{{$supplier->name??old("name")}}"
                                       class="form-control {{ $errors->has("name") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل الاسم"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("name") ? $errors->first("name") : null }}
                                    </span>
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
        </div>
    </form>
@endsection
@section('scripts')
    <script src="{{asset('assets/js/pages/crud/forms/widgets/tagify.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/pages/crud/forms/editors/summernote.js')}}"></script>
@endsection
