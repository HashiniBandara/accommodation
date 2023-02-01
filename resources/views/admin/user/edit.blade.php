@extends('admin.templates.master')

@section('content')
    <div class="col-sm-12 col-lg-10">

        <a class="btn btn-dark btn-pill btn-sm mb-5" href="{{ route(AdminServiceProvider::USER_LIST_ROUTE) }}"><i
                class="fas fa-chevron-left"></i> Back to User's</a>

        @include('admin.global.alert') {{-- Form validation messages --}}

        <form method="POST" class="custom-validation" data-parsley-validate id="edit_user_form"
            action="{{ route(AdminServiceProvider::USER_EDIT_SUBMIT_ROUTE) }}">
            @csrf
            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
            <input type="hidden" id="update_user" value="1">
            <input type="hidden" value="{{ $user->profile_pic }}" id="user_image" name="user_image">
            <div class="card mb-10 card-custom">
                <div class="card-body">

                    @if (AdminServiceProvider::getAuthUser()->id != $user->id)
                        <div class="form-group row">
                            <label for="enable_brand" class="col-sm-3 col-form-label">User Status</label>
                            <div class="col-sm-12 col-lg-9">
                                <span class="switch switch-outline switch-icon switch-info">
                                    <label>
                                        <input type="checkbox" name="user_status" id="user_status"
                                            {{ $user->status == AdminServiceProvider::STATUS_ACTIVE ? 'checked' : '' }}>
                                        <span></span>
                                    </label>
                                </span>
                            </div>
                        </div>
                    @else
                        <input style="display: none" type="checkbox" name="user_status" id="user_status"
                            {{ $user->status == AdminServiceProvider::STATUS_ACTIVE ? 'checked' : '' }}>
                    @endif

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">First Name</label>
                        <div class="col-sm-9">
                            <input autocomplete="off" required data-parsley-pattern="^[a-zA-Z- ]+$"
                                data-parsley-minlength="3" data-parsley-maxlength="30"
                                value="{{ old('first_name', $user->first_name) }}" type="text" name="first_name"
                                id="first_name" class="form-control @error('first_name') is-invalid @enderror" />
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Last Name</label>
                        <div class="col-sm-9">
                            <input autocomplete="off" required data-parsley-pattern="^[a-zA-Z- ]+$"
                                data-parsley-minlength="3" data-parsley-maxlength="30"
                                value="{{ old('last_name', $user->last_name) }}" type="text" name="last_name"
                                id="last_name" class="form-control @error('last_name') is-invalid @enderror" />
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input autocomplete="off" required value="{{ old('email', $user->email) }}" type="email"
                                name="email" id="email" class="form-control @error('email') is-invalid @enderror" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                            <select required name="user_role" id="user_role" class="form-control col-6">
                                <option value="">Choose Role </option>
                                @foreach ($roles as $role)
                                    <option {{ $cur_role == $role->name ? 'selected' : '' }}
                                        value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">New Password</label>
                        <div class="col-sm-6">
                            <input autocomplete="new-password" data-parsley-minlength="8" data-parsley-equalto="#confirmed"
                                type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" />
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Password Confirmation</label>
                        <div class="col-sm-6">
                            <input autocomplete="off" data-parsley-minlength="8" data-parsley-equalto="#password"
                                type="password" name="confirmed" id="confirmed"
                                class="form-control @error('confirmed') is-invalid @enderror" />
                            @error('confirmed')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group text-right">
                        <input type="submit" class="btn btn-primary" id="edit_user" value="Update User">
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/admin/js/user.js') }}"></script>
@endpush
