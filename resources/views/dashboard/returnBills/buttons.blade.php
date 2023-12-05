<td>
    @can('update_delivery')
        @if($bill->deleted_at==null)
            @if($bill->created_by==auth()->user()->id)
            <a href="{{route('dashboard.deliveries.edit', ['delivery' => $bill->id])}}"
               class="btn btn-sm btn-clean btn-icon btn-icon-md">
                <i class="la la-edit"></i>
            </a>
            @endif
        @endif
    @endcan
    @can('delete_delivery')
        @if($bill->deleted_at==null)
                @if($bill->created_by==auth()->user()->id)
                <a data-url="{{ route('dashboard.deliveries.destroy',['delivery' => $bill->id]) }}"
               data-item-id="{{ $bill->id }}"
               class="btn btn-sm btn-clean btn-icon btn-icon-md delete-button" data-toggle="modal"
               data-target="#delete_modal">
                <i class="la la-trash"></i>
            </a>
                @endif
        @endif
    @endcan
</td>
{{--@include('dashboard.includes.delete-modal',['action_message' => 'هذه الفاتورة'])--}}
<!--begin::Modal-->
{{--<div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"--}}
{{--     aria-hidden="true">--}}
{{--    <div class="modal-dialog" role="document">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h5 class="modal-title" id="exampleModalLabel">مسح</h5>--}}
{{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                </button>--}}
{{--            </div>--}}
{{--            <div class="modal-body">--}}
{{--                <p>هل تريد مسح {{ isset($action_message) ? $action_message : 'this item' }}--}}
{{--                    ؟</p>--}}
{{--            </div>--}}
{{--            <div class="modal-footer">--}}
{{--                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>--}}
{{--                <button type="button" class="btn btn-danger" id="delete-button">مسح</button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
<!--end::Modal-->

<script src="{{ asset('assets/js/delete-item.js') }}" type="text/javascript"></script>
