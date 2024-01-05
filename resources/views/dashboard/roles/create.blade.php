@extends('dashboard.layouts.master')
@section('styles')

@endsection
@section('page_header')
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.roles.index')}}" class="text-muted">القواعد</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.roles.create')}}" class="text-muted">انشاء جديد</a>
        </li>
    </ul>
@endsection
@section('content')
    <form action="{{route('dashboard.roles.store')}}" method="post" enctype="multipart/form-data">
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
                            <div class="col-lg-6">
                                <label style="float: right">الاسم: <span style="color: red">*</span></label>
                                <input type="text"
                                       name="name"
                                       value="{{ old("name") }}"
                                       class="form-control {{ $errors->has("name") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل الاسم">
                                <span class="form-text text-muted {{ $errors->has("name") ? 'error' : '' }}">
                                        {{ $errors->has("name") ? $errors->first("name") :''}}
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label style="float: right">العنوان : <span style="color: red">*</span></label>
                                <input type="text"
                                       name="label"
                                       value="{{ old("label") }}"
                                       class="form-control {{ $errors->has("label") ? 'is-invalid' : '' }}"
                                       placeholder="من فضلك ادخل العنوان">
                                <span class="form-text text-muted  {{ $errors->has("label") ? 'error' : '' }}">
                                        {{ $errors->has("label") ? $errors->first("label") : '' }}
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            @foreach($permissions as $model => $permission)
                                @if(str_contains($model , 'language') !== true)
                                    <div class=" col-lg-3">
                                        <label style="float: right;" class="col-form-label">
                                            @if(ucfirst($model) =='Bill')
                                                الفواتير
                                            @endif
                                            @if(ucfirst($model) =='Company')
                                                المندوب
                                            @endif
                                            @if(ucfirst($model) =='Product')
                                                المنتجات
                                            @endif
                                            @if(ucfirst($model) =='Role')
                                                القواعد
                                            @endif
                                            @if(ucfirst($model) =='User')
                                                المستخدمين
                                            @endif
                                            @if(ucfirst($model) =='Report')
                                                التقارير
                                            @endif
                                            @if(ucfirst($model) =='Delivery')
                                                التسليمات والمرتجعات
                                            @endif
                                            @if(ucfirst($model) =='Dashboard')
                                                الرئسية
                                            @endif
                                            @if(ucfirst($model) =='Supplier')
                                                الموردين
                                            @endif
                                        </label>
                                        <select
                                            class="form-control kt_select2_selector kt-select2 {{ $errors->has("permissions") ? 'is-invalid' : '' }}"
                                            id="kt_select2_{{ $model }}" name="permissions[]"
                                            multiple="multiple">
                                            @foreach($permission as $operation)
                                                <option value="{{ $operation->id }}"
                                                    {{ in_array($operation->id,old('permissions') ?? [])
                                                        ? 'selected' : ''
                                                        }}>
                                                    @if(explode(' ',$operation->label)[0]=='create')
                                                        انشاء
                                                    @endif
                                                    @if(explode(' ',$operation->label)[0]=='update')
                                                        تعديل
                                                    @endif
                                                    @if(explode(' ',$operation->label)[0]=='update_own')
                                                        تعديل الخاص
                                                    @endif
                                                    @if(explode(' ',$operation->label)[0]=='delete')
                                                        حذف
                                                    @endif
                                                    @if(explode(' ',$operation->label)[0]=='read')
                                                        قراءة
                                                    @endif
                                                    @if(explode(' ',$operation->label)[0]=='read_own')
                                                            قراءة الخاص
                                                    @endif
                                                    @if(explode(' ',$operation->label)[0]=='print')
                                                        طباعة
                                                    @endif
                                                        @if(explode(' ',$operation->label)[0]=='export_excel')
                                                            تصدير
                                                        @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            @endforeach
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
    <script src="{{asset('assets/js/pages/crud/forms/widgets/tagify.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/pages/crud/forms/editors/summernote.js')}}"></script>
    <script>
        $('.kt_select2_selector').select2({
            placeholder: 'اختار'
        });
    </script>
@endsection
