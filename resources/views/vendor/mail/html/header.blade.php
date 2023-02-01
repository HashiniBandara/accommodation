<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if ($email_logo = getSettingValue(config('settings.email_key'), 'email_logo'))
                <img src="{!! $email_logo !!}"
                    alt="{{ $title }}"
                    style="max-width: 200px;">
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
