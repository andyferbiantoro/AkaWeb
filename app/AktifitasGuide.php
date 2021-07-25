<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AktifitasGuide extends Model
{
    protected $table = "aktifitasguides";
   	protected $fillable = [
       'user_id','nama','nama_aktivitas','tanggal_datang','hari','pukul_datang','pukul_selesai'
    ];
}
