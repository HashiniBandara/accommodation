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



        <div class="card my-10 card-custom">
            <div class="card-header">
                <h3 class="card-title">Accommodation Details</h3>
                <div class="d-flex align-items-center">

                    @include('admin.global.datatable-export')

                    {{-- @if (AdminServiceProvider::getAuthUserPermission(AdminServiceProvider::ACCOMMODATION_TYPE_CREATE_ROUTE))
                        <a href="{{ route(AdminServiceProvider::ACCOMMODATION_TYPE_CREATE_ROUTE) }}" class="btn btn-primary ml-3">Add New Accommodation Type</a>
                    @endif --}}
                </div>
            </div>
            <div class="card-body">
                <table id="userTable"
                    class="table table-bordered table-hover table-checkable dataTable no-footer dtr-inline">
                    <caption></caption>
                    <thead>
                        <tr>
                            <th id="id">Id</th>
                            <th id="accommodation_id">Accommodation Id</th>
                            <th id="title">Title </th>
                            <th id="banner">Banner Image</th>
                            <th id="description">Description</th>
                            <th id="gallery">Gallery</th>
                            <th> </th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($view_accommodation as $view_accommodations)
                            <tr>

                                <td>{{ $view_accommodations->id }}</td>
                                @php
                                    // {{-- // $view_accommodation = DB::table('accommodation_details')
                                // // ->leftJoin('accommodation_types', 'accommodation_details.accommodation_id', '=',
                                // 'accommodation_types.id')
                                // ->get(); --}}
                                    $accommodation = DB::table('accommodation_types')
                                        ->leftJoin('accommodation_details', 'accommodation_types.id', '=', 'accommodation_details.accommodation_id')
                                        // ->where('accommodation_type')
                                        ->get();
                                    echo $accommodation;
                                @endphp

                                @foreach ($accommodation as $accommodations)
                                    {{-- @if ($prescriptions->quotation_status == 1) --}}
                                    {{-- @if ($accommodation_types->id == $accommodation_details->accommodation_id)
                                        <td>{{ $accommodation_types->accommodation_type }}</td>
                                    @endif --}}
                                @endforeach

                                <td>{{ $view_accommodations->accommodation_id }}</td>
                                <td>{{ $view_accommodations->title }}</td>
                                <td>{{ $view_accommodations->banner }}</td>
                                <td>{{ $view_accommodations->description }}</td>
                                <td>{{ $view_accommodations->gallery }}</td>
                                <td>
                                    <a class="btn btn-warning mb-5"
                                        href="{{ route(AdminServiceProvider::ACCOMMODATION_DETAILS_VIEW_ROUTE, $view_accommodations->id) }}"><i
                                            class="fas fa-eye"></i> View</a>
                                    {{-- {{ route(AdminServiceProvider::ACCOMMODATION_DETAILS_DELETE_ROUTE,$accommodation_detail->id) }} --}}

                                    <a class="btn btn-success mb-5"
                                        href="{{ route(AdminServiceProvider::ACCOMMODATION_DETAILS_EDIT_ROUTE, $view_accommodations->id) }}"><i
                                            class="fas fa-pen"></i> Edit</a>

                                    <a class="btn btn-danger mb-5" href=""><i class="fas fa-trash"></i> Delete</a>
                                    {{-- {{ route(AdminServiceProvider::ACCOMMODATION_DETAILS_DELETE_ROUTE,$accommodation_detail->id) }} --}}
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
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

{{-- @push('scripts')
    <script src="{{ asset('assets/admin/js/user.js') }}"></script>
@endpush --}}
