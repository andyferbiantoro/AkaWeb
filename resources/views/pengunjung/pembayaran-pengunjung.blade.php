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
                                <h5>Data Pembayaran Lunas</h5>
                                <a href="{{ route('pengunjung-tambah_pembayaran') }}"><button type="button" style="float: right;" class="btn btn-success right">
                                    Tambah Pembayaran
                                </button></a>
                            </div>

                            <div class="card-block">
                                @foreach($data_pemesanan_lunas as $pemesanan)
                                <div class="row">
                                  <div class="col-lg-6">
                                      <div class="card-body p-0">
                                        <h3>Pembayaran Berhasil</h3>
                                          <table class="table table-striped">
                                            <tr>
                                              <th>Nama Pemesan</th>
                                              <td>{{Auth::user()->name}}</td>
                                          </tr> 

                                          <tr>
                                              <th>Noomor Pemesanan</th>
                                              <td>{{$pemesanan->nomor_pemesanan}}</td>
                                          </tr> 

                                          <tr>
                                              <th>Nama Paket Wisata </th>
                                              <td>{{$pemesanan->nama_paket}}</td>
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
                                              <th>Jumlah yang harus dibayar</th>
                                              <td>Rp. <?=number_format($pemesanan->jumlah_pembayaran, 0, ".", ".")?>,00</td>
                                          </tr> 
                                      </table><br>
                                      
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


@endsection
