<td>
    @can('update_delivery')
        @if($bill->deleted_at==null)
            <a href="{{route('dashboard.deliveries.edit', ['delivery' => $bill->id])}}"
               class="btn btn-sm btn-clean btn-icon btn-icon-md">
                <i class="la la-edit"></i>
            </a>
        @endif
    @endcan
</td>
