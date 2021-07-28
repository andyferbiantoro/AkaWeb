@extends('layouts.app-master')

@section('title')
Data Pemesanan
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
                                <h5>Data Pemesanan</h5>
                                <button type="button" style="float: right;" class="btn btn-success right"  data-toggle="modal" data-target="#ModalTambahPemesanan" >
                                    Tambah Pemesanan
                                </button>
                            </div>

                            <div class="card-block">
                               <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama Pemesan</th>
                                            <th scope="col">Nama paket</th>
                                            <th scope="col">Kategori Pesanan</th>
                                            <th scope="col">Tanggal Pemesanan</th>
                                            <th scope="col">Tanggal Berkunjung</th>
                                            <th scope="col">Pukul Kunjungan</th>
                                            <th scope="col">Jumlah Pengunjung</th>
                                            <th scope="col">Jumlah Pembayaran</th>
                                            <th scope="col">Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=1 @endphp
                                        @foreach($data_pemesanan as $pemesanan)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{$pemesanan->name}}</td>
                                            <td>{{$pemesanan->nama_paket}}</td>
                                            <td>{{$pemesanan->kategori_pemesanan}}</td>
                                            <td>{{date("j F Y", strtotime($pemesanan->created_at))}}</td>
                                            <td>{{date("j F Y", strtotime($pemesanan->tanggal_berkunjung))}}</td>
                                            <td>{{date("H:i", strtotime($pemesanan->pukul_kunjungan))}} WIB</td>
                                            <td>{{$pemesanan->jumlah_pengunjung}} Orang</td>
                                            <td>Rp. <?=number_format($pemesanan->jumlah_pembayaran, 0, ".", ".")?>,00</td>
                                            <td>
                                                @if($pemesanan->status_pemesanan == 0)
                                                <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$pemesanan->id}})" data-target="#DeleteModal">
                                                    <button class="btn btn-danger btn-sm">Batalkan Pesanan</button>
                                                </a>
                                                <a href="{{ route('admin-data_pembayaran_pengunjung') }}"><button class="btn btn-warning btn-sm">Pembayaran</button></a>
                                                @endif

                                                @if($pemesanan->status_pemesanan == 1)
                                                    <button class="btn btn-success btn-sm">Pesanan Berhasil</button>
                                                @endif
                                            </td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
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


<!-- Modal -->
<div class="modal fade" id="ModalTambahPemesanan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Pemesanan</h5>

    </div>
    <div class="modal-body">
     <form class="form-material"  action="{{route('admin-proses_tambah_pesanan')}}" method="post" enctype="multipart/form-data">
                 {{csrf_field()}}
                

                    <div class="form-group form-success">
                    <label style="color: #009970">Nama Pengunjung</label>
                    <select name="user_id" id="pengunjung" class="form-control" required="">
                     <option selected disabled> -- Pilih Nama Pengunjung -- </option>
                     @foreach($data_pengunjung as $pengunjung)
                     <option value="{{$pengunjung->id}}">{{$pengunjung->name}}</option>
                     @endforeach
                   </select>
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

          

          <div class="row m-t-30">
            <div class="col-md-3">
              <button type="submit" class="btn btn-success btn-md btn-block waves-effect text-center m-b-20">Submit</button>
            </div>
          </div>

        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>

    </div>
</div>
</div>
</div>

<!-- Modal konfirmasi Hapus -->
<div id="DeleteModal" class="modal fade" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <form action="" id="deleteForm" method="post">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Batalkan Pesanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                    <p>Apakah anda yakin ingin membatalkan pesanan ini ?</p>
                    <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Kembali</button>
                    <button type="submit" name="" class="btn btn-danger float-right mr-2" data-dismiss="modal" onclick="formSubmit()">Batalkan Pesanan</button>
                </div>
            </div>
        </form>
    </div>
</div> 

<script type="text/javascript">
    function deleteData(id) {
        var id = id;
        var url = '{{route("admin-batalkan_pesanan", ":id") }}';
        url = url.replace(':id', id);
        $("#deleteForm").attr('action', url);
    }

    function formSubmit() {
        $("#deleteForm").submit();
    }
</script>

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
