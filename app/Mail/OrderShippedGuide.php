<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Pemesanan;

class OrderShippedGuide extends Mailable
{
    use Queueable, SerializesModels;

     public $pemesanan_pengunjung;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pemesanan_pengunjung)
    {
        $this->pemesanan_pengunjung = $pemesanan_pengunjung;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

       

        return $this->subject('Ada pengunjung baru')
        ->markdown('emails.orders.shippedguide');
    }
}
