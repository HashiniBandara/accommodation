@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @php
        $title = (getSettingValue(config('settings.theme_key'), 'site_title')) ?? $title;
        @endphp
        @component('mail::header', ['url' => url(''), 'title' => $title])
            {{$title}}
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ $title }}. @lang('All rights reserved.')
        @endcomponent
    @endslot
@endcomponent
