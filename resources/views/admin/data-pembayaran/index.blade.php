@extends('layouts.app-master')

@section('title')
Data Pembayaran
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
                <h5>Data Pembayaran</h5>
               <!--  <button type="button" style="float: right;" class="btn btn-success right"  data-toggle="modal" data-target="#ModalTambahPembayaran" >
                  Tambah Pembayaran
                </button> -->
              </div>

              <div class="card-block">
               <div class="table-responsive">
                <table id="dataTable" class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">Nama Pemesan</th>
                      <th scope="col">Jumlah Pembayaran</th>
                      <th scope="col">Tanggal Pembayaran</th>
                      <th scope="col">Metode Pembayaran</th>
                      <th scope="col">Bukti Pembayaran</th>
                      <th scope="col">Bukti Pelunasan (Bayar Setengah)</th>
                      <th scope="col">Status Pembayaran</th>
                      <th scope="col">Jenis Pembayaran</th>
                      <th style="display: none;">id (hidden)</th>
                      <th style="display: none;">jumlah pembayaran (hidden)</th>
                    </tr> 
                  </thead>
                  <tbody>
                    @php $no=1 @endphp
                    @foreach($data_pembayaran as $pembayaran)
                    <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{$pembayaran->name}}</td>
                      <td>Rp. <?=number_format($pembayaran->jumlah_pembayaran, 0, ".", ".")?>,00</td>
                      <td>{{date("j F Y", strtotime($pembayaran->tanggal_pembayaran))}}</td>
                      <td>{{$pembayaran->metode_pembayaran}}</td>

                      <td>
                        @if($pembayaran->metode_pembayaran == 'Bayar Ditempat' )
                        <p style="color: green">Pembayaran Ditempat</p>
                        @endif

                        @if($pembayaran->metode_pembayaran == 'Transfer')
                        <!-- <a href="#" id="pop">
                          <img id="imageresource" src="{{asset('uploads/bukti_pembayaran/'.$pembayaran->bukti_pembayaran)}}" style="width: 100px; height: 100px;">
                          Klik untuk melihat
                        </a> -->
                         <img height="70" id="myImg" src="{{asset('uploads/bukti_pembayaran/'.$pembayaran->bukti_pembayaran)}}" data-toggle="modal" data-target="#myModal"></img>

                        
                        <!-- <img src="{{asset('uploads/bukti_pembayaran/'.$pembayaran->bukti_pembayaran)}}" id="myImage" width="100px" height="100px" data-toggle="modal" data-target="#imageModal"> -->
                        @endif
                      </td>


                      <td>
                        <!-- jika tidak ada bukti pelunasan, berarti pelunasan dilakukan di admin -->
                        @if(empty($pembayaran->bukti_pelunasan) && $pembayaran->jenis_pembayaran == 'lunas')
                        <p style="color: green">Pelunasan Ditempat</p>
                        @endif

                        @if(empty($pembayaran->bukti_pelunasan) && $pembayaran->jenis_pembayaran == 'setengah_bayar')
                        <p style="color: red">Menunggu Pelunasan</p>
                        @endif

                        <!-- jika ada bukti pelunasan, berarti pelunasan dilakukan di pengunjung, karena harus uploasd bukti pelunasan -->
                        @if(!empty($pembayaran->bukti_pelunasan) && $pembayaran->jenis_pembayaran == 'lunas')

                        <img height="70" id="myImg" src="{{asset('uploads/bukti_pelunasan/'.$pembayaran->bukti_pelunasan)}}" data-toggle="modal" data-target="#myModal"></img>
                        
                  
                        <!-- <a href="#" class="image_pelunasan"><img  src="{{asset('uploads/bukti_pelunasan/'.$pembayaran->bukti_pelunasan)}}" width="100px" height="100px"></a> -->
                        @endif
                      </td>


                      <td>
                        @if($pembayaran->status_pembayaran == 0)
                        <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$pembayaran->id}})" data-target="#VerifikasiModal">
                          <button class="btn btn-danger btn-sm">Batalkan Pesanan</button>
                        </a>
                        @endif

                        @if( $pembayaran->status_pembayaran == 2)
                        <p style="color: green">Sudah Terverifikasi</p>
                        <!-- <button class="btn btn-success btn-sm">Pembayaran Lunas</button> -->
                        @endif

                        @if($pembayaran->status_pembayaran == 1)
                        <p style="color: red">Belum Terverifikasi</p>
                        <a href="javascript:;" data-toggle="modal" onclick="verifikasiData({{$pembayaran->id}})" data-target="#VerifikasiModal">
                          <button class="btn btn-warning btn-sm">Verifikasi Pembayaran</button>
                        </a>  
                        @endif
                      </td>

                      <td>
                        @if($pembayaran->jenis_pembayaran == 'setengah_bayar' && $pembayaran->status_pembayaran == 2)
                        <p style="color: red">Pembayaran Bayar Setengah</p>
                        <button class="btn btn-sm btn-info lunasi" title="Bayarkan">Lunasi Pembayaran sebesar Rp. <?=number_format($pembayaran->jumlah_pembayaran, 0, ".", ".")?>,00</button>
                        @endif

                        @if($pembayaran->jenis_pembayaran == 'setengah_bayar' && $pembayaran->status_pembayaran == 1)
                        <p style="color: red">Pembayaran Bayar Setengah</p>
                        <p style="color: red">Verifikasi untuk pelunasan</p>
                        @endif


                        @if($pembayaran->jenis_pembayaran == 'lunas')
                        <p style="color: green">Pembayaran Lunas</p>
                        @endif
                      </td>

                      <td style="display: none">{{$pembayaran->pemesanan_id}}</td>
                      <td style="display: none">{{$pembayaran->jumlah_pembayaran}}</td>

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





