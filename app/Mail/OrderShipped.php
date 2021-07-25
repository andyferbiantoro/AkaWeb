<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $konfirmasi_pembayaran;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($konfirmasi_pembayaran)
    {
        $this->konfirmasi_pembayaran = $konfirmasi_pembayaran;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Berhasil melakukan pembayaran')
        ->markdown('emails.orders.shipped');
    }
}
