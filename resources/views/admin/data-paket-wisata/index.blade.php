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
                                <h5>Data Paket</h5>
                                <button type="button" style="float: right;" class="btn btn-success right"  data-toggle="modal" data-target="#ModalTambahpaket" >
                                    Tambah Paket
                                </button>
                                <a href="{{route('admin-data_paket_wisata_nonaktif')}}"><button type="button"  class="btn btn-primary right"  >
                                    Lihat Paket Nonaktif
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
                                            <th style="display: none;">id</th>
                                            <th style="display: none;">harga_hidden</th>

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
                                                <button class="btn btn-danger btn-sm fa fa-close" title="Non-Aktifkan"></button>
                                            </a>
                                            <button class="btn btn-info btn-sm fa fa-edit edit" title="Update Paket"></button>
                                           
                                        </td>
                                        <td style="display: none">{{$paket->id}}</td>
                                        <td style="display: none">{{$paket->harga_paket}}</td>

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
                <input type="text" name="nama_paket" id="nama_paket" class="form-control" required="">
                <span class="form-bar"></span>
                <label class="float-label">Nama Paket</label>
            </div>
            <div class="form-group form-primary">
                <input type="text" name="deskripsi_paket" id="deskripsi_paket" class="form-control" required="">
                <span class="form-bar"></span>
                <label class="float-label">Deskripsi Paket</label>
            </div>
            <div class="form-group form-primary">
                <input type="number" name="harga_paket" id="harga_paket" class="form-control" required="">
                <span class="form-bar"></span>
                <label class="float-label">Harga Paket</label>
            </div>
            <div class="form-group form-primary">
                <label >Foto Paket</label>
                <input type="file" name="photo" id="photo" class="form-control" required=""> 
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
        <hr/>
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
        <form action="" id="nonaktifForm" method="post">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Non-Aktifkan Paket Wisata</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                    <p>Apakah anda yakin ingin menonaktifkan data paket wisata ini ?</p>
                    <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Batal</button>
                    <button type="submit" name="" class="btn btn-danger float-right mr-2" data-dismiss="modal" onclick="formSubmit()">Nonaktif</button>
                </div>
            </div>
        </form>
    </div>
</div> 




<!-- Modal konfirmasi Update -->
<div id="UpdateModal" class="modal fade" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Paket Wisata</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    
                    <form class="form-material" action="" id="updateFormPaket" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}

                        <div class="form-group form-success">
                            <label style="color: #009970">Nama Paket Wisata</label>
                            <input type="text" id="nama_paket_update" name="nama_paket" class="form-control" >
                            <span class="form-bar"></span>
                        </div>

                         <div class="form-group form-success">
                            <label style="color: #009970">Deskripsi Paket Wisata</label>
                            <input type="text" id="deskripsi_paket_update" name="deskripsi_paket" class="form-control" >
                            <span class="form-bar"></span>
                        </div>

                        <div class="form-group form-success">
                            <label style="color: #009970">Harga Paket Wisata</label>
                            <input type="text" id="harga_paket_update" name="harga_paket" class="form-control">
                            <span class="form-bar"></span>
                        </div>

                        <div class="form-group form-success">
                            <label style="color: #009970">Foto Paket Wisata</label>
                            <input type="file" id="photo_update" name="photo" class="form-control" >
                            <span class="form-bar"></span>
                        </div>

                      <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Batal</button>
                      <button type="submit"  class="btn btn-info float-right mr-2" >Update</button>
                    </form>          
                </div>
            </div>
    </div>
</div> 


@section('js')
<script type="text/javascript">
    function deleteData(id) {
        var id = id;
        var url = '{{route("admin-nonaktif_data_paket_wisata", ":id") }}';
        url = url.replace(':id', id);
        $("#nonaktifForm").attr('action', url);
    }

    function formSubmit() {
        $("#nonaktifForm").submit();
    }
</script>

<script type="text/javascript">

    function BatalFunction() {
        
    document.getElementById("nama_paket").value = "";
    document.getElementById("deskripsi_paket").value = "";
    document.getElementById("harga_paket").value = "";
    document.getElementById("photo").value = "";
  
    }
</script>

<script>
    $(document).ready(function() {
        var table = $('#dataTable').DataTable();
        table.on('click', '.edit', function() {
            $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')) {
                $tr = $tr.prev('.parent');
            }
            var data = table.row($tr).data();
            console.log(data);
            $('#nama_paket_update').val(data[1]);
            $('#deskripsi_paket_update').val(data[3]);
            $('#harga_paket_update').val(data[7]);
            $('#updateFormPaket').attr('action','admin-proses_update_paket_wisata/'+ data[6]);
            $('#UpdateModal').modal('show');
        });
    });
</script>
@endsection
@endsection
