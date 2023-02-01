@component('mail::message')

{!! $emailBody !!}

Thanks,<br>
{{ $title }}
@endcomponent
