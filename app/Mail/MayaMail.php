<?php

namespace App\Mail;

use App\Repositories\SettingsRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class MayaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailSubject;

    public $emailBody;

    public $settingsRepository;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailSubject, $emailBody)
    {
        $this->emailBody = $emailBody;

        $this->emailSubject = $emailSubject;

        $this->settingsRepository = App::make(SettingsRepository::class);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = ($this->settingsRepository->getValue(config('settings.theme_key'), 'site_title')) ?? config('app.name');

        $from_name = ($this->settingsRepository->getValue(config('settings.email_key'), 'from_name')) ?? env('MAIL_FROM_NAME', '');

        $from_email = env('MAIL_FROM_ADDRESS', '');

        return $this->subject($this->emailSubject)
            ->from($from_email, $from_name)
            ->markdown('mail.template')
            ->with([
                'emailBody' => $this->emailBody,
                'title'     => $title
            ]);
    }
}
