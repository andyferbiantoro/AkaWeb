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
                                <a href="{{ route('pengunjung-tambah_pesanan') }}"><button type="button" style="float: right;" class="btn btn-success right">
                                    Tambah pemesanan
                                </button></a>
                            </div>

                            <div class="card-block">
                                @foreach($data_pemesanan as $pemesanan)
                                <div class="row">
                                  <div class="col-lg-6">
                                      <div class="card-body p-0">

                                          <table class="table table-striped">
                                            <tr>
                                              <th>Nama Pemesan</th>
                                              <td>{{Auth::user()->name}}</td>
                                          </tr> 

                                          <tr>
                                              <th>Nomor Pemesanan</th>
                                              <td>{{$pemesanan->nomor_pemesanan}}</td>
                                          </tr> 

                                          <tr>
                                              <th>Nama Paket Wisata </th>
                                              <td>{{$pemesanan->nama_paket}}</td>
                                          </tr>

                                          <tr>
                                              <th>Kategori Pesan </th>
                                              <td>{{$pemesanan->kategori_pemesanan}}</td>
                                          </tr> 

                                          <tr>
                                              <th>Tanggal Berkunjung </th>
                                              <td>{{date("j F Y", strtotime($pemesanan->tanggal_berkunjung))}}</td>
                                          </tr>    

                                          <tr>
                                              <th>Pukul Kunjungan</th>
                                              <td>{{date("H:i", strtotime($pemesanan->pukul_kunjungan))}} WIB</td>
                                          </tr>         

                                          <tr>
                                              <th>Jumlah Anggota</th>
                                              <td>{{$pemesanan->jumlah_pengunjung}} Orang</td>
                                          </tr>    

                                           <tr>
                                              <th>Jenis Pembayaran</th>
                                              <td>{{$pemesanan->jenis_pembayaran}}</td>
                                          </tr>    

                                          <tr>
                                              <th>Jumlah yang harus dibayar</th>
                                              <td>Rp. <?=number_format($pemesanan->jumlah_pembayaran, 0, ".", ".")?>,00</td>
                                          </tr> 
                                      </table><br>
                                        <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$pemesanan->id}})" data-target="#DeleteModal">
                                        <button class="btn btn-danger">Batalkan Pesanan</button>
                                        </a>
                                        <a href="{{ route('pengunjung-tambah_pembayaran') }}"> <button class="btn btn-primary">Bayar Sekarang</button></a><br><br>
                                </div><br>
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
        var url = '{{route("pengunjung-batalkan_pesanan", ":id") }}';
        url = url.replace(':id', id);
        $("#deleteForm").attr('action', url);
    }

    function formSubmit() {
        $("#deleteForm").submit();
    }
</script>


@endsection
