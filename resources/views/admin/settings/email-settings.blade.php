@extends('admin.templates.master')

@php
$settingsSeperator = config('settings.separator');
@endphp

@section('content')

    <?php $accordionArrow = '<svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                            <path
                                                d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                                fill="#000000" fill-rule="nonzero"></path>
                                            <path
                                                d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                                fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999)">
                                            </path>
                                        </g>
                                    </svg>'; ?>

    @include('admin.global.alert') {{-- Form validation messages --}}

    <div class="col-sm-12 col-lg-12">

        <div class="accordion accordion-light accordion-svg-toggle" id="accordionExample">
            <form action="{{ route(SettingsRoutePath::SAVE) }}" method="POST">
                @csrf
                <input type="hidden" name="module_key" id="module_key" value="{{ $module_key }}">
                <input type="hidden" name="redirect_back" id="redirect_back" value="{{ $redirect_back }}">
                <!-- begin:: General Settings -->
                <div class="card card-custom px-10">
                    <div class="card-header">
                        <div class="card-title" data-toggle="collapse" data-target="#collapseGeneralSettings"
                            aria-expanded="true">
                            <span class="svg-icon svg-icon-primary">{!! $accordionArrow !!}</span>
                            <div class="card-label pl-4">General</div>
                        </div>
                    </div>
                    <div id="collapseGeneralSettings" class="collapse show" aria-labelledby="collapseGeneralSettings"
                        data-parent="#accordionExample">
                        <div class="card-body">
                            @php $fieldName=$settingsSeperator.'from_name'; @endphp
                            <div class="form-group row">
                                <label for="{{ $fieldName }}" class="col-sm-3 col-form-label">From Name</label>
                                <div class="col-sm-9">
                                    <input
                                        value="{{ old($fieldName, getSettingValue($module_key, 'from_name')) }}"
                                        type="text" name="{{ $fieldName }}" id="{{ $fieldName }}"
                                        class="form-control @error($fieldName) is-invalid @enderror" />
                                    @error($fieldName)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            @php $fieldName=$settingsSeperator.'admin_email'; @endphp
                            <div class="form-group row">
                                <label for="{{ $fieldName }}" class="col-sm-3 col-form-label">Admin Email</label>
                                <div class="col-sm-9">
                                    <input
                                        value="{{ old($fieldName, getSettingValue($module_key, 'admin_email')) }}"
                                        type="text" name="{{ $fieldName }}" id="{{ $fieldName }}"
                                        class="form-control @error($fieldName) is-invalid @enderror" />
                                    @error($fieldName)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            @php $fieldName=$settingsSeperator.'email_logo'; @endphp
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Email Logo</label>
                                <div class="col-sm-9">
                                    <?php $email_logo = old($fieldName, getSettingValue($module_key, 'email_logo')); ?>
                                    <div
                                        class="dropzone dropzone-default dropzone-primary image-dropzone {{ $email_logo ? 'd-none' : '' }}">
                                        <div class="dropzone-msg dz-message needsclick">
                                            <h3 class="dropzone-msg-title mb-3">Drop files here or click to upload.</h3>
                                            <p>Allowed File Types: jpg, jpeg, png</p>
                                            <p>Maximum file size allowed: 2MB</p>
                                            <p>Recommended Image Size : 200px x 54px</p>

                                        </div>
                                    </div>
                                    <div class="dropzone-image" class="<?php echo !$email_logo ? '' : 'd-none'; ?>">
                                        <?php if ($email_logo): ?>
                                        <img src="<?php echo $email_logo; ?>" alt=""><a href="#"
                                            class="image-remove remove-upload-image">X</a>
                                        <?php endif; ?>
                                    </div>
                                    <input type="hidden" name="{{ $fieldName }}" class="dropzone-value"
                                        value="{{ $email_logo }}">
                                </div>
                            </div>
                            @php $fieldName=$settingsSeperator.'email_footer_contact'; @endphp
                            <div class="form-group row">
                                <label for="{{ $fieldName }}" class="col-sm-3 col-form-label">Email Footer Contact
                                    Number</label>
                                <div class="col-sm-9">
                                    <input
                                        value="{{ old($fieldName, getSettingValue($module_key, 'email_footer_contact')) }}"
                                        type="text" name="{{ $fieldName }}" id="{{ $fieldName }}"
                                        class="form-control @error($fieldName) is-invalid @enderror" />
                                    @error($fieldName)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            @php $fieldName=$settingsSeperator.'email_footer_email'; @endphp
                            <div class="form-group row">
                                <label for="{{ $fieldName }}" class="col-sm-3 col-form-label">Email Footer Email
                                    Address</label>
                                <div class="col-sm-9">
                                    <input
                                        value="{{ old($fieldName, getSettingValue($module_key, 'email_footer_email')) }}"
                                        type="text" name="{{ $fieldName }}" id="{{ $fieldName }}"
                                        class="form-control @error($fieldName) is-invalid @enderror" />
                                    @error($fieldName)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: General Settings -->

                <!-- begin:: New System User Template -->
                <div class="card card-custom px-10 mt-5">
                    <div class="card-header">
                        <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseNewSysUser"
                            aria-expanded="false">
                            <span class="svg-icon svg-icon-primary">{!! $accordionArrow !!}</span>
                            <div class="card-label pl-4">New System User Email</div>
                        </div>
                    </div>
                    <div id="collapseNewSysUser" class="collapse" aria-labelledby="collapseNewSysUser"
                        data-parent="#accordionExample">
                        <div class="card-body">

                            @php $fieldName=$settingsSeperator.'new_system_user_email'; @endphp

                            <div class="form-group row align-items-center">
                                <label for="{{ $fieldName }}_subject" class="col-sm-3 col-form-label">Email
                                    Subject</label>
                                <div class="col-sm-9">
                                    <input type="text" name="{{ $fieldName }}_subject"
                                        value="{{ old($fieldName . '_subject', getSettingValue($module_key, 'new_system_user_email_subject')) }}"
                                        class="form-control @error($fieldName.'_subject') is-invalid @enderror">
                                    @error($fieldName.'_subject')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="@error($fieldName) is-invalid @enderror">
                                    <textarea name="{{ $fieldName }}" id="{{ $fieldName }}" cols="30" rows="10"
                                        class="tinymce-editor">{{ old($fieldName . '_subject', getSettingValue($module_key, 'new_system_user_email')) }}</textarea>
                                </div>
                                <p class="shortcode-wrapper mt-3 text-dark">
                                    [[full_name]] - User Full Name<br>
                                    [[user_email]] - User email<br>
                                    [[password]] - Password<br>
                                    [[login_link]] - Login Link<br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: New System User Template -->

                <!-- begin:: New Client Added Email Template -->
                <div class="card card-custom px-10 mt-5">
                    <div class="card-header">
                        <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseNewClientAdded"
                            aria-expanded="false">
                            <span class="svg-icon svg-icon-primary">{!! $accordionArrow !!}</span>
                            <div class="card-label pl-4">New Client Added Email</div>
                        </div>
                    </div>
                    <div id="collapseNewClientAdded" class="collapse" aria-labelledby="collapseNewClientAdded"
                        data-parent="#accordionExample">
                        <div class="card-body">

                            @php $fieldName=$settingsSeperator.'new_client_email'; @endphp

                            <div class="form-group row align-items-center">
                                <label for="{{ $fieldName }}_subject" class="col-sm-3 col-form-label">Email
                                    Subject</label>
                                <div class="col-sm-9">
                                    <input type="text" name="{{ $fieldName }}_subject"
                                        value="{{ old($fieldName . '_subject', getSettingValue($module_key, 'new_client_email_subject')) }}"
                                        class="form-control @error($fieldName.'_subject') is-invalid @enderror">
                                    @error($fieldName.'_subject')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="@error($fieldName) is-invalid @enderror">
                                    <textarea name="{{ $fieldName }}" id="{{ $fieldName }}" cols="30" rows="10"
                                        class="tinymce-editor">{{ old($fieldName . '_subject', getSettingValue($module_key, 'new_client_email')) }}</textarea>
                                </div>
                                <p class="shortcode-wrapper mt-3 text-dark">
                                    [[full_name]] - Client Name<br>
                                    [[client_email]] - Client email<br>
                                    [[password]] - Password<br>
                                    [[login_link]] - Login Link<br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: New Client Added Email Template -->

                <div class="card card-custom mt-5">
                    <div class="card-body text-right p-10">
                        <input type="submit" class="btn btn-primary" value="Update Settings">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        var uploadUrl = 'email-settings';
    </script>
    <script src="{{ asset('assets/admin/js/settings.js') }}" type="text/javascript"></script>
@endsection
