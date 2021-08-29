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
                      <th style="display: none;">id</th>
                      <th scope="col">Nama Pemesan</th>
                      <th scope="col" style="display: none;">Nama paket</th>
                      <th scope="col" style="display: none;">Kategori Pesanan</th>
                      <th scope="col" style="display: none">Tanggal Pemesanan</th>
                      <th scope="col">Tanggal Berkunjung</th>
                      <th scope="col">Pukul Kunjungan</th>
                      <th scope="col">Jumlah Pengunjung</th>
                      <th scope="col" style="display: none;">Jumlah Pembayaran</th>
                      <th scope="col">Status</th>
                      <th scope="col">Detail Pesanan</th>

                    </tr>
                  </thead>
                  <tbody>
                    @php $no=1 @endphp
                    @foreach($data_pemesanan as $pemesanan)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td style="display: none;">{{$pemesanan->id}}</td>
                      <td>{{$pemesanan->name}}</td>
                      <td style="display: none;">{{$pemesanan->nama_paket}}</td>
                      <td style="display: none;">{{$pemesanan->kategori_pemesanan}}</td>
                      <td style="display: none;">{{date("j F Y", strtotime($pemesanan->created_at))}}</td>
                      <td>{{date("j F Y", strtotime($pemesanan->tanggal_berkunjung))}}</td>
                      <td>{{date("H:i", strtotime($pemesanan->pukul_kunjungan))}} WIB</td>
                      <td>{{$pemesanan->jumlah_pengunjung}} Orang</td>
                      <td style="display: none;">Rp. <?=number_format($pemesanan->jumlah_pembayaran, 0, ".", ".")?>,00</td>
                      <td>
                        @if($pemesanan->status_pemesanan == 0)
                        <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$pemesanan->id}})" data-target="#DeleteModal">
                          <button class="btn btn-danger btn-sm">Batalkan Pesanan</button>
                        </a>
                        <button class="btn btn-warning btn-sm pembayaran">Pembayaran</button>
                        @endif

                        @if($pemesanan->status_pemesanan == 1 && $pemesanan->jenis_pembayaran == 'setengah_bayar' )
                        <p style="color: green">Pesanan sudah dibayar</p>
                        <p style="color: blue">Setengah Bayar, Perlu pelunasan</p>
                        @endif

                        @if($pemesanan->status_pemesanan == 1 && $pemesanan->jenis_pembayaran == 'lunas' )
                       <p style="color: green">Pesanan sudah dibayar</p>
                        @endif
                      </td>
                      <td>
                        <button class="btn btn-warning btn-sm fa fa-eye detail" title="Detail Pesanan"></button>
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







<!-- ============================================================= MODAL TAMBAH PEMESANAN ================================================== -->

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
    <label style="color: #009970">Jumlah Orang Reguler</label>
    <input type="number" id="jumlah_orang_reguler" name="jumlah_pengunjung" class="form-control" disabled="" required="" oninput="HargaPaketFunction()" placeholder="Hanya untuk pemesanan paket Reguler">
    <span class="form-bar"></span>
  </div>

  <div class="form-group form-success">
    <label style="color: #009970">Jumlah Orang Non-Reguler (Minimal 5 Orang)</label>
    <input type="number" id="jumlah_orang" min="5" name="jumlah_pengunjung"  class="form-control" disabled="" required="" oninput="HargaPaketFunction()" placeholder="Hanya untuk pemesanan paket Non-Reguler">
    <span class="form-bar"></span>
  </div>

 <!--  <div class="form-group form-success">
    <label style="color: #009970">Jenis Pembayaran</label>
    <select name="jenis_pembayaran" class="form-control" required="" disabled="" id="jenis_pembayaran" onchange="JanisBayarFunction()">
     <option selected disabled value="0"> -- Pilih Jenis Pembayaran -- </option>
     <option value="lunas">Lunas</option>
     <option value="setengah_bayar">Setengah Bayar</option>
   </select>
   <span class="form-bar"></span>
 </div> -->

 <div class="form-group">
   <input type="hidden" class="form-control" id="jenis_pembayaran" name="jenis_pembayaran" value="lunas"  disabled="" />
 </div>

 <div class="form-group form-success">
  <label style="color: #009970">Jumlah Bayar </label>
  <input type="number" id="jumlah_bayar"  readonly="" name="jumlah_pembayaran" class="form-control" required="">
  <span class="form-bar"></span>
