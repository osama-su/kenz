@extends('dashboard.layouts.master')
@section('styles')

@endsection
@section('page_header')
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.companies.index')}}" class="text-muted">المحافظة</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.companies.edit',['company'=>$company->id])}}" class="text-muted">تعديل</a>
        </li>
    </ul>
@endsection
@section('content')
    <form action="{{route('dashboard.companyGovs.update',['company'=>$company->id,'companyGov'=>$companyGov->id])}}"
          method="post"
          enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">المحافظة</h3>

                    </div>
                    <!--begin::Form-->
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label style="float: right;"> المحافظة:
                                    <span class="text-danger">*</span></label>
                                <select id="gov" class="form-control" name="gov">
                                    <option value="">اختار</option>
                                    <option {{$companyGov->gov=='الغربية'?'selected':null}} value="الغربية">الغربية
                                    </option>
                                    <option {{$companyGov->gov=='الجيزة'?'selected':null}}  value="الجيزة">الجيزة
                                    </option>
                                    <option {{$companyGov->gov=='الإسماعيلية'?'selected':null}}  value="الإسماعيلية">
                                        الإسماعيلية
                                    </option>
                                    <option {{$companyGov->gov=='كفر الشيخ'?'selected':null}} value="كفر الشيخ">كفر
                                        الشيخ
                                    </option>
                                    <option {{$companyGov->gov=='مطروح'?'selected':null}} value="مطروح">مطروح</option>
                                    <option {{$companyGov->gov=='المنيا'?'selected':null}} value="المنيا">المنيا
                                    </option>
                                    <option {{$companyGov->gov=='المنوفية'?'selected':null}} value="المنوفية">المنوفية
                                    </option>
                                    <option {{$companyGov->gov=='الوادي الجديد'?'selected':null}} value="الوادي الجديد">
                                        الوادي
                                        الجديد
                                    </option>
                                    <option {{$companyGov->gov=='شمال سيناء'?'selected':null}} value="شمال سيناء">شمال
                                        سيناء
                                    </option>
                                    <option {{$companyGov->gov=='بورسعيد'?'selected':null}} value="بورسعيد">بورسعيد
                                    </option>
                                    <option {{$companyGov->gov=='القليوبية'?'selected':null}} value="القليوبية">
                                        القليوبية
                                    </option>
                                    <option {{$companyGov->gov=='قنا'?'selected':null}} value="قنا">قنا</option>
                                    <option {{$companyGov->gov=='البحر الأحمر'?'selected':null}} value="البحر الأحمر">
                                        البحر
                                        الأحمر
                                    </option>
                                    <option {{$companyGov->gov=='الشرقية'?'selected':null}} value="الشرقية">الشرقية
                                    </option>
                                    <option {{$companyGov->gov=='سوهاج'?'selected':null}} value="سوهاج">سوهاج</option>
                                    <option {{$companyGov->gov=='جنوب سيناء'?'selected':null}} value="جنوب سيناء">جنوب
                                        سيناء
                                    </option>
                                    <option {{$companyGov->gov=='السويس'?'selected':null}} value="السويس">السويس
                                    </option>
                                    <option {{$companyGov->gov=='الأقصر'?'selected':null}} value="الأقصر">الأقصر
                                    </option>
                                    <option {{$companyGov->gov=='القاهرة'?'selected':null}} value="القاهرة">القاهرة
                                    </option>
                                    <option {{$companyGov->gov=='الإسكندرية'?'selected':null}} value="الإسكندرية">
                                        الإسكندرية
                                    </option>
                                    <option {{$companyGov->gov=='الفيوم'?'selected':null}}  value="الفيوم">الفيوم
                                    </option>
                                    <option {{$companyGov->gov=='أسوان'?'selected':null}} value="أسوان">أسوان</option>
                                    <option {{$companyGov->gov=='أسيوط'?'selected':null}} value="أسيوط">أسيوط</option>
                                    <option {{$companyGov->gov=='البحيرة'?'selected':null}} value="البحيرة">البحيرة
                                    </option>
                                    <option {{$companyGov->gov=='بني سويف'?'selected':null}} value="بني سويف">بني سويف
                                    </option>
                                    <option {{$companyGov->gov=='الدقهلية'?'selected':null}}  value="الدقهلية">الدقهلية
                                    </option>
                                    <option {{$companyGov->gov=='دمياط'?'selected':null}} value="دمياط">دمياط</option>
                                </select>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("gov") ? $errors->first("gov") : null }}
                                    </span>
                            </div>
                            <div class="col-md-6">
                                <label style="float: right;"> السعر :
                                    <span class="text-danger">*</span></label>
                                <input name="price"
                                       type="number"
                                       value="{{$companyGov->price??old('price')}}"
                                       class="form-control {{ $errors->has("price") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل السعر"/>
                                <span
                                    class="form-text text-danger" style="float: right;">
                                        {{ $errors->has("price") ? $errors->first("price") : null }}
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
