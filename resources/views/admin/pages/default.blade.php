@extends('admin.templates.master')

@section('content')
    <?php $accordionArrow = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
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

    @php
    $settingsSeperator = config('settings.separator');
    $number = 1;
    @endphp

    @include('admin.global.alert') {{-- Form validation messages --}}

    <div class="col-sm-12 col-lg-12">

        @if (!empty($frontRoute))
            <div class="text-right mb-5">
                <a href="{{ route($frontRoute) }}" target="_blank" class="btn btn-dark">Visit Page</a>
            </div>
        @endif

        <form id="config_theme_settings" action="{{ route(SettingsRoutePath::SAVE) }}" method="POST">
            @csrf
            <input type="hidden" name="module_key" id="module_key" value="{{ $module_key }}">
            <input type="hidden" name="redirect_back" id="redirect_back" value="{{ $redirect_back }}">

            <div class="card card-custom">

                <div class="card-body">

                    <!-- begin:: Site Title -->
                    @php
                        $fieldNameSuffix = 'page_title';
                        $fieldName = $settingsSeperator . $fieldNameSuffix;
                    @endphp
                    <div class="form-group row">
                        <label for="{{ $fieldName }}" class="col-sm-3 col-form-label">Page Title</label>
                        <div class="col-sm-9">
                            <input value="{{ old($fieldName, getSettingValue($module_key, 'page_title')) }}" type="text"
                                name="{{ $fieldName }}" id="{{ $fieldName }}"
                                class="form-control @error($fieldName) is-invalid @enderror" />
                            @error($fieldName)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- end:: Site Title -->

                    <!-- begin:: Banner -->
                    @php
                        $fieldNameSuffix = 'cover_image';
                        $fieldName = $settingsSeperator . $fieldNameSuffix;
                    @endphp
                    <x-single-file-chooser errors="{{ $errors->has($fieldName) ? $errors->first($fieldName) : '' }}"
                        placeholderText="Recommended Image Size : 1600px x 600px"
                        filePath="{{ old($fieldName, getSettingValue($module_key, $fieldNameSuffix)) }}" :required="true"
                        uploadPath="pages/other" accept="image/*" acceptHint="jpg, jpeg, png" label="Page Banner"
                        fieldName="{{ $fieldName }}"></x-single-file-chooser>
                    <!-- end:: Banner -->

                    <!-- begin:: Description -->
                    @php
                        $fieldNameSuffix = 'description';
                        $fieldName = $settingsSeperator . $fieldNameSuffix;
                    @endphp
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <textarea name="{{ $fieldName }}" id="{{ $fieldName }}" rows="7"
                                class="form-control tinymce-editor @error($fieldName) is-invalid @enderror">{{ old($fieldName, getSettingValue($module_key, $fieldNameSuffix)) }}</textarea>
                            @error($fieldName)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- end:: Description -->

                    <!-- begin:: Meta Description -->
                    @php
                        $fieldNameSuffix = 'meta_description';
                        $fieldName = $settingsSeperator . $fieldNameSuffix;
                    @endphp
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Meta Description</label>
                        <div class="col-sm-9">
                            <textarea name="{{ $fieldName }}" id="{{ $fieldName }}" rows="5"
                                class="form-control @error($fieldName) is-invalid @enderror">{{ old($fieldName, getSettingValue($module_key, $fieldNameSuffix)) }}</textarea>
                            @error($fieldName)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- end:: Meta Description -->

                </div>
            </div>

            <div class="card card-custom mt-5">
                <div class="card-body text-right p-10">
                    <input type="submit" class="btn btn-primary" value="Update Settings">
                </div>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
    <script>
        var SETTINGS_SEPARATOR = '{{ config('settings.separator') }}';
        var uploadUrl = 'pages/other';
    </script>
    <script src="{{ assets_path('assets/admin/js/pages.js') }}" type="text/javascript"></script>
@endpush
