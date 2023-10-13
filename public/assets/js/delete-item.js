// add csrf token as header for every ajax request.

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Delete item.
var delete_route;
var item_id;

$('.delete-button').on('click', function () {
    delete_route = $(this).data('url');
    item_id = $(this).data('item-id');
});

$(document).on('click', '#delete-button', function () {
    $.post(delete_route + '?deleted_type=' + $('.deleted_type').val(), {_method: 'delete'},).done(function () {
        $('#delete_modal').modal('toggle');
        $('#row-' + item_id).fadeOut();
    });
});
