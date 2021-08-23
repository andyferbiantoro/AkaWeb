@extends('layouts.app-master')

@section('title')
Data Paket Wisata
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
                                <h5>Data Paket Non-Aktif</h5>
                               <!--  <button type="button" style="float: right;" class="btn btn-success right"  data-toggle="modal" data-target="#ModalTambahpaket" >
                                    Tambah Paket
                                </button> -->
                                 <a href="{{route('admin-data_paket_wisata')}}"><button type="button"  class="btn btn-primary right"  >
                                    Lihat Paket Aktif
                                </button></a>
                            </div>

                            <div class="card-block">
                               <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama Paket</th>
                                            <th scope="col">Photo</th>
                                            <th scope="col">Deskripsi</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Aksi</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=1 @endphp
                                        @foreach($data_paket_wisata as $paket)
                                        <tr>
                                          <td>{{ $no++ }}</td>
                                          <td>{{$paket->nama_paket}}</td>
                                          <td>
                                            <img src="{{asset('uploads/foto_paket_wisata/'.$paket->photo)}}" width="100px" height="100px" style="border-radius: 0%;">
                                        </td>

                                        <td>{{$paket->deskripsi_paket}}</td>
                                        <td>Rp. <?=number_format($paket->harga_paket, 0, ".", ".")?>,00</td>
                                        <td>
                                            <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$paket->id}})" data-target="#DeleteModal">
                                                <button class="btn btn-success btn-sm fa fa-check" title="Aktifkan"></button>
                                            </a>
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
<div class="modal fade" id="ModalTambahpaket" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Paket</h5>

    </div>
    <div class="modal-body">
        <form class="md-float-material form-material" action="{{route('admin-tambah_paket_wisata')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            

            <div class="form-group form-primary">
                <input type="text" name="nama_paket" class="form-control">
                <span class="form-bar"></span>
                <label class="float-label">Nama Paket</label>
            </div>
            <div class="form-group form-primary">
                <input type="text" name="deskripsi_paket" class="form-control">
                <span class="form-bar"></span>
                <label class="float-label">Deskripsi Paket</label>
            </div>
            <div class="form-group form-primary">
                <input type="number" name="harga_paket" class="form-control">
                <span class="form-bar"></span>
                <label class="float-label">Harga Paket</label>
            </div>
            <div class="form-group form-primary">
                <label >Foto Paket</label>
                <input type="file" name="photo" class="form-control">
                <span class="form-bar"></span>
            </div>
            <div class="row m-t-30">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Submit</button>
                </div>
            </div>
            <hr/>
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
        <form action="" id="aktifForm" method="post">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aktifkan Paket Wisata</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                    <p>Apakah anda yakin ingin mengaktifkan data paket wisata ini ?</p>
                    <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Batal</button>
                    <button type="submit" name="" class="btn btn-success float-right mr-2" data-dismiss="modal" onclick="formSubmit()">Aktifkan</button>
                </div>
            </div>
        </form>
    </div>
</div> 

<script type="text/javascript">
    function deleteData(id) {
        var id = id;
        var url = '{{route("admin-aktif_data_paket_wisata", ":id") }}';
        url = url.replace(':id', id);
        $("#aktifForm").attr('action', url);
    }

    function formSubmit() {
        $("#aktifForm").submit();
    }
</script>
@endsection
