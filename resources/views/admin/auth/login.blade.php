@extends('admin.templates.login-header')

@section('content')

    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{ asset('metronic/css/pages/login/login-1.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->

    <!--begin::Login-->
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <!--begin::Aside-->
        <div class="login-aside d-flex flex-column flex-row-auto" style="background-color: #5e49aa;">
            <!--begin::Aside Top-->
            <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                <!--begin::Aside title-->
                <h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg text-white" style="color: #986923;">
                    Welcome to
                    @if ($siteTitle = getSettingValue(config('settings.theme_key'), 'site_title'))
                        <br />{{ $siteTitle }}
                    @endif
                    Admin Portal
                </h3>
                <!--end::Aside title-->
            </div>
            <!--end::Aside Top-->
            <!--begin::Aside Bottom-->
            @if ($loginBackground = getSettingValue(config('settings.theme_key'), 'login_background'))
                <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center"
                    style="background-image: url( {{ $loginBackground }})"></div>
            @endif
            <!--end::Aside Bottom-->
        </div>
        <!--begin::Aside-->
        <!--begin::Content-->
        <div
            class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            <!--begin::Content body-->
            <div class="d-flex flex-column-fluid flex-center">
                <!--begin::Signin-->
                <div class="login-form login-signin">
                    <!--begin::Form-->
                    <form action="{{ route('admin.login.submit') }}" method="POST">
                        @csrf
                        <!--begin::Title-->
                        <p class="text-center mb-20 login-brand">
                            @if ($siteLogo = getSettingValue(config('settings.theme_key'), 'site_logo'))
                                <img alt="Logo" src="{{ $siteLogo }}" style="max-width: 250px; width: 100%;" />
                            @endif
                        </p>
                        <!--end::Title-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">{{ __('E-Mail Address') }}</label>
                            <input
                                class="form-control form-control-solid h-auto py-6 px-6 rounded-lg @error('email') is-invalid @enderror"
                                type="text" name="email" value="{{ old('email') }}" autocomplete="off" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group">
                            <div class="mt-n5">
                                <label class="font-size-h6 font-weight-bolder text-dark pt-5">{{ __('Password') }}</label>
                            </div>
                            <input
                                class="form-control form-control-solid h-auto py-6 px-6 rounded-lg @error('password') is-invalid @enderror"
                                type="password" name="password" autocomplete="off" />
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!--end::Form group-->
                        <div class="form-group checkbox-inline d-flex justify-content-between">
                            <label class="checkbox checkbox-lg">
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span></span>{{ __('Remember Me') }}
                            </label>
                            <a href="{{ route(AdminServiceProvider::PASSWORD_REQUEST_ROUTE) }}"
                                    class="text-primary font-size-h6 font-weight-bolder text-hover-primary">Forgot
                                    Password ?</a>
                        </div>
                        <!--begin::Action-->
                        <div class="pb-lg-0 pb-5">
                            <button class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Sign
                                In</button>
                        </div>
                        <!--end::Action-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signin-->
            </div>
            <!--end::Content body-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Login-->
    <style>
        #kt_footer {
            display: none !important;
        }

        .login.login-1 .login-aside .aside-img {
            background-size: contain;
        }

    </style>
@endsection
