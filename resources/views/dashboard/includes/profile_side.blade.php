<div id="kt_quick_user" class="offcanvas offcanvas-left p-10">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
        <h3 class="font-weight-bold m-0">{{__('dashboard.user_profile')}}</h3>
        <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
            <i class="ki ki-close icon-xs text-muted"></i>
        </a>
    </div>
    <div class="offcanvas-content pr-5 mr-n5">
        <div class="d-flex align-items-center mt-5">
            <div class="symbol symbol-100 mr-5">
                <div class="symbol-label"
                     style="background-image:url('{{(Auth::user()->photo != null && Storage::disk('public')->exists(Auth::user()->photo) )
                        ? Storage::url(Auth::user()->photo):asset('dashboard_assets/assets/media/users/admin.png')}}')"></div>
                <i class="symbol-badge bg-success"></i>
            </div>
            <div class="d-flex flex-column">
                <a href="#"
                   class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">{{Auth::user()->name??'-'}}</a>
                <div class="text-muted mt-1">{{__('dashboard.'.Auth::user()->type)}}</div>
                <div class="navi mt-2">
                    <a href="#" class="navi-item">
                        <span class="navi-link p-0 pb-2">
                            <span class="navi-icon mr-1">
                                <span class="svg-icon svg-icon-lg svg-icon-primary">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-notification.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                         viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path
                                                d="M21,12.0829584 C20.6747915,12.0283988 20.3407122,12 20,12 C16.6862915,12 14,14.6862915 14,18 C14,18.3407122 14.0283988,18.6747915 14.0829584,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,12.0829584 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z"
                                                fill="#000000"/>
                                            <circle fill="#000000" opacity="0.3" cx="19.5" cy="17.5" r="2.5"/>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </span>
                            <span class="navi-text text-muted text-hover-primary">{{Auth::user()->email??'-'}}</span>
                        </span>
                    </a>
                    <a href="{{route('admin.logout')}}"
                       class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">
                        {{__('dashboard.logout')}}
                    </a>
                </div>
            </div>
        </div>

        <div class="separator separator-dashed mt-8 mb-5"></div>

        <div class="navi navi-spacer-x-0 p-0">
            <a href="{{route('admin.profile.index')}}" class="navi-item">
                <div class="navi-link">
                    <div class="symbol symbol-40 bg-light mr-3">
                        <div class="symbol-label">
                            <span class="svg-icon svg-icon-md svg-icon-success">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Notification2.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                     viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path
                                            d="M13.2070325,4 C13.0721672,4.47683179 13,4.97998812 13,5.5 C13,8.53756612 15.4624339,11 18.5,11 C19.0200119,11 19.5231682,10.9278328 20,10.7929675 L20,17 C20,18.6568542 18.6568542,20 17,20 L7,20 C5.34314575,20 4,18.6568542 4,17 L4,7 C4,5.34314575 5.34314575,4 7,4 L13.2070325,4 Z"
                                            fill="#000000"/>
                                        <circle fill="#000000" opacity="0.3" cx="18.5" cy="5.5" r="2.5"/>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span>
                        </div>
                    </div>
                    <div class="navi-text">
                        <div class="font-weight-bold">{{__('dashboard.profile_info')}}</div>
                        <div class="text-muted">{{__('dashboard.account_settings')}}
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="separator separator-dashed my-7"></div>
        <div>
            <h5 class="mb-5">{{__('dashboard.recent_notification')}}</h5>
            <div class="d-flex align-items-center bg-light-primary rounded p-5 gutter-b">
                <span class="svg-icon svg-icon-warning mr-5">
                    <span class="svg-icon svg-icon-lg">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path
                                    d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z"
                                    fill="#000000"/>
                                <rect fill="#000000" opacity="0.3"
                                      transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)"
                                      x="16.3255682" y="2.94551858" width="3" height="18" rx="1"
                                />
                            </g>
                        </svg>
                    </span>
                </span>
                <div class="d-flex flex-column flex-grow-1 mr-2">
                    <a href="#" class="font-weight-normal text-dark-75 text-hover-primary mb-1">
                        تم عمل حجز جديد للمريض حسن الهوارى
                    </a>
                    <span class="text-muted font-size-sm">منذ 2 دقيقة</span>
                </div>
                <span class="font-weight-bolder text-primary py-1 font-size-lg"></span>
            </div>
        </div>
        <!--end::Notifications-->
    </div>
    <!--end::Content-->
</div>
