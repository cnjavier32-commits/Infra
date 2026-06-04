<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class PasswordResetOtpMail extends Mailable
{
    public string $otp;
    public string $name;

    public function __construct(
        string $otp,
        string $name
    ) {
        $this->otp = $otp;
        $this->name = $name;
    }

    public function build()
    {
        return $this
            ->subject('Recuperación de contraseña')
            ->view('emails.password-reset-otp');
    }
}