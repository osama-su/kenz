<select name="color[]" multiple
        class="form-control color {{ $errors->has("color") ? 'is-invalid' : '' }}">
    @if($product->color !=null)
        @foreach(explode(',',$product->color) as $color)
            <option value="{{$color}}">{{$color}}</option>
        @endforeach
    @endif
</select>
