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
        <h3 class="card-title">All Users</h3>
        <div class="d-flex align-items-center">

            @include('admin.global.datatable-export')

            @if (AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::USER_CREATE_ROUTE))
                <a href="{{ route(AdminServiceProvider::USER_CREATE_ROUTE) }}" class="btn btn-primary ml-3">Add New User</a>
            @endif
        </div>
    </div>
    <div class="card-body">
        <table id="userTable" class="table table-bordered table-hover table-checkable dataTable no-footer dtr-inline">
            <caption></caption>
            <thead>
                <tr>
                    <th id="id">Id</th>
                    <th id="first_name">First Name</th>
                    <th id="last_name">Last Name</th>
                    <th id="email">Email</th>
                    <th id="role">Role</th>
                    <th id="status">Status</th>
                    <th id="actions"></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
{{-- end Permission list --}}

@endsection

@push('scripts')
    <script src="{{ asset('assets/admin/js/user.js') }}"></script>
@endpush
