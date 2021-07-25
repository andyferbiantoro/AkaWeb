<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
   	protected $table = "pembayarans";
   	protected $fillable = [
       'pemesanan_id','tanggal_pembayaran','metode_pembayaran','status_pembayaran','bukti_pembayaran'
    ];
}
