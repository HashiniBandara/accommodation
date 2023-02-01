@extends('admin.templates.master')

@section('content')
    <style>
        .delete-btn {
            display: inline-block;
            margin-left: 10px;
        }
    </style>

    <div class="col-sm-12 col-lg-12">

        <a class="btn btn-dark btn-pill btn-sm mb-5"
            href="{{ route(AdminServiceProvider::ACCOMMODATION_TYPE_CREATE_ROUTE) }}"><i class="fas fa-chevron-left"></i> Back
            to Role's</a>

        @include('admin.global.alert') {{-- Form validation messages --}}

        <form method="POST" class="custom-validation" data-parsley-validate id="edit_accommodationDetail_form"
            action="{{ route(AdminServiceProvider::ACCOMMODATION_TYPE_UPDATE_ROUTE, $accommodation_detail->id) }}">

            <input type="hidden" name="accommodation_detail_id" id="accommodation_detail_id"
                value="{{ $accommodation_detail->id }}">
            <input type="hidden" id="update_accommodation_detail" value="1">

            @csrf

            <div class="card mb-10 card-custom">
                <div class="card-body">

                    {{-- <div class="form-group row">
                        <label for="accommodation_type" class="col-sm-3 col-form-label">Accommodation Detail</label>
                        <div class="col-sm-9">
                            <input autocomplete="off" required data-parsley-pattern="^[a-zA-Z- ]+$"
                                data-parsley-minlength="3" data-parsley-maxlength="30"
                                type="text" name="accommodation_type"
                                id="accommodation_type"
                                value="{{ old('accommodation_type',$user->accommodation_type) }}"
                                {{-- value="{{ $accommodation_type->accommodation_type }}" --}}
                    {{-- class="form-control @error('accommodation_type') is-invalid @enderror" /> --}}

                    {{-- @error('accommodation_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror --}}
                    {{-- </div>
                    </div> --}}

                    <div class="card mb-10 card-custom">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="enable_brand" class="col-sm-3 col-form-label">Accommodation Detail
                                    Status</label>
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
                                        @foreach ($accommodation_details as $accommodation_detail)
                                            <option value="{{ $accommodation_detail->accommodation_type }}">
                                                {{ $accommodation_detail->accommodation_type_id }}</option>
                                        @endforeach
                                       {{-- @foreach ($accommodation_details as $accommodation_detail)
                                            <option {{ $accommodation_detail->accommodation_type ? 'selected' : '' }}
                                                 value="{{ $accommodation_detail->accommodation_type }}">
                                                {{ $accommodation_detail->accommodation_type_id }}</option>
                                        @endforeach
                                         @foreach ($roles as $role)
                                            <option {{ $cur_role == $role->name ? 'selected' : '' }}
                                                value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach --}}
                                    </select>
                                    @error('description')
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
                                        data-parsley-minlength="3" data-parsley-maxlength="30"
                                        value="{{ $accommodation_detail->title }}" type="text" name="title"
                                        id="title" class="form-control @error('title') is-invalid @enderror" />
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Banner Image</label>
                                <div class="col-sm-9">
                                    <input autocomplete="off" value="{{ $accommodation_detail->banner }}" type="file"
                                        name="banner" id="banner"
                                        class="form-control @error('banner') is-invalid @enderror" />
                                    {{ $accommodation_detail->banner }}
                                    @error('banner')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Description</label>
                                <div class="col-sm-9">
                                    <textarea autocomplete="off" required value="{{ $accommodation_detail->description }}" type="text" row="3"
                                        name="description" id="description" class="form-control @error('description') is-invalid @enderror">
                                        {{ $accommodation_detail->description }}
                                    </textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Gallery</label>
                                <div class="col-sm-9">
                                    <input autocomplete="off" value="{{ $accommodation_detail->gallery }}" type="file"
                                        name="gallery" id="gallery"
                                        class="form-control @error('gallery') is-invalid @enderror" />
                                    value="{{ $accommodation_detail->gallery }}"
                                    @error('gallery')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group text-right">
                                <input type="submit" class="btn btn-primary" id="save"
                                    value="Update Accommodation Type">
                            </div>
                        </div>
                    </div>
        </form>


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
