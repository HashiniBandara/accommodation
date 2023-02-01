@extends('admin.templates.master')

@section('content')
    <style>
        .delete-btn {
            display: inline-block;
            margin-left: 10px;
        }
    </style>

    <div class="col-sm-6 col-lg-6 mx-4">

        <a class="btn btn-dark btn-pill btn-sm mb-5"
            href="{{ route(AdminServiceProvider::ACCOMMODATION_TYPE_CREATE_ROUTE) }}"><i class="fas fa-chevron-left"></i> Back
            to Role's</a>

        @include('admin.global.alert') {{-- Form validation messages --}}

        {{-- <div class="alert border-danger text-dark" role="alert"> --}}
            {{-- style="background-color:  #e6b0aa   " --}}

            {{-- <form method="POST" class="custom-validation" data-parsley-validate id="accommodation_detail_form"
            action="{{ url('accommodation_type_delete_view', $accommodation_type->id) }}">
            {{-- {{ route(AdminServiceProvider::ACCOMMODATION_TYPE_DELETE_ROUTE) }} --}}
            {{-- @csrf --}}
                <div class="card">
                    <div class="card-header">
                      <h4>Confirm Delete</h4>
                    </div>
                    <div class="card-body">
                      <p class="card-text">Are you sure you want to delete</p>
                      <p class="card-text">Accommodation type: " <strong> {{ $accommodation_type->accommodation_type }}</strong> "</p>

                    </div>
                    <div class="card-footer align-content-end" >
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                        {{-- <button type="button" class="btn btn-success" value="cancel" >Cancel</button> --}}
                        <input type="text" value="{{ $accommodation_type->id }}">
                        {{-- <button type="submit" class="btn btn-danger" value="delete" >Delete</button> --}}
                        <a class="btn btn-danger mb-5"
                                        href="{{ url('accommodation_type_delete_view', $accommodation_type->id) }}"><i
                                            class="fas fa-trash"></i> Delete</a>
                    </div>
                  </div>
              {{-- </form> --}}

          {{-- </div> --}}


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
