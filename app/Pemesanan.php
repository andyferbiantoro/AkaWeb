<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
   	protected $table = "pemesanans";
   	protected $fillable = [
       'user_id','paket_id','kategori_pemesanan','tanggal_pemesanan','tanggal_berkunjung','pukul_kunjungan','jumlah_pengunjung','jumlah_pembayaran','status_pemesanan','nomor_pemesanan','jenis_pembayaran','bukti_pelunasan'
    ];
}
