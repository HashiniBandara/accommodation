@php
$siteTitle = getSettingValue(config('settings.theme_key'), 'site_title');
$siteTitle = $siteTitle ?? config('app.name');
@endphp

@section('siteTitle', $siteTitle)

@include('admin.templates.header')

<!--begin::Page-->
<div class="d-flex flex-row flex-column-fluid page">
    <!--begin::Aside-->
    <div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
        <!--begin::Brand-->
        <div class="brand flex-column-auto" id="kt_brand">
            <!--begin::Logo-->
            @if ($siteLogo = getSettingValue(config('settings.theme_key'), 'site_logo'))
                <a href="{{ url('admin') }}" class="brand-logo" style="justify-content: center; width: 100%;">
                    <img alt="Logo" src="{{ $siteLogo }}" />
                </a>
            @endif
            <!--end::Logo-->
            <!--begin::Toggle-->
            <button class="brand-toggle btn btn-sm px-0" id="kt_aside_toggle">
                <span class="svg-icon svg-icon svg-icon-xl">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                        version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24" />
                            <path
                                d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z"
                                fill="#000000" fill-rule="nonzero"
                                transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999)" />
                            <path
                                d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z"
                                fill="#000000" fill-rule="nonzero" opacity="0.3"
                                transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999)" />
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
            </button>
            <!--end::Toolbar-->
        </div>
        <!--end::Brand-->
        <!--begin::Aside Menu-->
        @include('admin.templates.aside')
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside-->
    <!--begin::Wrapper-->
    <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
        <!--begin::Header-->
        <div id="kt_header" class="header header-fixed">
            <div class="subheader py-2 py-lg-6 subheader-solid" id="kt_subheader">
                <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                    <!--begin::Info-->
                    <div class="d-flex align-items-center flex-wrap mr-1">
                        <!--begin::Page Heading-->
                        <div class="d-flex align-items-baseline flex-wrap mr-5">
                            <!--begin::Page Title-->
                            <h5 class="text-dark font-weight-bold my-1 mr-5">{{ !empty($title) ? $title : '' }}</h5>
                            <!--end::Page Title-->
                        </div>
                        <!--end::Page Heading-->
                    </div>
                    <!--end::Info-->
                </div>
            </div>
            <!--begin::Container-->
            <div class="container-fluid d-flex align-items-center justify-content-between">
                <!--begin::Topbar-->
                <div class="d-flex flex-wrap align-items-center">
                    <a href="{{ url('') }}" target="_blank" class="btn btn-primary">Visit Website</a>
                    <div class="d-flex align-items-center ml-5">
                        <label class="col-form-label mr-3" for="compileAssets">Compile Assets</label>
                        @php
                            $fieldNameSuffix = 'compile_assets';
                            $fieldName = config('settings.separator') . $fieldNameSuffix;
                            $compileAssets = getSettingValue(config('settings.theme_key'), $fieldNameSuffix);
                        @endphp
                        <span class="switch switch-outline switch-icon switch-primary">
                            <label>
                                <input type="checkbox" {{ $compileAssets ? 'checked="checked"' : '' }}
                                    name="{{ $fieldName }}" value="1" id="compileAssets">
                                <span></span>
                            </label>
                        </span>
                    </div>
                </div>
                <div class="topbar">
                    <!--begin::Search-->
                    <!--begin::User-->
                    <div class="topbar-item">
                        <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2"
                            id="kt_quick_user_toggle">
                            <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
                            <span
                                class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ AdminServiceProvider::getAuthUser()->first_name }}</span>
                            @if (AdminServiceProvider::getAuthUser()->first_name)
                                <span class="symbol symbol-lg-35 symbol-25 symbol-light-primary">
                                    <span
                                        class="symbol-label font-size-h5 font-weight-bold">{{ substr(AdminServiceProvider::getAuthUser()->first_name, 0, 1) }}</span>
                                </span>
                            @endif
                        </div>
                    </div>
                    <!--end::User-->
                </div>
                <!--end::Topbar-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Header-->
        <!--begin::Content-->
        <div class="content h-100">
            <div class="container-fluid">

                @yield('content')

            </div>
        </div>
        <!--end::Content-->
    </div>
    <!--end::Wrapper-->
</div>
<!--end::Page-->

@include('admin.templates.footer')
