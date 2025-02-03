<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AkunDisetujui extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $alasan
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Akun Anda Disetujui')
                    ->view('email.akun_disetujui');
    }
}