<!-- Modal konfirmasi Update -->
<div id="ModalViewImage" class="modal fade" role="dialog">
  <div class="modal-dialog ">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">View Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">


      </div>
    </div>
  </div>
</div> 




<!-- Modal -->
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
          <select name="pemesanan_id" id="pengunjung" class="form-control" onchange="PemesananBelumBayarFunction()">
           <option selected disabled> -- Pilih Nama Pengunjung -- </option>
           @foreach($data_pamesanan as $pengunjung)
           <option value="{{$pengunjung->id}}">{{$pengunjung->name}}</option>
           @endforeach
         </select>
         <span class="form-bar"></span>
       </div>

       <div class="form-group form-success">
        <label style="color: #009970">Tanggal Pembayaran</label>
        <input type="date"  name="tanggal_pembayaran" id="tanggal_pembayaran" class="form-control">
        <span class="form-bar"></span>
      </div>

      <div class="form-group form-success">
        <label style="color: #009970">Nama Paket</label>
        <select name="metode_pembayaran" id="metode_pembayaran" class="form-control">
         <option selected disabled> -- Pilih Metode Pembayaran -- </option>
         <option>Transfer</option>
         <option>Cash</option>
       </select>
       <span class="form-bar"></span>
     </div>

     <div class="form-group form-success">
      <label style="color: #009970">Bukti Pembayaran</label>
      <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control">
      <span class="form-bar"></span>
    </div>

    <div class="row m-t-30">
      <div class="col-md-3">
        <button type="button" class="btn btn-danger btn-md btn-block waves-effect text-center m-b-20" onclick="BatalFunction()" data-dismiss="modal">Batal</button>
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







<!-- Modal konfirmasi Verifikasi Pembayaran -->
<div id="VerifikasiModal" class="modal fade" role="dialog">
  <div class="modal-dialog ">
    <!-- Modal content-->
    <form action="" id="VerifikasiForm" method="post">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Verifikasi Pembayaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{ csrf_field() }}
          {{ method_field('POST') }}
          <p>Apakah anda yakin ingin memverifikasi pembayaran ini ?</p>
          <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Kembali</button>
          <button type="submit" name="" class="btn btn-success float-right mr-2" data-dismiss="modal" onclick="formSubmitVerifikasi()">Verifikasi Pembayaran</button>
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
          <h5 class="modal-title">Lakukan Pelunasan dari Admin</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{ csrf_field() }}
          {{ method_field('POST') }}



          <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Batal</button>
          <button type="submit" name="" class="btn btn-info float-right mr-2"  onclick="pelunasanForm()">Lunasi</button>
        </div>
      </div>
    </form>
  </div>
</div> 





<!-- Creates the bootstrap modal where the image will appear -->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body text-center">
        <img src="" id="imagepreview" style="width: 450px; height: auto;" >
      </div>
    </div>
  </div>
</div>







@section('js')
<!-- modal menampilkan image -->
<script type="text/javascript">
  $("#pop").on("click", function() {
   $('#imagepreview').attr('src', $('#imageresource').attr('src')); // here asign the image to the modal when the user click the enlarge link
   $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
});
</script>

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

  function BatalFunction() {

    document.getElementById("pengunjung").selectedIndex = "0";
    document.getElementById("tanggal_pembayaran").value = "";
    document.getElementById("metode_pembayaran").selectedIndex = "0";
    document.getElementById("bukti_pembayaran").value = "";

  }

  function verifikasiData(id) {
    var id = id;
    var url = '{{route("admin-verifikasi_pembayaran", ":id") }}';
    url = url.replace(':id', id);
    $("#VerifikasiForm").attr('action', url);
  }

  function formSubmitVerifikasi() {
    $("#VerifikasiForm").submit();
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
      $('#pelunasanForm').attr('action','admin-pelunasan_pembayaran/'+ data[9]);
      $('#PelunasanModal').modal('show');
    });
  });
</script>


<script>
  $(document).ready(function() {
    var table = $('#dataTable').DataTable();
    table.on('click', '.image_pembayaran', function() {
      $tr = $(this).closest('tr');
      if ($($tr).hasClass('child')) {
        $tr = $tr.prev('.parent');
      }
      var data = table.row($tr).data();
      console.log(data);
      $('#bukti_pembayaran').val(data[6]);
      $('#BuktiPembayaranModal').modal('show');
    });
  });
</script>
@endsection

@endsection
