<input name="price" type="number"
       value="{{ $product->price??old('price') }}"
       class="form-control  price {{ $errors->has("price") ? 'is-invalid' : '' }}"
       placeholder="من فضلك السعر"/>


