@extends('admin.templates.master')

@php
$settingsSeperator = config('settings.separator');
@endphp

@section('content')

    @include('admin.global.alert') {{-- Form validation messages --}}

    <div class="row" data-sticky-container>
        <div class="col-sm-12 col-lg-3">
            <div class="card card-custom" data-sticky="true" data-margin-top="150">
                <div class="card-header">
                    <h3 class="card-title">Add menu items</h3>
                </div>
                <div class="card-body">
                    <div class="accordion accordion-solid accordion-toggle-plus" id="navigationMain">

                        <div class="card">
                            <div class="card-header" id="headingItineraries">
                                <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseItineraries">
                                    Itineraries
                                </div>
                            </div>
                            <div id="collapseItineraries" class="collapse" data-parent="#navigationMain">
                                <div class="card-body">
                                    <div class="form-group">
                                        @php $selected= old('itineraries', []) @endphp
                                        @isset($itineraries)
                                            <select name="itineraries" id="itineraries" class="select-2 nav-select"
                                                data-type="itinerary" data-name="Itinerary">
                                                <option value="">Select itinerary</option>
                                                @foreach ($itineraries as $itinerary)
                                                    <option value="{{ $itinerary->id }}">
                                                        {{ $itinerary->name }}</option>
                                                @endforeach
                                            </select>
                                        @endisset
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="button" class="btn btn-primary nav-add-btn">Add
                                            itinerary</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingItineraryCategories">
                                <div class="card-title collapsed" data-toggle="collapse"
                                    data-target="#collapseItineraryCategories">
                                    Itinerary Categories
                                </div>
                            </div>
                            <div id="collapseItineraryCategories" class="collapse" data-parent="#navigationMain">
                                <div class="card-body">
                                    <div class="form-group">
                                        @php $selected= old('itineraryCategories', []) @endphp
                                        @isset($itineraryCategories)
                                            <select name="itineraryCategories" id="itineraryCategories"
                                                class="select-2 nav-select" data-type="itineraryCategories"
                                                data-name="Itinerary Category">
                                                <option value="">Select category</option>
                                                @foreach ($itineraryCategories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        @endisset
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="button" class="btn btn-primary nav-add-btn">Add
                                            itinerary category</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingAccommodations">
                                <div class="card-title collapsed" data-toggle="collapse"
                                    data-target="#collapseAccommodations">
                                    Accommodations
                                </div>
                            </div>
                            <div id="collapseAccommodations" class="collapse" data-parent="#navigationMain">
                                <div class="card-body">
                                    <div class="form-group">
                                        @php $selected= old('accommodations', []) @endphp
                                        @isset($accommodations)
                                            <select name="accommodations" id="accommodations" class="select-2 nav-select"
                                                data-type="accommodation" data-name="Accommodation">
                                                <option value="">Select Accommodation</option>
                                                @foreach ($accommodations as $accommodation)
                                                    <option value="{{ $accommodation->id }}">
                                                        {{ $accommodation->name }}</option>
                                                @endforeach
                                            </select>
                                        @endisset
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="button" class="btn btn-primary nav-add-btn">Add
                                            accommodation</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingAccommodationCategories">
                                <div class="card-title collapsed" data-toggle="collapse"
                                    data-target="#collapseAccommodationCategories">
                                    Accommodation Categories
                                </div>
                            </div>
                            <div id="collapseAccommodationCategories" class="collapse" data-parent="#navigationMain">
                                <div class="card-body">
                                    <div class="form-group">
                                        @php $selected= old('accommodationCategories', []) @endphp
                                        @isset($accommodationCategories)
                                            <select name="accommodationCategories" id="accommodationCategories"
                                                class="select-2 nav-select" data-type="accommodationCategories"
                                                data-name="Accommodation Category">
                                                <option value="">Select category</option>
                                                @foreach ($accommodationCategories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        @endisset
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="button" class="btn btn-primary nav-add-btn">Add
                                            accommodation category</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingActivities">
                                <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseActivities">
                                    Activities
                                </div>
                            </div>
                            <div id="collapseActivities" class="collapse" data-parent="#navigationMain">
                                <div class="card-body">
                                    <div class="form-group">
                                        @php $selected= old('activities', []) @endphp
                                        @isset($activities)
                                            <select name="activities" id="activities" class="select-2 nav-select"
                                                data-type="activity" data-name="Activity">
                                                <option value="">Select Activity</option>
                                                @foreach ($activities as $activity)
                                                    <option value="{{ $activity->id }}">
                                                        {{ $activity->name }}</option>
                                                @endforeach
                                            </select>
                                        @endisset
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="button" class="btn btn-primary nav-add-btn">Add
                                            activity</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingActivityCategories">
                                <div class="card-title collapsed" data-toggle="collapse"
                                    data-target="#collapseActivityCategories">
                                    Activity Categories
                                </div>
                            </div>
                            <div id="collapseActivityCategories" class="collapse" data-parent="#navigationMain">
                                <div class="card-body">
                                    <div class="form-group">
                                        @php $selected= old('activityCategories', []) @endphp
                                        @isset($activityCategories)
                                            <select name="activityCategories" id="activityCategories"
                                                class="select-2 nav-select" data-type="activityCategories"
                                                data-name="Activity Category">
                                                <option value="">Select category</option>
                                                @foreach ($activityCategories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        @endisset
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="button" class="btn btn-primary nav-add-btn">Add
                                            itinerary category</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingDestinations">
                                <div class="card-title collapsed" data-toggle="collapse"
                                    data-target="#collapseDestinations">
                                    Destinations
                                </div>
                            </div>
                            <div id="collapseDestinations" class="collapse" data-parent="#navigationMain">
                                <div class="card-body">
                                    <div class="form-group">
                                        @php $selected= old('destinations', []) @endphp
                                        @isset($destinations)
                                            <select name="destinations" id="destinations" class="select-2 nav-select"
                                                data-type="destination" data-name="Destination">
                                                <option value="">Select Destination</option>
                                                @foreach ($destinations as $destination)
                                                    <option value="{{ $destination->id }}">
                                                        {{ $destination->name }}</option>
                                                @endforeach
                                            </select>
                                        @endisset
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="button" class="btn btn-primary nav-add-btn">Add
                                            destination</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingDestinationCategories">
                                <div class="card-title collapsed" data-toggle="collapse"
                                    data-target="#collapseDestinationCategories">
                                    Destination Categories
                                </div>
                            </div>
                            <div id="collapseDestinationCategories" class="collapse" data-parent="#navigationMain">
                                <div class="card-body">
                                    <div class="form-group">
                                        @php $selected= old('destinationCategories', []) @endphp
                                        @isset($destinationCategories)
                                            <select name="destinationCategories" id="destinationCategories"
                                                class="select-2 nav-select" data-type="destinationCategories"
                                                data-name="Destination Category">
                                                <option value="">Select category</option>
                                                @foreach ($destinationCategories as $category)
                                                    <option value="{{ $category->id }}">
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        @endisset
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="button" class="btn btn-primary nav-add-btn">Add
                                            itinerary category</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingOtherPages">
                                <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseOtherPages">
                                    Other Pages
                                </div>
                            </div>
                            <div id="collapseOtherPages" class="collapse" data-parent="#navigationMain">
                                <div class="card-body">
                                    <div class="form-group">
                                        <select name="otherPages" id="otherPages" class="select-2 nav-select"
                                            data-type="other" data-name="Other">
                                            <option value="">Select Page</option>
                                            @foreach ($otherPages as $key => $page)
                                                <option value="{{ $key }}">{{ $page }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="button" class="btn btn-primary nav-add-btn">Add
                                            other page</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" id="headingOne4">
                                <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseOne4">
                                    Custom Link
                                </div>
                            </div>
                            <div id="collapseOne4" class="collapse" data-parent="#navigationMain">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="navCustomLink">Title</label>
                                        <input type="text" name="navCustomLinkTitle" id="navCustomLinkTitle"
                                            class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="navCustomLink">Link</label>
                                        <input type="text" name="navCustomLinkUrl" id="navCustomLinkUrl"
                                            class="form-control" placeholder="http://">
                                    </div>
                                    <div class="form-group">
                                        <label for="navCustomLink">Target</label>
                                        <select name="navCustomLinkTarget" id="navCustomLinkTarget" class="form-control">
                                            <option value="_self">Self</option>
                                            <option value="_blank">Blank</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-0">
                                        <button type="button" class="btn btn-primary" id="addNavCustom">Add Link</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-9">
            <div class="card card-custom">
                <div class="card-header">
                    <h3 class="card-title">Menu items</h3>
                </div>
                <form id="navigationForm" action="{{ route(SettingsRoutePath::SAVE) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <ul class="menu-items list-unstyled draggable-zone draggableMenu mr-10" id="draggableMenu">
                            {{-- {{ $navHTMLList }} --}}
                            {!! $navHTMLList !!}
                        </ul>
                        <button class="btn btn-primary">Update Navigation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="navEditModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Nav Link</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-12">
                            <div class="form-group">
                                <label for="nav_title" class="col-form-label required">Title</label>
                                <input autocomplete="off" type="text" id="editNavTitle" class="form-control" />
                                <span id="editNavTitleMsg"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="text-right">
                            <button data-dismiss="modal" type="button" class="btn btn-secondary">Cancel</button>
                            <button id="editNavTitleBtn" type="button" class="btn btn-primary ml-5">Update</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    @endsection

    @push('scripts')
        <script>
            var uploadUrl = "navigation";
            var moduleKey = "{{ config('settings.theme_key') }}";
        </script>
        <script src="{{ assets_path('assets/admin/js/jquery-sortable-lists-mobile.js') }}" type="text/javascript"></script>
        <script src="{{ assets_path('assets/admin/js/navigation.js') }}" type="text/javascript"></script>
    @endpush
