@component('mail::message')

Pembayaran anda telah Terverifikasi dengan nomor pemesanan : {{$pemesanan->nomor_pemesanan}}<br>
Nama Paket Wisata : {{$pemesanan->nama_paket}}<br>
Tanggal Berkunjung : {{date("j F Y", strtotime($pemesanan->tanggal_berkunjung))}}<br>
Pukul Kunjungan : {{date("H:i", strtotime($pemesanan->pukul_kunjungan))}} WIB<br>
Jumlah Anggota : {{$pemesanan->jumlah_pengunjung}} Orang<br>
Jumlah Pembayaran : Rp. <?=number_format($pemesanan->jumlah_pembayaran, 0, ".", ".")?>,00<br><br>

Terima Kasih

<!-- 
   <img height="70" id="myImg"  src="{{asset('uploads/bukti_pelunasan/'.$pemesanan->bukti_pelunasan)}}"></img> -->

<!-- {!! QrCode::size(200)->generate($pemesanan->nomor_pemesanan); !!} -->

@endcomponent
