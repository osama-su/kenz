<select name="model[]" multiple
        class="form-control model {{ $errors->has("model") ? 'is-invalid' : '' }}">
    @if($product->model !=null)
        @foreach(explode(',',$product->model) as $model)
            <option value="{{$model}}">{{$model}}</option>
        @endforeach
    @endif

</select>
