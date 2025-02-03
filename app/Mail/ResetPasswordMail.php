<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class ResetPasswordMail extends Mailable
{
    use SerializesModels;

    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function build()
    {
        $url = URL::route('password.reset', ['token' => $this->token, 'email' => $this->email]);

        return $this->subject('Reset Password Anda')
                    ->view('email.email')  // Gunakan template kustom di auth/email.blade.php
                    ->with([
                        'resetLink' => $url,  // Kirimkan URL reset password ke view
                    ]);
    }

}
