@if($bill->print == 'yes')
@can('update_delivery')
    <td><select class="form-control deliveryStatus"
                data-url="{{ route('dashboard.bills.deliveryStatus',['bill'=>$bill->id])}}"
                data-item-id="{{ $bill->id }}">
            <option value="">اختار</option>
            <option value="yes" {{$bill->delivery_status=='yes'?'selected':null}}>نعم
            </option>
            <option value="no" {{$bill->delivery_status=='no'?'selected':null}}>لا</option>
        </select>
    </td>
@endcan
<script>
    $('.deliveryStatus').on('change', function () {
        $.post($(this).data('url'), {delivery_status: $(this).val()}, function (data, status) {
            location.reload();
        });
    });
</script>
@else
لم يتم طباعة الفاتورة
@endif
