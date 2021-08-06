@extends('layouts.app-master')

@section('title')
Tambah Pembayaran
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
                <h5>Tambah Pembayaran</h5>
              </div>

              <div class="card-block">
                <form class="form-material"  action="{{route('pengunjung-proses_tambah_pembayaran')}}" method="post" enctype="multipart/form-data">
                 {{csrf_field()}}


                 <div class="form-group form-success">
                  <label style="color: #009970">Nama Paket</label>
                  <select name="pemesanan_id" class="form-control">
                   <option selected disabled> -- Pilih Paket Wisata -- </option>
                   @foreach($data_paket as $paket)
                   <option value="{{$paket->id}}">{{$paket->nama_paket}}</option>
                   @endforeach
                 </select>
                 <span class="form-bar"></span>
               </div>

               <div class="form-group form-success">
                <label style="color: #009970">Tanggal Pembayaran</label>
                <input type="date" name="tanggal_pembayaran" class="form-control" required="">
                <span class="form-bar"></span>
              </div>


              <div class="form-group form-success">
                <label style="color: #009970">Nama Paket</label>
                <select name="metode_pembayaran" class="form-control" required="">
                 <option selected disabled> -- Pilih Metode Pembayaran -- </option>
                   <option>Transfer</option>
                   <option>Cash</option>
               </select>
               <span class="form-bar"></span>
             </div>

             <div class="form-group form-success">
                <label style="color: #009970">Bukti Pembayaran</label>
                <input type="file" name="bukti_pembayaran" required="" class="form-control">
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

 
@endsection
