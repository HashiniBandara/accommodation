@extends('admin.templates.master')

@section('content')
    <div class="col-sm-12 col-lg-10">

        <a class="btn btn-dark btn-pill btn-sm mb-5"
            href="{{ route(AdminServiceProvider::ACCOMMODATION_DETAILS_CREATE_ROUTE) }}"><i class="fas fa-chevron-left"></i>
            Back to Accommodation View</a>

        @include('admin.global.alert') {{-- Form validation messages --}}

        <form method="POST" class="custom-validation" data-parsley-validate id="accommodation_detail_form"
            action="{{ route(AdminServiceProvider::ACCOMMODATION_DETAILS_SUBMIT_ROUTE) }}">
            @csrf
            {{-- <input type="hidden" id="new_user" value="1"> --}}

            <div class="card mb-10 card-custom">
                <div class="card-body">

                    <div class="form-group row">
                        <label for="" class="col-sm-3 col-form-label">Accommodation Type</label>
                        <div class="col-sm-9">
                            <select required name="accommodation_id" id="accommodation_id" class="form-control col-6">
                                <option value="">{{ $accommodation_detail->accommodation_id }}</option>
                                {{-- @foreach ($accommodation_type as $accommodation_types)
                                    <option value="{{ $accommodation_types->id }}">{{ $accommodation_types->accommodation_type }}</option>
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
                                data-parsley-minlength="3" data-parsley-maxlength="30" value="{{ $accommodation_detail->title }}"
                                type="text" name="title" id="title"
                                class="form-control @error('title') is-invalid @enderror" />
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
                            <input autocomplete="off" value="{{ $accommodation_detail->banner }}"
                                type="file" name="banner" id="banner"
                                class="form-control @error('banner') is-invalid @enderror" />
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
                            <input autocomplete="off" required value="{{ $accommodation_detail->description }}" type="text" row="3" name="description"
                                id="description" class="form-control @error('description') is-invalid @enderror" />
                                <textarea name="description" class="form-control" id="description" cols="30" rows="3"></textarea>
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
                            <input autocomplete="off" value="{{ old('gallery') }}"
                                type="file" name="gallery[]" id="gallery"
                                class="form-control @error('gallery') is-invalid @enderror" />
                            @error('gallery')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>




                    <div class="form-group text-right">
                        <input type="submit" class="btn btn-primary" id="save" value="Add Accommodation Details">
                    </div>
                </div>
            </div>
        </form>

        <div class="card mb-10 card-custom">
            <div class="card-body">
            </div>
        </div>

    </div>
@endsection

@push('styles')
    <link href="{{ asset('metronic/plugins/custom/jstree/jstree.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
    <script src="{{ asset('metronic/plugins/custom/jstree/jstree.bundle.js') }}"></script>
    <script src="{{ asset('assets/admin/js/accommodation_type.js') }}"></script>
@endpush
