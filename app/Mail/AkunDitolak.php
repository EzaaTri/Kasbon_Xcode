<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AkunDitolak extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $alasan;

    /**
     * Create a new message instance.
     *
     * @param $user
     * @param $alasan
     * @return void
     */
    public function __construct($user, $alasan)
    {
        $this->user = $user;
        $this->alasan = $alasan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Akun Anda Ditolak')
                    ->view('email.akun_ditolak');
    }
}
