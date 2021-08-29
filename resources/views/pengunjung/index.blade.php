@extends('layouts.app-master')

@section('title')
Data Pesanan Pengunjung
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
                <!-- <a href="{{ route('pengunjung-tambah_pesanan') }}"><button type="button" style="float: right;" class="btn btn-success right">
                  Tambah pemesanan
                </button></a> -->
               
                <button type="button" style="float: right;" class="btn btn-success right"  data-toggle="modal" data-target="#ModalTambahPemesanan" >
                  Tambah Pemesanan
                </button>
              </div>

              <div class="card-block">

                <div class="row">
                  <div class="col-lg-12">
                    <div class="card-body p-0">
                      <div class="table-responsive">
                        <table id="dataTable" class="table table-hover" >
                          <thead>
                            <tr>
                              <th scope="col">No</th>
                              <th scope="col">Nama Pemesan</th>
                              <th scope="col">Nomor Pemesanan</th>
                              <th scope="col">Nama Paket Wisata</th>
                              <th scope="col">Kategori Pesan </th>
                              <th scope="col">Tanggal Berkunjung</th>
                              <th scope="col">Pukul Kunjungan</th>
                              <th scope="col">Jumlah Anggota</th>
                              <th scope="col">Jenis Pembayaran</th>
                              <th scope="col">Jumlah yang harus dibayar</th>
                              <th scope="col">Aksi</th>
                              <th style="display: none">jumlah bayar (hidden)</th>
                              <th style="display: none">id (hidden)</th>
                            </tr>
                          </thead>

                          <tbody>
                            @php $no=1 @endphp
                            @foreach($data_pemesanan as $pemesanan)
                            <tr>
                              <td>{{$no++}}</td>
                              <td>{{Auth::user()->name}}</td>
                              <td>{{$pemesanan->nomor_pemesanan}}</td>
                              <td>{{$pemesanan->nama_paket}}</td>
                              <td>{{$pemesanan->kategori_pemesanan}}</td>
                              <td>{{date("j F Y", strtotime($pemesanan->tanggal_berkunjung))}}</td>
                              <td>{{date("H:i", strtotime($pemesanan->pukul_kunjungan))}} WIB</td>
                              <td>{{$pemesanan->jumlah_pengunjung}} Orang</td>
                              @if($pemesanan->jenis_pembayaran == 'lunas')
                                <td>Bayar Penuh</td>
                              @endif
                              @if($pemesanan->jenis_pembayaran == 'setengah_bayar')
                                <td>Bayar Setengah</td>
                              @endif
                              <td>Rp. <?=number_format($pemesanan->jumlah_pembayaran, 0, ".", ".")?>,00</td>
                              <td>
                                @if($pemesanan->jenis_pembayaran == 'lunas' && $pemesanan->status_pemesanan == '0')
                                <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$pemesanan->id}})" data-target="#DeleteModal">
                                  <button class="btn btn-danger">Batalkan Pesanan</button>
                                </a>
                                 <button class="btn btn-primary tambahPembayaran">Bayar Sekarang</button>
                                @endif

                                @if($pemesanan->jenis_pembayaran == 'setengah_bayar' && $pemesanan->status_pemesanan == '0')
                                <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$pemesanan->id}})" data-target="#DeleteModal">
                                  <button class="btn btn-danger">Batalkan Pesanan</button>
                                </a>
                               <button class="btn btn-primary tambahPembayaran">Bayar Sekarang</button>
                                @endif

                              
                               

                              </td>
                              <td style="display: none;">{{$pemesanan->jumlah_pembayaran}}</td>
                              <td style="display: none;">{{$pemesanan->id}}</td>
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
          </div>
        </div>
      </div>
      <!-- Page-body end -->
    </div>
    <div id="styleSelector"> </div>
  </div>
</div>





<!-- ============================================================= MODAL TAMBAH PEMESANAN ================================================== -->

