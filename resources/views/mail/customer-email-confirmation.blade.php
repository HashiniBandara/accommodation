<h2 style="margin-bottom: 20px">Email Confirmation</h2>
@if ($siteLogo = getSettingValue(config('settings.theme_key'), 'site_logo'))
    <img alt="Logo" src="{{ $siteLogo }}" style="max-width: 250px; width: 100%;display: block;" />
@endif
<p style="margin-top: 20px">Hello {{$first_name}} {{$last_name}},</p>
<p>You must confirm your <b>{{$email}}</b> email before you can sign in (link is only valid once):</p>
<div style="text-align: center">
    <a href="{{route('customer.email.confirm',['code'=>$code, 'email'=>$email])}}" style="background-color:#1d71ab;color:#fff;text-decoration:none;border-radius:0;border:1px solid #1d71ab;display:inline-block;font-size:14px;padding:7px 15px" target="_blank"><span>Confirm</span> Your Account</a>
</div>
