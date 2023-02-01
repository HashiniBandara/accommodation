<section class="sub-page-banner">
    @php
        $title = !empty($title) ? $title : $pageTitle;
    @endphp
    @if ($bannerImage)
        <img src="{!! $bannerImage !!}" alt="{{ $pageTitle }}" class="full-image">
    @endif
    <div class="container">
        <div class="banner-content">
            <div class="breadcrumbs">
                @if (!empty($breadcrumbObject))
                    {{ Breadcrumbs::render(Route::currentRouteName(), $breadcrumbObject) }}
                @else
                    {{ Breadcrumbs::render(Route::currentRouteName(), $title) }}
                @endif
            </div>
            <h1>{{ $title }}</h1>
        </div>
    </div>
</section>
