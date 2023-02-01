@extends('admin.templates.master')

@section('content')

    <div class="col-sm-12 col-lg-10">
        @include('admin.global.alert') {{-- Form validation messages --}}

        <form method="POST"  class="custom-validation" data-parsley-validate id="edit_user_form" action="{{ route(AdminServiceProvider::USER_EDIT_SUBMIT_ROUTE) }}">
            @csrf
            <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
            <input type="hidden"  id="update_user" value="1">

            <div class="card mb-10 card-custom">
                <div class="card-body">

                    <input style="display: none" type="checkbox" name="user_status" id="user_status"  {{($user->status == STATUS_ACTIVE) ? 'checked' : ''}}>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">First Name</label>
                        <div class="col-sm-9">
                            <input autocomplete="off" required data-parsley-pattern="^[a-zA-Z- ]+$" data-parsley-minlength="2" data-parsley-maxlength="30" value="{{ old('first_name',$user->first_name) }}" type="text" name="first_name" id="first_name"
                                class="form-control @error('first_name') is-invalid @enderror" />
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
                            <input autocomplete="off" required data-parsley-pattern="^[a-zA-Z- ]+$" data-parsley-minlength="2" data-parsley-maxlength="30" value="{{ old('last_name',$user->last_name) }}" type="text" name="last_name" id="last_name"
                                class="form-control @error('last_name') is-invalid @enderror" />
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Profile Image</label>
                        <div class="col-sm-9">
                            <?php $user_image = old('user_image',$user->profile_pic);
                            ?>
                            <div
                                class="dropzone dropzone-default dropzone-primary image-dropzone-profile {{ $user_image ? 'd-none' : '' }}">
                                <div class="dropzone-msg dz-message needsclick">
                                    <h3 class="dropzone-msg-title mb-3">Drop files here or click to upload.</h3>
                                    <p>Allowed File Types: jpg, jpeg, png</p>
                                    <p>Maximum file size allowed: 2MB</p>
                                </div>
                            </div>
                            <div class="dropzone-image">
                                <?php if ($user_image): ?>
                                <img src="<?php echo $user_image; ?>" alt=""><a
                                    href="#" class="image-remove remove-upload-image">X</a>
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="user_image" class="dropzone-value"
                                value="{{ $user_image }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input autocomplete="off" required value="{{ old('email',$user->email) }}" type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    @if (AdminServiceProvider::getAuthUser()->is_super_admin != "1")
                        <div class="form-group row">
                            <label for="" class="col-sm-3 col-form-label">Role</label>
                            <div class="col-sm-9">
                                <select required name="user_role" id="user_role" class="form-control col-6">
                                    <option value="">Choose Role </option>
                                    @foreach ($roles as $role)
                                        <option {{($cur_role == $role->name) ? 'selected' : ''}} value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="user_role" id="user_role" value="{{$cur_role}}">
                    @endif
                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">New Password</label>
                        <div class="col-sm-6">
                            <input  autocomplete="new-password" data-parsley-minlength="8" data-parsley-equalto="#confirmed" type="password" name="password" id="password"
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
                            <input autocomplete="off" data-parsley-minlength="8" data-parsley-equalto="#password" type="password" name="confirmed" id="confirmed"
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