</div>

<div class="row m-t-30">
  <div class="col-md-3">
    <button type="button" class="btn btn-danger btn-md btn-block waves-effect text-center m-b-20" data-dismiss="modal">Batal</button>
  </div>

  <div class="col-md-3">
    <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Submit</button>
  </div>
</div>
</form>
</div>
<div class="modal-footer">
</div>
</div>
</div>
</div>





<!-- ======================================================= MODAL TAMBAH PEMBAYARAN =======================================================
 -->
<!-- Modal Tambah Pembayaran -->
<div class="modal fade" id="ModalTambahPembayaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Pembayaran</h5>

      </div>
      <div class="modal-body">

       <form class="form-material"  action="{{route('admin-proses_tambah_pembayaran')}}" method="post" enctype="multipart/form-data">
         {{csrf_field()}}

         <div class="form-group form-success">
          <label style="color: #009970">Nama Pengunjung</label>
          <input type="text" id="nama_pengunjung" class="form-control" required="">
          <span class="form-bar"></span>
        </div>

        <div class="form-group form-success">  
          <input type="hidden"  name="pemesanan_id" id="pemesanan_id" class="form-control">
        </div>

          <div class="form-group form-success">
            <label style="color: #009970">Tanggal Pembayaran</label>
            <input type="date"  name="tanggal_pembayaran" id="tanggal_pembayaran" class="form-control" required="">
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

        <div class="row m-t-30">
          <div class="col-md-3">
            <button type="button" class="btn btn-danger btn-md btn-block waves-effect text-center m-b-20" onclick="BatalPembayaranFunction()" data-dismiss="modal">Batal</button>
          </div>

          <div class="col-md-3">
            <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Submit</button>
          </div>
        </div>
      </form>

    </div>
    <div class="modal-footer">

    </div>
  </div>
</div>
</div>






<!-- ============================================================================== MODAL KONFIRMASI HAPUS ===================================
 -->
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







<!-- Modal Detail Pemesanan -->
<div class="modal fade" id="ModalDetailPemesanan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Pemesanan</h5>

      </div>
      <div class="modal-body">

       <form class="form-material" id=""  action="" method="" enctype="multipart/form-data">
         {{csrf_field()}}

         <div class="form-group form-success">
          <label style="color: #009970">Nama Pemesan</label>
          <input type="text" id="nama_pemesan" class="form-control" readonly="">
          <span class="form-bar"></span>
        </div>

        <div class="form-group form-success">
          <label style="color: #009970">Nama Paket</label>
          <input type="text" id="nama_paket" class="form-control" readonly="">
          <span class="form-bar"></span>
        </div>


        <div class="form-group form-success">
          <label style="color: #009970">Kategori Pemesan</label>
          <input type="text" id="kategori_pemesan" class="form-control" readonly="">
          <span class="form-bar"></span>
        </div>


        <div class="form-group form-success">
          <label style="color: #009970">Tanggal Pemesanan</label>
          <input type="text" id="tanggal_pemesanan" class="form-control" readonly="">
          <span class="form-bar"></span>
        </div>


        <div class="form-group form-success">
          <label style="color: #009970">Tanggal Berkunjung</label>
          <input type="text" id="tanggal_berkunjung" class="form-control" readonly="">
          <span class="form-bar"></span>
        </div>


        <div class="form-group form-success">
          <label style="color: #009970">Pukul Kunjungan</label>
          <input type="text" id="pukul_kunjungan" class="form-control" readonly="">
          <span class="form-bar"></span>
        </div>


        <div class="form-group form-success">
          <label style="color: #009970">Jumlah Pengunjung</label>
          <input type="text" id="jumlah_pengunjung" class="form-control" readonly="">
          <span class="form-bar"></span>
        </div>


        <div class="form-group form-success">
          <label style="color: #009970">Jumlah Pembayaran</label>
          <input type="text" id="jumlah_pembayaran" class="form-control" readonly="">
          <span class="form-bar"></span>
        </div>
        
          
        </div>
      </form>

    </div>
    <div class="modal-footer">

    </div>
  </div>