<!-- Modal Tambah Pemesanan -->
<div class="modal fade" id="ModalTambahPemesanan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Pemesanan</h5>
      </div>
      <div class="modal-body">
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
              <label style="color: #009970">Jumlah Orang Reguler</label>
              <input type="number" id="jumlah_orang_reguler" name="jumlah_pengunjung" class="form-control" disabled="" required="" oninput="HargaPaketFunction()" placeholder="Hanya untuk pemesanan paket Reguler">
              <span class="form-bar"></span>
            </div>

            <div class="form-group form-success">
              <label style="color: #009970">Jumlah Orang Non-Reguler (Minimal 5 Orang)</label>
              <input type="number" id="jumlah_orang" min="5" name="jumlah_pengunjung"  class="form-control" disabled="" required="" oninput="HargaPaketFunction()" placeholder="Hanya untuk pemesanan paket Non-Reguler">
              <span class="form-bar"></span>
            </div>

            <div class="form-group form-success">
              <label style="color: #009970">Jenis Pembayaran</label>
              <select name="jenis_pembayaran" class="form-control"  disabled="" id="jenis_pembayaran" onchange="JanisBayarFunction()" required>
               <option selected disabled value=""> -- Pilih Jenis Pembayaran -- </option>
               <option value="lunas">Bayar Penuh</option>
               <option value="setengah_bayar">Bayar Setengah</option>
             </select>
             <span class="form-bar"></span>
           </div>

           <div class="form-group">
            <input type="hidden" class="form-control" id="jenis_pembayaran_reguler" disabled="" name="jenis_pembayaran" value="lunas" />
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
     <div class="modal-footer">
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
          <button type="submit" name="" class="btn btn-danger float-right mr-2"  onclick="formSubmit()">Batalkan Pesanan</button>
        </div>
      </div>
    </form>
  </div>
</div> 





<!-- Modal Tambah Pembayran -->
<div id="PembayaranModal" class="modal fade" role="dialog">
  <div class="modal-dialog ">
    <!-- Modal content-->
    <form action="" id="pembayaranForm" method="post"  enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambahkan Pembayaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{ csrf_field() }}
          {{ method_field('POST') }}
         <div class="form-group form-success">
          <label style="color: #009970">Paket Wisata</label>
          <input type="text" id="nama_paket_wisata" class="form-control" readonly="">
          <span class="form-bar"></span>
        </div>

        <div class="form-group">
          <input type="hidden" class="form-control" id="pemesanan_id" name="pemesanan_id" value="{{ Auth::user()->id }}" />
        </div>

         <div class="form-group form-success">
          <label style="color: #009970">Tanggal Pembayaran</label>
          <input type="date" name="tanggal_pembayaran" class="form-control" required="">
          <span class="form-bar"></span>
        </div>


        <div class="form-group form-success">
          <label style="color: #009970">Metode Pembayaran</label>
          <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required="" onchange="MetodePembayaranFunction()">
           <option selected disabled> -- Pilih Metode Pembayaran -- </option>
           <option value="Transfer">Transfer</option>
           <option value="Bayar Ditempat">Bayar Ditempat</option>
         </select>
         <span class="form-bar"></span>
       </div>

       <div class="form-group form-success">
        <label style="color: #009970">Bukti Pembayaran</label>
        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" disabled="" required="" class="form-control">
        <span class="form-bar"></span>
      </div>


      <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Batal</button>
      <button type="submit" name="" class="btn btn-info float-right mr-2"  onclick="pembayaranForm()">Submit</button>
    </div>
  </div>
</form>
</div>
</div> 







<!-- Modal pelunasan -->
<div id="PelunasanModal" class="modal fade" role="dialog">
  <div class="modal-dialog ">
    <!-- Modal content-->
    <form action="" id="pelunasanForm" method="post" enctype="multipart/form-data">

      <div class="modal-content">
        <div class="modal-header">

          <h5 class="modal-title">Lakukan Pelunasan </h5>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{ csrf_field() }}
          {{ method_field('POST') }}

          <div class="input-group">
            <input name="jumlah_pembayaran" id="jml_pembayaran" type="text" class="form-control" placeholder="Jumlah Pembayaran" required="">
          </div>

          <div class="form-group form-success">
            <label style="color: #009970">Bukti Pelunasan</label>
            <input type="file" name="bukti_pelunasan" id="bukti_pelunasan" class="form-control">
            <span class="form-bar"></span>
          </div>

          <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Batal</button>
          <button type="submit" name="" class="btn btn-info float-right mr-2"  onclick="pelunasanForm()">Lunasi</button>
        </div>
      </div>
    </form>
  </div>
</div> 





