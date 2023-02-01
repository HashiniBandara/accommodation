@extends('front.master')

@section('content')
    @include('front.common.sub-banner', [
        'bannerImage' => !empty($pageData['cover_image']) ? $pageData['cover_image'] : '',
        'pageTitle' => !empty($pageData['page_title']) ? $pageData['page_title'] : '',
    ])

    <section class="page-content">
        <div class="container">
            <div class="content-wrapper">
                {!! !empty($pageData['description']) ? $pageData['description'] : '' !!}
            </div>
        </div>
    </section>
@endsection
