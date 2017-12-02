<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PartnerNotif extends Mailable
{
    use Queueable, SerializesModels;

    public $partner;
    public $type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($partner, $type)
    {
        $this->partner = $partner;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Registrasi Akun Partner Cepat Cepat E-Commerce')
                ->view('mail.partner');
    }
}
