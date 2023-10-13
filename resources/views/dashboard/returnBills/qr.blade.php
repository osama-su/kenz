<td>

<img
    src="data:image/png;base64, {{ base64_encode(QrCode::encoding('UTF-8')->format('png')->margin(1)->size(80)->generate(route('dashboard.bills.return',['bill'=>$bill->id]))) }}">
</td>