</div>
</div>





@section('js')
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
    var jumlah_orang_reguler = document.querySelector("#jumlah_orang_reguler");
    var jumlah_orang = document.querySelector("#jumlah_orang");

    if(kategori_pemesanan == "reguler"){
     paket_wisata.setAttribute("disabled", "");//menambahkan atribut disabled di form jika pilih paket reguler
     document.getElementById("jenis_pembayaran").selectedIndex = "1";
     jenis_pembayaran.removeAttribute("disabled");
     reguler_paket.removeAttribute("disabled");
     jumlah_orang_reguler.removeAttribute("disabled");
     jumlah_orang.setAttribute("disabled", "");
     document.getElementById("jumlah_bayar").value = 5000;//jumlah bayar auto 5000
     document.getElementById("jumlah_orang_reguler").value = 1;
   }else {
    paket_wisata.removeAttribute("disabled");//atribud disabled dihilangkan jika pilih jenis paket non-reguler
    jenis_pembayaran.removeAttribute("disabled");
    reguler_paket.setAttribute("disabled","");
    jumlah_orang.removeAttribute("disabled");
    jumlah_orang_reguler.setAttribute("disabled", "");
    document.getElementById("jenis_pembayaran").selectedIndex = "0";
    document.getElementById("jumlah_bayar").value = "";
    document.getElementById("jumlah_orang").value = "";
    document.getElementById("jumlah_orang_reguler").value = "";
  }
}

function PaketFunction(){
  var paket_wisata = document.getElementById("paket_wisata").value;
  fetch("/admin-get_paket_wisata/"+ paket_wisata )
  .then(response => response.json())
  .then(data => harga = data)
  .then(() => {
    document.getElementById("jumlah_orang").value ;
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

function BatalPembayaranFunction() {
  
  document.getElementById("pemesanan_id").value = "";
  document.getElementById("tanggal_pembayaran").value = "";
  document.getElementById("metode_pembayaran").selectedIndex = "0";
  document.getElementById("bukti_pembayaran").value = "";
  
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



<script>
  $(document).ready(function() {
    var table = $('#dataTable').DataTable();
    table.on('click', '.pembayaran', function() {
      $tr = $(this).closest('tr');
      if ($($tr).hasClass('child')) {
        $tr = $tr.prev('.parent');
      }
      var data = table.row($tr).data();
      console.log(data);
      $('#pemesanan_id').val(data[1]);
      $('#nama_pengunjung').val(data[2]);
      $('#ModalTambahPembayaran').modal('show');
    });
  });
</script>

<script>
  $(document).ready(function() {
    var table = $('#dataTable').DataTable();
    table.on('click', '.detail', function() {
      $tr = $(this).closest('tr');
      if ($($tr).hasClass('child')) {
        $tr = $tr.prev('.parent');
      }
      var data = table.row($tr).data();
      console.log(data);
      $('#nama_pemesan').val(data[2]);
      $('#nama_paket').val(data[3]);
      $('#kategori_pemesan').val(data[4]);
      $('#tanggal_pemesanan').val(data[5]);
      $('#tanggal_berkunjung').val(data[6]);
      $('#pukul_kunjungan').val(data[7]);
      $('#jumlah_pengunjung').val(data[8]);
      $('#jumlah_pembayaran').val(data[9]);
      $('#ModalDetailPemesanan').modal('show');
    });
  });
</script>
@endsection

@endsection
