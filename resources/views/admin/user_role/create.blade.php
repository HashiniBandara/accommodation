@extends('admin.templates.master')

@section('content')

    <div class="col-sm-12 col-lg-10">

        <a class="btn btn-dark btn-pill btn-sm mb-5" href="{{ route(AdminServiceProvider::USER_ROLE_LIST_ROUTE) }}"><i
                class="fas fa-chevron-left"></i> Back to Role's</a>

        @include('admin.global.alert') {{-- Form validation messages --}}

        <form method="POST"  class="custom-validation" data-parsley-validate id="create_new_role_form" action="{{ route(AdminServiceProvider::USER_ROLE_SUBMIT_ROUTE) }}">
            @csrf
            <input type="hidden"  id="new_role" value="1">
            <input type="hidden" name="create_role_permissions" id="create_role_permissions" value="">
            <div class="card mb-10 card-custom">
                <div class="card-body">

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Role Name</label>
                        <div class="col-sm-9">
                            <input autocomplete="off" required data-parsley-pattern="^[a-zA-Z- ]+$" data-parsley-minlength="3" data-parsley-maxlength="30" value="{{ old('role_name') }}" type="text" name="role_name" id="role_name"
                                class="form-control @error('role_name') is-invalid @enderror" />
                            @error('role_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Permissions</label>
                        <div class="col-sm-9">

                            <select name="custom_permissions" id="custom_permissions" class="form-control col-6">
                                <option value="0">All</option>
                                <option value="1">Custom</option>
                            </select>

                            <div id="permission_list_create" class="pt-6" style="display: none">
                                <ul>
                                    @foreach ($permissions as $module => $permission)
                                        <li>
                                            {{dashesToCamelCase($module)}}
                                            <ul>
                                                @foreach ($permission as $sub => $perm)
                                                    <li data-jstree='{"selected": true }' id="{{$perm->id}}">{{$perm->name}}</li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <input type="submit" class="btn btn-primary" id="create_new_role" value="Add New Role">
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
