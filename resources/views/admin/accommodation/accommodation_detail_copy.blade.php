@extends('admin.templates.master')

{{-- @php
    $settingsSeperator = config('settings.separator');
@endphp --}}

@section('content')
    <div class="col-sm-12 col-lg-10">

        <a class="btn btn-dark btn-pill btn-sm mb-5"
            href="{{ route(AdminServiceProvider::ACCOMMODATION_DETAILS_LIST_VIEW_ROUTE) }}"><i class="fas fa-chevron-left"></i>
            Back To View All Accommodation Detail</a>

        @include('admin.global.alert') {{-- Form validation messages --}}

        <form method="POST" class="custom-validation" data-parsley-validate id="create_new_accommodation_detail_form"
            action="{{ route(AdminServiceProvider::ACCOMMODATION_DETAILS_SUBMIT_ROUTE) }}" enctype="multipart/form-data">
            @csrf
            {{-- <input type="hidden" id="new_accommodation_detail" value="1"> --}}

            <div class="card mb-10 card-custom">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="enable_brand" class="col-sm-3 col-form-label">Accommodation Detail Status</label>
                        <div class="col-sm-12 col-lg-9">
                            <span class="switch switch-outline switch-icon switch-info">
                                <label>
                                    <input type="checkbox" name="accommodation_detail_status"
                                        id="accommodation_detail_status">
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Accommodation Type</label>
                        <div class="col-sm-9">
                            <select required name="accommodation_type_id" id="accommodation_type_id"
                                class="form-control col-6">
                                <option value="">Choose Accommodation Type </option>
                                @foreach ($accommodation_types as $accommodation_type)
                                    <option value="{{ $accommodation_type->id }}">
                                        {{ $accommodation_type->accommodation_type }}</option>
                                @endforeach
                            </select>
                            @error('accommodation_type_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Title</label>
                        <div class="col-sm-9">
                            <input autocomplete="off" required data-parsley-pattern="^[a-zA-Z- ]+$"
                                data-parsley-minlength="3" data-parsley-maxlength="30" value="{{ old('title') }}"
                                type="text" name="title" id="title"
                                class="form-control @error('title') is-invalid @enderror" />
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Banner Image</label>
                        <div class="col-sm-9">
                            <input autocomplete="off" value="{{ old('banner') }}" type="file" name="banner"
                                id="banner" class="form-control @error('banner') is-invalid @enderror" />
                            @error('banner')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Banner Image</label>
                        <div class="col-sm-9">
                            <input autocomplete="off" value="{{ old('banner') }}" type="file" name="banner"
                                id="banner" class="form-control @error('banner') is-invalid @enderror" />
                            @error('banner')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- @php $fieldName=$settingsSeperator.'banner'; @endphp
                    <x-single-file-chooser errors="{{ $errors->has($fieldName) ? $errors->first($fieldName) : '' }}"
                        placeholderText="Recommended Image Size : 500px x 500px"
                        {{-- filePath="{{ old($fieldName) }}" :required="true" --}}
                        {{-- filePath="{{ ($fieldName) }}" :required="true" --}}
                        {{-- uploadPath="settings" accept="image/*" acceptHint="jpg, jpeg, png" label="Banner Image" --}}
                        {{-- fieldName="{{ $fieldName }}"></x-single-file-chooser> --}}

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Description</label>
                        <div class="col-sm-9">
                            <input autocomplete="off" required value="{{ old('description') }}" type="text" row="3" name="description"
                                id="description" class="form-control @error('description') is-invalid @enderror"/>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Gallery</label>
                        <div class="col-sm-9">
                            <input autocomplete="off" value="{{ old('gallery') }}" type="file" name="gallery"
                                id="gallery" class="form-control @error('gallery') is-invalid @enderror" />
                            @error('gallery')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Gallery</label>
                        <div class="col-sm-9">
                            <input autocomplete="off" value="{{ old('gallery') }}" type="file" name="gallery"
                                id="gallery" class="form-control @error('gallery') is-invalid @enderror" />
                            @error('gallery')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- @php $fieldName=$settingsSeperator.'gallery'; @endphp
                    <x-multiple-file-chooser errors="{{ $errors->has($fieldName) ? $errors->first($fieldName) : '' }}"
                        placeholderText="Recommended Image Size : 500px x 500px"
                        {{-- filePath="{{ old($fieldName) }}" :required="true" --}}
                        {{-- filePath="{{ ($fieldName) }}" :required="true" --}}
                        {{-- uploadPath="settings" accept="image/*" acceptHint="jpg, jpeg, png" label="Gallery" --}}
                        {{-- fieldName="{{ $fieldName }}"></x-multiple-file-chooser> --}}



                    <div class="form-group text-right">
                        <input type="submit" class="btn btn-primary" id="new_accommodationDetail"
                            value="Add Accommodation Details">
                    </div>
                </div>
            </div>
        </form>

        <div class="card mb-10 card-custom">
            <div class="card-body">
            </div>
        </div>

    </div>
@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/jstree/jstree.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/jstree/jstree.bundle.js') }}"></script>
    <script src="{{ asset('assets/admin/js/user_role.js') }}"></script>
@endpush

@push('scripts')
    <script src="{{ asset('assets/admin/js/accommodation_detail.js') }}"></script>
@endpush

{{-- @push('scripts')
    <script>
        //  var uploadUrl = "accommodation_detail";
        var uploadUrl = "theme-settings";
        var SETTINGS_SEPARATOR = "{{ $settingsSeperator }}";
    </script>
    <script src="{{ asset('assets/admin/js/settings.js') }}" type="text/javascript"></script>
@endpush --}}
