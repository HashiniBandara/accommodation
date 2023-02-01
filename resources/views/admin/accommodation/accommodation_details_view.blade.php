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
            href="{{ route(AdminServiceProvider::ACCOMMODATION_TYPE_CREATE_ROUTE) }}"><i class="fas fa-chevron-left"></i> Back
            to Role's</a>

        @include('admin.global.alert') {{-- Form validation messages --}}

        <div class="card mb-3">
            <div class="card-header">
                {{ $accommodation_detail->title }}
              </div>

            <div class="row g-0">
                <div class="col-md-4">
                    <img src="..." class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <p class="card-text">Accommodation Id:{{ $accommodation_detail->id }}</p>
                        <p>{{ $accommodation_detail->banner }}</p>
                        <p>{{ $accommodation_detail->description }}</p>
                        <p>{{ $accommodation_detail->gallery }}</p>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@push('styles')
    <link href="{{ asset('meponic/plugins/custom/jspee/jspee.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('meponic/plugins/custom/jspee/jspee.bundle.js') }}"></script>
    <script src="{{ asset('assets/admin/js/user_role.js') }}"></script>
@endpush

{{-- @push('scripts')
    <script src="{{ asset('assets/admin/js/user.js') }}"></script>
@endpush --}}
