<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderFinish extends Mailable
{
    use Queueable, SerializesModels;

    public $orderHead;

    public $orderItem;

    public $orderPayment;

    public $customer;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer, $orderHead, $orderItem, $orderPayment)
    {
        $this->customer = $customer;
        $this->orderHead = $orderHead;
        $this->orderItem = $orderItem;
        $this->orderPayment = $orderPayment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Konfirmasi Order '.$this->orderHead->purchase_code)
                ->view('mail.order-finish');
    }
}
