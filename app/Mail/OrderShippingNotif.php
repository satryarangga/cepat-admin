<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderShippingNotif extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $status;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $status)
    {
        $this->order = $order;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Status Pengiriman Order '.$this->order->purchase_code)
                ->view('mail.order-shipping');
    }
}
