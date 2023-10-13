            @can('print_bill')
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" name="printer[]" type="checkbox"
                                               value="{{$bill->id}}"
                                               id="bill-{{$bill->id}}">
                                        <label class="form-check-label" for="bill-{{$bill->id}}">
                                        </label>
                                    </div>
                                </td>
                                @endcan