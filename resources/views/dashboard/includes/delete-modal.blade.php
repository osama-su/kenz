<!--begin::Modal-->
<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">مسح</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <p>هل تريد مسح {{ isset($action_message) ? $action_message : 'this item' }}
                    ؟</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                <button type="button" class="btn btn-danger" id="delete-button">مسح</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
