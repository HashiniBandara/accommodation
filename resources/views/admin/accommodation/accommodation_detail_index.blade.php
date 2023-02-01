@extends('admin.templates.master')

@section('content')

    <style>
        .delete-btn{
            display: inline-block;
            margin-left: 10px;
        }
    </style>

    @include('admin.global.alert') {{-- Form validation messages --}}

    {{-- start Permission list --}}
    <div class="card my-10 card-custom">
        <div class="card-header">
            <h3 class="card-title"></h3>
            <div class="d-flex align-items-center">
                @include('admin.global.datatable-export')
                @if (AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::ACCOMMODATION_DETAILS_CREATE_ROUTE))
                    <a href="{{ route(AdminServiceProvider::ACCOMMODATION_DETAILS_CREATE_ROUTE) }}" class="btn btn-primary ml-3">Add
                        New Accommodation Details</a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <table id="accommodationDetailTable"
                class="table table-bordered table-hover table-checkable dataTable no-footer dtr-inline">
                <caption>List all accommodation details</caption>
                <thead>
                    <tr>
                        <th class="id">Id</th>
                        <th class="accommodation_type">Accommodation Type</th>
                        <th class="title">Title</th>
                        <th class="banner">Banner </th>
                        <th class="description">Description</th>
                        <th class="gallery">Gallery</th>
                        <th class="created_at">Created at</th>
                        <th class="status">Status</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    {{-- end Permission list --}}

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
