<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
</head>

<body
    style="-webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; margin: 0; padding: 30px 0px 10px; width: 100% !important; background: #fafafa;"
    cz-shortcut-listen="true">
    <!--[if (gte mso 9)|(IE)]>
      <center>
         <table>
            <tr>
               <td width="600">
                  <![endif]-->
    <div class="block">
        <table width="100%"
            style="min-width: 320px; max-width: 700px; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #FFF;"
            cellpadding="0" cellspacing="0" border="0" align="center">
            <tbody>
                <tr>
                    <td align="center" style="border-collapse: collapse;padding-top: 25px;">
                        @if ($email_logo = getSettingValue(config('settings.email_key'), 'email_logo'))
                            <a href="{{ url('') }}">
                                <img src="{!! $email_logo !!}" alt="{{ $title }}" style="max-width: 200px;">
                            </a>
                        @else
                            <h1 style="text-align: center;">{{ $title }}
                            </h1>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="padding: 15px;">{!! $emailBody !!}</td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" bgcolor="#0F1E42" cellpadding="0" cellspacing="0" border="0"
                            style="border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border: solid 1px #eee;">
                            <tbody>
                                <tr>
                                    <td width="100%" height="35" style="border-collapse: collapse;"></td>
                                </tr>
                                <tr>
                                    <td>
                                        @if ($footerTelephoneNumber = getSettingValue(config('settings.email_key'), 'email_footer_contact'))
                                            <p style="color: #FFF;text-align: center;">Hotline :
                                                <a style="color: #FFF;"
                                                    href="tel:{{ $footerTelephoneNumber }}">{{ $footerTelephoneNumber }}</a>
                                            </p>
                                        @endif

                                        @if ($footerEmailAddress = getSettingValue(config('settings.email_key'), 'email_footer_email'))
                                            <div class="contact-item">
                                                <p style="color: #FFF;text-align: center;">Email :
                                                    <a style="color: #FFF;"
                                                        href="mailto:{{ $footerEmailAddress }}">{{ $footerEmailAddress }}</a>
                                                </p>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" height="35" style="border-collapse: collapse;"></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!--[if (gte mso 9)|(IE)]>
               </td>
            </tr>
         </table>
      </center>
      <![endif]-->
</body>

</html>
