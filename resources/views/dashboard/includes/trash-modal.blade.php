<!--begin::Modal-->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">مرتجع</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body" style="text-align: right;">
                <p>من فضلك اختار النوع</p>
                <select class="form-control deleted_type" name="type">
                    <option value="return">مرتجع</option>
                    <option value="cancel">الغاء</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                <button type="button" class="btn btn-danger" id="delete_button">نعم</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
