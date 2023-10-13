@extends('dashboard.layouts.app')

@section('page')
    <div class="d-flex flex-row flex-column-fluid page">
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

            <!--begin::Header Mobile-->
        @include('dashboard.includes.header_mobile')
        <!--end::Header Mobile-->

            <!--begin::Header-->
        @include('dashboard.includes.header')
        <!--end::Header-->

            <!--begin::Header Menu Wrapper-->
        @include('dashboard.includes.aside')
        <!--end::Header Menu Wrapper-->

            <!--begin::Container-->
            <div class="d-flex flex-row flex-column-fluid container">
                <div class="main d-flex flex-column flex-row-fluid">
                    <!--begin::Subheader-->
                    <div class="subheader py-2 py-lg-6" id="kt_subheader">
                        <div class="w-100 d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                            <div class="d-flex align-items-center flex-wrap mr-1">
                                <div class="d-flex align-items-baseline flex-wrap mr-5">
                                    <h5 class="text-dark font-weight-bold my-1 mr-5">لوحة التحكم</h5>
                                    <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                                        @yield('page_header')
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Subheader-->

                    <div class="content flex-column-fluid" id="kt_content">
                        @if(session()->has('status'))
                            @include('dashboard.includes.alerts',['message' => session()->get('message'),'alert_class' => session()->get('status')])
                        @endif

                        @yield('content')

                    </div>
                </div>
            </div>
            <!--end::Container-->

            <!--begin::Footer-->
        @include('dashboard.includes.footer')
        <!--end::Footer-->
        </div>
    </div>
@endsection
