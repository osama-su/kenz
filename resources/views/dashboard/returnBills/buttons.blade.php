<td>
    @can('update_delivery')
        @if($bill->deleted_at==null)
            <a href="{{route('dashboard.deliveries.edit', ['delivery' => $bill->id])}}"
               class="btn btn-sm btn-clean btn-icon btn-icon-md">
                <i class="la la-edit"></i>
            </a>
        @endif
    @endcan
    @can('delete_delivery')
        @if($bill->deleted_at==null)
            <a data-url="{{ route('dashboard.deliveries.destroy',['delivery' => $bill->id]) }}"
               data-item-id="{{ $bill->id }}"
               class="btn btn-sm btn-clean btn-icon btn-icon-md delete-button" data-toggle="modal"
               data-target="#delete_modal">
                <i class="la la-trash"></i>
            </a>
        @endif
    @endcan
</td>
@include('dashboard.includes.delete-modal',['action_message' => 'هذه الفاتورة'])

<script src="{{ asset('assets/js/delete-item.js') }}" type="text/javascript"></script>
