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
                                <button type="button" style="float: right;" class="btn btn-success right"  data-toggle="modal" data-target="#ModalTambahPemesanan" >
                                    Tambah Pembayaran
                                </button>
                            </div>

                            <div class="card-block">
                             <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Tanggal Pembayaran</th>
                                            <th scope="col">Metode Pembayaran</th>
                                            <th scope="col">Bukti Pembayaran</th>
                                            <th scope="col">Status Pembayaran</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=1 @endphp
                                        @foreach($data_pembayaran as $pembayaran)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{date("j F Y", strtotime($pembayaran->tanggal_pembayaran))}}</td>
                                            <td>{{$pembayaran->metode_pembayaran}}</td>
                                            <td>
                                               <img src="{{asset('uploads/bukti_pembayaran/'.$pembayaran->bukti_pembayaran)}}" width="100px" height="100px">
                                           </td>

                                           <td>
                                            @if($pembayaran->status_pembayaran == 0)
                                            <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$pembayaran->id}})" data-target="#DeleteModal">
                                                <button class="btn btn-danger btn-sm">Batalkan Pesanan</button>
                                            </a>
                                            @endif

                                            @if($pembayaran->jenis_pembayaran == 'lunas')
                                                <button class="btn btn-success btn-sm">Lunas</button>
                                            @endif

                                            @if($pembayaran->jenis_pembayaran == 'setengah_bayar')
                                                <button class="btn btn-primary btn-sm">Setengah Bayar</button>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Pembayaran</h5>

    </div>
    <div class="modal-body">

       <form class="form-material"  action="{{route('pengunjung-proses_tambah_pembayaran')}}" method="post" enctype="multipart/form-data">
           {{csrf_field()}}

            <div class="form-group form-success">
              <label style="color: #009970">Nama Paket</label>
              <select name="pemesanan_id" class="form-control">
                 <option selected disabled> -- Pilih Nama Pengunjung -- </option>
                 @foreach($data_pembayaran as $pengunjung)
                 <option value="{{$pengunjung->id}}">{{$pengunjung->name}}</option>
                 @endforeach
             </select>
             <span class="form-bar"></span>
         </div>

           <div class="form-group form-success">
              <label style="color: #009970">Nama Paket</label>
              <select name="pemesanan_id" class="form-control">
                 <option selected disabled> -- Pilih Paket Wisata -- </option>
                 @foreach($data_pembayaran as $paket)
                 <option value="{{$paket->id}}">{{$paket->nama_paket}}</option>
                 @endforeach
             </select>
             <span class="form-bar"></span>
         </div>

         <div class="form-group form-success">
            <label style="color: #009970">Tanggal Pembayaran</label>
            <input type="date" name="tanggal_pembayaran" class="form-control">
            <span class="form-bar"></span>
        </div>


        <div class="form-group form-success">
            <label style="color: #009970">Nama Paket</label>
            <select name="metode_pembayaran" class="form-control">
               <option selected disabled> -- Pilih Metode Pembayaran -- </option>
               <option>Transfer</option>
               <option>Cash</option>
           </select>
           <span class="form-bar"></span>
       </div>

       <div class="form-group form-success">
        <label style="color: #009970">Bukti Pembayaran</label>
        <input type="file" name="bukti_pembayaran" class="form-control">
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
@endsection
