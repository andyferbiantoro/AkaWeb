@extends('layouts.app-master')

@section('title')
Tambah Pesanan Pengunjung
@endsection


@section('content')

<!-- Page-header start --> 

@if (session('success'))
<div class="alert alert-success">
  {{ session('success') }}
</div>
@endif
<!-- Page-header end -->
<div class="pcoded-inner-content">
  <!-- Main-body start -->
  <div class="main-body">
    <div class="page-wrapper">
      <!-- Page-body start -->
      <div class="page-body">

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5>Tambah Pemesanan</h5>
              </div>

              <div class="card-block">
                <form class="form-material"  action="{{route('pengunjung-proses_tambah_pesanan')}}" method="post" enctype="multipart/form-data">
                 {{csrf_field()}}
                 <div class="form-group form-success">
                  <label style="color: #009970">Nama Pemesan</label>
                  <input type="text" class="form-control" value="{{Auth::user()->name}}" required="">
                  <span class="form-bar"></span>
                </div>

                <div class="form-group form-success">
                  <label style="color: #009970">Kategori Pesan</label>
                  <select name="kategori_pemesanan" class="form-control" required="" id="kategori_pemesanan" onchange="KategoriFunction()">
                   <option selected disabled> -- Pilih Kategori Pesan -- </option>
                   <option value="reguler">Reguler</option>
                   <option value="non-reguler">Non-Reguler</option>
                 </select>
                 <span class="form-bar"></span>
               </div>

               <div class="form-group form-success">
                <label style="color: #009970">Nama Paket</label>
                <select name="paket_id" id="paket_wisata" class="form-control" disabled="" required="" onchange="PaketFunction()">
                 <option selected disabled> -- Pilih Paket Wisata -- </option>
                 @foreach($data_paket as $paket)
                 <option value="{{$paket->id}}">{{$paket->nama_paket}}</option>
                 @endforeach
               </select>
               <span class="form-bar"></span>
             </div>

             <div class="form-group">
              <input type="hidden" class="form-control" id="reguler_paket" name="paket_id" value="1"  disabled="" />
            </div>


            <div class="form-group form-success">
              <label style="color: #009970">Tanggal Kunjungan</label>
              <input type="date" name="tanggal_berkunjung" class="form-control" required="">
              <span class="form-bar"></span>
            </div>

            <div class="form-group form-success">
              <label style="color: #009970">Pukul Kunjungan</label>
              <input type="time" min="08:00" max="16:00" name="pukul_kunjungan" class="form-control" required="">
              <span class="form-bar validity"></span>
            </div>

            <div class="form-group form-success">
              <label style="color: #009970">Jumlah Orang</label>
              <input type="number" id="jumlah_orang" name="jumlah_pengunjung" class="form-control" required="" oninput="HargaPaketFunction()">
              <span class="form-bar"></span>
            </div>

            <div class="form-group form-success">
              <label style="color: #009970">Jenis Pembayaran</label>
              <select name="jenis_pembayaran" class="form-control" required="" disabled="" id="jenis_pembayaran" onchange="JanisBayarFunction()">
               <option selected disabled value="0"> -- Pilih Jenis Pembayaran -- </option>
               <option value="lunas">Lunas</option>
               <option value="setengah_bayar">Setengah Bayar</option>
             </select>
             <span class="form-bar"></span>
           </div>

           <div class="form-group form-success">
            <label style="color: #009970">Jumlah Bayar</label>
            <input type="number" id="jumlah_bayar" readonly="" name="jumlah_pembayaran" class="form-control" required="">
            <span class="form-bar"></span>
          </div>

          <div class="form-group">
            <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" />
          </div>

          <div class="row m-t-30">
            <div class="col-md-3">
              <button type="submit" class="btn btn-success btn-md btn-block waves-effect text-center m-b-20">Submit</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
</div>
<!-- Page-body end -->
</div>
<div id="styleSelector"> </div>
</div>
</div>

<script>
  var harga;
  var harga_total;

  function KategoriFunction() {
    var kategori_pemesanan = document.getElementById("kategori_pemesanan").value;
    var paket_wisata = document.querySelector("#paket_wisata");
    var reguler_paket = document.querySelector("#reguler_paket");
    var jenis_pembayaran = document.querySelector("#jenis_pembayaran");

    if(kategori_pemesanan == "reguler"){
     paket_wisata.setAttribute("disabled", "");//menambahkan atribut disabled di form jika pilih paket reguler
     document.getElementById("jenis_pembayaran").selectedIndex = "1";
     jenis_pembayaran.removeAttribute("disabled");
     reguler_paket.removeAttribute("disabled");
     document.getElementById("jumlah_bayar").value = 5000;//jumlah bayar auto 5000
     document.getElementById("jumlah_orang").value = 1;
   }else {
    paket_wisata.removeAttribute("disabled");//atribud disabled dihilangkan jika pilih jenis paket non-reguler
    jenis_pembayaran.removeAttribute("disabled");
    document.getElementById("jenis_pembayaran").selectedIndex = "0";
    document.getElementById("jumlah_bayar").value = "";
    document.getElementById("jumlah_orang").value = "";
  }
}

function PaketFunction(){
  var paket_wisata = document.getElementById("paket_wisata").value;
  fetch("/pengunjung-get_paket_wisata/"+ paket_wisata )
  .then(response => response.json())
  .then(data => harga = data)
  .then(() => {
    document.getElementById("jumlah_orang").value = 1;
    harga_total = harga.paket.harga_paket;
    document.getElementById("jumlah_bayar").value = harga_total;
    document.getElementById("jenis_pembayaran").selectedIndex = "0";
  })
}


function HargaPaketFunction(){
  var jml_org = document.getElementById("jumlah_orang").value;
  if (jml_org >= 10) {
    harga_total = (harga.paket.harga_paket * jml_org) * (9/10)
    document.getElementById("jumlah_bayar").value = harga_total;
    document.getElementById("jenis_pembayaran").selectedIndex = "0";
  }else {
    harga_total = harga.paket.harga_paket * jml_org
    document.getElementById("jumlah_bayar").value = harga_total;
    document.getElementById("jenis_pembayaran").selectedIndex = "0";

  }
}

function JanisBayarFunction(){
 var jenis_bayar = document.getElementById("jenis_pembayaran").value;

 if (jenis_bayar == "setengah_bayar") {
   document.getElementById("jumlah_bayar").value = harga_total / 2;
 }else {
   document.getElementById("jumlah_bayar").value = harga_total;
 }
}
</script>


@endsection
