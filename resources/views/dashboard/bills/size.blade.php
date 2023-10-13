<select name="size[]" multiple
        class="form-control size {{ $errors->has("size") ? 'is-invalid' : '' }}">
    @if($product->size !=null)
        @foreach(explode(',',$product->size) as $size)
            <option value="{{$size}}">{{$size}}</option>
        @endforeach
    @endif
</select>
