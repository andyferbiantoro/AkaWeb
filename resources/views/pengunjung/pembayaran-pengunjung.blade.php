@extends('layouts.app-master')

@section('title')
Data Pembayaran Pengunjung
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
           @foreach($data_pemesanan_lunas as $pemesanan)
           <div class="card">
            <div class="card-header">
              <h5>Data Pembayaran Berhasil</h5>
             <!--  <a href="{{ route('pengunjung-tambah_pembayaran') }}"><button type="button" style="float: right;" class="btn btn-success right">
                Tambah Pembayaran
              </button></a> -->
            </div>

            <div class="card-block">
              @if($pemesanan->jenis_pembayaran == 'setengah_bayar' && $pemesanan->status_pembayaran == '2')
                <a href="javascript:;" data-toggle="modal" onclick="pelunasanPembayaran({{$pemesanan->id}})" data-target="#PelunasanModal">
                  <button class="btn btn-info btn-sm">Lunasi Pembayaran sebesar Rp. <?=number_format($pemesanan->jumlah_pembayaran, 0, ".", ".")?>,00</button>
                </a>
                @endif
                <br><br>
              <div class="row">
                <div class="col-lg-5">
                  <div class="card-body p-0">
                    <table class="table table-hover">
                      <tr>
                        <th>Nama Pemesan</th>
                        <th>:</th>
                        <td>{{Auth::user()->name}}</td>
                      </tr> 

                      <tr>
                        <th>Noomor Pemesanan</th>
                        <th>:</th>
                        <td>{{$pemesanan->nomor_pemesanan}}</td>
                      </tr> 

                      <tr>
                        <th>Nama Paket Wisata </th>
                        <th>:</th>
                        <td>{{$pemesanan->nama_paket}}</td>
                      </tr> 

                      <tr>
                        <th>Tanggal Berkunjung </th>
                        <th>:</th>
                        <td>{{date("j F Y", strtotime($pemesanan->tanggal_berkunjung))}}</td>
                      </tr>    

                      <tr>
                        <th>Pukul Kunjungan</th>
                        <th>:</th>
                        <td>{{date("H:i", strtotime($pemesanan->pukul_kunjungan))}} WIB</td>
                      </tr>  
                    </table>
                  </div>
                </div>

                <div class="col-lg-1"></div>

                <div class="col-lg-5">
                  <div class="card-body p-0">
                    <table class="table table-hover">
                      <tr>
                        <th>Jumlah Anggota</th>
                        <th>:</th>
                        <td>{{$pemesanan->jumlah_pengunjung}} Orang</td>
                      </tr>    

                      <tr>
                        <th>Jumlah yang dibayarkan</th>
                        <th>:</th>
                        <td>Rp. <?=number_format($pemesanan->jumlah_pembayaran, 0, ".", ".")?>,00</td>
                      </tr> 

                      <tr>
                        <th>Tanggal Pembayaran </th>
                        <th>:</th>
                        <td>{{date("j F Y", strtotime($pemesanan->tanggal_pembayaran))}}</td>
                      </tr> 

                      <tr>
                        <th>Metode Pembayaran</th>
                        <th>:</th>
                        <td>{{$pemesanan->metode_pembayaran}}</td>
                      </tr>

                      <tr>
                        <th>Jenis Pembayaran</th>
                        <th>:</th>
                        <td>{{$pemesanan->jenis_pembayaran}}</td>
                      </tr>
                    </table>
                  </div>
                </div>

                


                @if($pemesanan->status_pembayaran == '1')
                <h5 style="color: red">Pembayaran anda sedang diverifikasi oleh admin, mohon tunggu email konfirmasi</h5><br>
                @endif

                @if($pemesanan->status_pembayaran == '2')
                <h5 style="color: green">Pembayaran anda sudah diverifikasi oleh admin, silakan cek email anda</h5><br>
                @endif
                
                


              </div>

            </div>
          </div>    
          @endforeach
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




<!-- Modal konfirmasi Hapus -->
<div id="PelunasanModal" class="modal fade" role="dialog">
  <div class="modal-dialog ">
    <!-- Modal content-->
    <form action="" id="PelunasanForm" method="post" enctype="multipart/form-data">

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Lunasi Pembayaran</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {{ csrf_field() }}
          {{ method_field('POST') }}

          <div class="form-group form-success">
            <label style="color: #009970">Bukti Pelunasan</label>
            <input type="file" name="bukti_pelunasan" id="bukti_pelunasan" class="form-control">
            <span class="form-bar"></span>
          </div>
          
          <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Kembali</button>
          <button type="submit" name="" class="btn btn-info float-right mr-2"  onclick="formSubmit()">Lunasi</button>
        </div>
      </div>
    </form>
  </div>
</div> 



@section('js');
<script type="text/javascript">
  function pelunasanPembayaran(id) {
    var id = id;
    var url = '{{route("pengunjung-pelunasan_pembayaran", ":id") }}';
    url = url.replace(':id', id);
    $("#PelunasanForm").attr('action', url);
  }

  function formSubmit() {
    $("#PelunasanForm").submit();
  }
</script>
@endsection

@endsection
