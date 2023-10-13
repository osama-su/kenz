@extends('dashboard.layouts.master')
@section('styles')

@endsection
@section('page_header')
    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.index')}}" class="text-muted">الرئسية</a>
        </li>
    </ul>

@endsection
@section('content')
    <div class="row">
        <div class="col-xl-4">
            <!--begin::Stats Widget 7-->
            <div class="card card-custom card-stretch gutter-b">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column p-0">
                    <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                        <div class="d-flex flex-column mr-2">
                            <a href="{{route('dashboard.users.index')}}"
                               class="text-dark-75 text-hover-primary font-weight-bolder font-size-h5">المستخدمين</a>
                            <span class="text-muted font-weight-bold mt-2">عدد المستخدمين</span>
                        </div>
                        <span class="symbol symbol-light-success symbol-45">
														<span
                                                            class="symbol-label font-weight-bolder font-size-h6">+{{$users}}</span>
													</span>
                    </div>
                    <div id="kt_stats_widget_7_chart" class="card-rounded-bottom" style="height: 150px"></div>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Stats Widget 7-->
        </div>
        <div class="col-xl-4">
            <!--begin::Stats Widget 8-->
            <div class="card card-custom card-stretch gutter-b">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column p-0">
                    <div class="d-flex align-items-center justify-content-between card-spacer">
                        <div class="d-flex flex-column mr-2">
                            <a href="{{route('dashboard.products.index')}}"
                               class="text-dark-75 text-hover-primary font-weight-bolder font-size-h5">المنتجات</a>
                            <span class="text-muted font-weight-bold mt-2">عدد المنتجات</span>
                        </div>
                        <span class="symbol symbol-light-danger symbol-45">
														<span
                                                            class="symbol-label font-weight-bolder font-size-h6">+{{$products}}</span>
													</span>
                    </div>
                    <div id="kt_stats_widget_8_chart" class="card-rounded-bottom" style="height: 150px"></div>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Stats Widget 8-->
        </div>
        <div class="col-xl-4">
            <!--begin::Stats Widget 9-->
            <div class="card card-custom card-stretch gutter-b">
                <!--begin::Body-->
                <div class="card-body d-flex flex-column p-0">
                    <div class="d-flex align-items-center justify-content-between card-spacer">
                        <div class="d-flex flex-column mr-2">
                            <a href="{{route('dashboard.bills.index')}}"
                               class="text-dark-75 text-hover-primary font-weight-bolder font-size-h5">الفواتير</a>
                            <span class="text-muted font-weight-bold mt-2">عدد الفواتير</span>
                        </div>
                        <span class="symbol symbol-light-primary symbol-45">
														<span
                                                            class="symbol-label font-weight-bolder font-size-h6">+{{$bills}}</span>
													</span>
                    </div>
                    <div id="kt_stats_widget_9_chart" class="card-rounded-bottom" style="height: 150px"></div>
                </div>
                <!--end::Body-->
            </div>
            <!--end::Stats Widget 9-->
        </div>
    </div>

@endsection
@section('scripts')

    <script src="{{asset('assets/js/pages/widgets.js')}}"></script>

@endsection