@section('js')
  <script>
  var harga;
  var harga_total;

  function KategoriFunction() {
    var kategori_pemesanan = document.getElementById("kategori_pemesanan").value;
    var paket_wisata = document.querySelector("#paket_wisata");
    var reguler_paket = document.querySelector("#reguler_paket");
    var jenis_pembayaran = document.querySelector("#jenis_pembayaran");
    var jenis_pembayaran_reguler = document.querySelector("#jenis_pembayaran_reguler");
    var jumlah_orang_reguler = document.querySelector("#jumlah_orang_reguler");
    var jumlah_orang = document.querySelector("#jumlah_orang");

    if(kategori_pemesanan == "reguler"){
     paket_wisata.setAttribute("disabled", "");//menambahkan atribut disabled di form jika pilih paket reguler
     jenis_pembayaran_reguler.removeAttribute("disabled");
     jenis_pembayaran.setAttribute("disabled","");
     reguler_paket.removeAttribute("disabled");
     jumlah_orang_reguler.removeAttribute("disabled");
     jumlah_orang.setAttribute("disabled", "");
     document.getElementById("jumlah_bayar").value = 5000;//jumlah bayar auto 5000
     document.getElementById("jumlah_orang_reguler").value = 1;
   }else {
    paket_wisata.removeAttribute("disabled");//atribud disabled dihilangkan jika pilih jenis paket non-reguler
    jenis_pembayaran.removeAttribute("disabled");
    jenis_pembayaran_reguler.setAttribute("disabled","");
    reguler_paket.setAttribute("disabled","");
    jumlah_orang.removeAttribute("disabled");
    jumlah_orang_reguler.setAttribute("disabled", "");
    document.getElementById("jenis_pembayaran").selectedIndex = "";
    document.getElementById("jumlah_bayar").value = "";
    document.getElementById("jumlah_orang").value = "";
    document.getElementById("jumlah_orang_reguler").value = "";
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
    document.getElementById("jenis_pembayaran").selectedIndex = "";
  })
}


function HargaPaketFunction(){
  var jml_org = document.getElementById("jumlah_orang").value;
  if (jml_org >= 10) {
    harga_total = (harga.paket.harga_paket * jml_org) * (9/10)
    document.getElementById("jumlah_bayar").value = harga_total;
    document.getElementById("jenis_pembayaran").selectedIndex = "";
  }else {
    harga_total = harga.paket.harga_paket * jml_org
    document.getElementById("jumlah_bayar").value = harga_total;
    document.getElementById("jenis_pembayaran").selectedIndex = "";

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


function MetodePembayaranFunction(){
var metode_pembayaran = document.getElementById("metode_pembayaran").value;
var bukti_pembayaran = document.querySelector("#bukti_pembayaran");

if(metode_pembayaran == "Transfer"){    
     bukti_pembayaran.removeAttribute("disabled");
   }else{
    bukti_pembayaran.setAttribute("disabled", "");
   }
}
</script>


  <script type="text/javascript">
  function deleteData(id) {
    var id = id;
    var url = '{{route("pengunjung-batalkan_pesanan", ":id") }}';
    url = url.replace(':id', id);
    $("#deleteForm").attr('action', url);
  }

  function formSubmit() {
    $("#deleteForm").submit();
  }
</script>

<script>
  $(document).ready(function() {
    var table = $('#dataTable').DataTable();
    table.on('click', '.lunasi', function() {
      $tr = $(this).closest('tr');
      if ($($tr).hasClass('child')) {
        $tr = $tr.prev('.parent');
      }
      var data = table.row($tr).data();
      console.log(data);
      $('#jml_pembayaran').val(data[11]);
      $('#bukti_pelunasan');
      $('#pelunasanForm').attr('action','pengunjung-pelunasan_pembayaran/'+ data[12]);
      $('#PelunasanModal').modal('show');
    });
  });


//Tambah Pembayaran
   $(document).ready(function() {
    var table = $('#dataTable').DataTable();
    table.on('click', '.tambahPembayaran', function() {
      $tr = $(this).closest('tr');
      if ($($tr).hasClass('child')) {
        $tr = $tr.prev('.parent');
      }
      var data = table.row($tr).data();
      console.log(data);
      $('#pemesanan_id').val(data[12]);
      $('#nama_paket_wisata').val(data[3]);
      $('#pembayaranForm').attr('action','pengunjung-proses_tambah_pembayaran');
      $('#PembayaranModal').modal('show');
    });
  });
</script>

  @endsection
  @endsection
