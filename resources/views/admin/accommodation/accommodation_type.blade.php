@extends('admin.templates.master')

@section('content')
    <style>
        .delete-btn {
            display: inline-block;
            margin-left: 10px;
        }
    </style>

    <div class="col-sm-12 col-lg-10">

        <a class="btn btn-dark btn-pill btn-sm mb-5"
            href="{{ route(AdminServiceProvider::ACCOMMODATION_LIST_VIEW_ROUTE) }}"><i class="fas fa-chevron-left"></i> Back
            To View All Accommodation Type</a>

        @include('admin.global.alert') {{-- Form validation messages --}}

        <form method="POST" class="custom-validation" data-parsley-validate id="create_new_accommodation_type_form"
            action="{{ route(AdminServiceProvider::ACCOMMODATION_TYPE_SUBMIT_ROUTE) }}">
            @csrf
            <input type="hidden" id="new_accommodation_type" value="1">
            <div class="card mb-10 card-custom">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="enable_brand" class="col-sm-3 col-form-label">Accommodation Type Status</label>
                        <div class="col-sm-12 col-lg-9">
                            <span class="switch switch-outline switch-icon switch-info">
                                <label>
                                    <input type="checkbox" name="accommodation_type_status" id="accommodation_type_status">
                                    <span></span>
                                </label>
                            </span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="accommodation_type" class="col-sm-3 col-form-label">Accommodation Type</label>
                        <div class="col-sm-9">
                            <input autocomplete="off" required data-parsley-pattern="^[a-zA-Z- ]+$"
                                data-parsley-minlength="3" data-parsley-maxlength="30"
                                value="{{ old('accommodation_type') }}" type="text" name="accommodation_type"
                                id="accommodation_type"
                                class="form-control @error('accommodation_type') is-invalid @enderror" />
                            @error('accommodation_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <input type="submit" class="btn btn-primary" id="new_accommodationType"
                            value="Add Accommodation Type">
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
    <script src="{{ asset('assets/admin/js/user.js') }}"></script>
@endpush
