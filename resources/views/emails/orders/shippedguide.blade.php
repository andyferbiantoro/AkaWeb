@component('mail::message')

Mohon dengan segera mempersiapkan diri memandu pengunjung dengan : <br>
Nomor Pemesanan : {{$pemesanan_pengunjung->nomor_pemesanan}}<br>
Nama Pemesan : {{$pemesanan_pengunjung->name}}<br>
Tanggal Berkunjung : {{date("j F Y", strtotime($pemesanan_pengunjung->tanggal_berkunjung))}}<br>
Pukul Kunjungan : {{date("H:i", strtotime($pemesanan_pengunjung->pukul_kunjungan))}} WIB<br>
Jumlah Anggota : {{$pemesanan_pengunjung->jumlah_pengunjung}} Orang<br><br>

Terima Kasih


@endcomponent
