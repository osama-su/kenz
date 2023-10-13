<!--begin::Modal-->
<div class="modal fade" id="company_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">طباعة</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body" style="text-align: right;">
                <p>اختار المندوب:
                    <select class="form-control" name="company_id">
                        <option value="">اختار</option>
                    @if(\App\Models\Company::count())
                            @foreach(\App\Models\Company::all() as $company)
                                <option value="{{$company->id}}">{{$company->name??'-'}}</option>
                            @endforeach
                        @endif
                    </select>
                </p>
            </div>
            <div class="modal-footer">
                {!! csrf_field() !!}

                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                <button type="submit" class="btn btn-primary" id="company-button">حفظ</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
