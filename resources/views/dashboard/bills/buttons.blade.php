              @can('update_bill')
                                        <a href="{{route('dashboard.bills.edit', ['bill' => $bill->id])}}"
                                           class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                            <i class="la la-edit"></i>
                                        </a>
                                    @endcan
                                    @can('delete_bill')
                                        <a data-url="{{ route('dashboard.bills.destroy',['bill' => $bill->id]) }}"
                                           data-item-id="{{ $bill->id }}"
                                           class="btn btn-sm btn-clean btn-icon btn-icon-md delete-button"
                                           data-toggle="modal"
                                           data-target="#delete_modal">
                                            <i class="la la-trash"></i>
                                        </a>
                                    @endcan