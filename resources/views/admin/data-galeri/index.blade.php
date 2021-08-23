@extends('layouts.app-master')

@section('title')
Data Galeri
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
                                <h5>Data Galeri</h5>
                                <button type="button" style="float: right;" class="btn btn-success right"  data-toggle="modal" data-target="#ModalTambahGaleri" >
                                    Tambah Galeri
                                </button>
                            </div>

                            <div class="card-block">
                               <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                         <th scope="col">No</th>
                                         <th scope="col">Foto Galeri</th>
                                         <th scope="col">Aksi</th>

                                     </tr>
                                 </thead>
                                 <tbody>
                                    @php $no=1 @endphp
                                    @foreach($data_galeri as $galeri)
                                    <tr>
                                      <td>{{ $no++ }}</td>
                                      <td>
                                        <img src="{{asset('uploads/foto_galeri/'.$galeri->photo)}}"  width="100px" height="100px" style="border-radius: 0%;">
                                    </td>
                                    
                                    <td>
                                        <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$galeri->id}})" data-target="#DeleteModal">
                                            <button class="btn btn-danger btn-sm fa fa-trash" title="Hapus"></button>
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
<div class="modal fade" id="ModalTambahGaleri" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Galeri</h5>

    </div>
    <div class="modal-body">
        <form class="md-float-material form-material" action="{{route('admin-tambah_galeri')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            

            <div class="form-group form-primary">
               <label style="color: #009970">Foto Galeri</label>
               <input type="file" name="photo" required="" class="form-control">
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
        <hr/>
    </form>
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
                    <h5 class="modal-title">Hapus Galeri</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                    <p>Apakah anda yakin ingin menghapus data galeri ini ?</p>
                    <button type="button" class="btn btn-secondary float-right" data-dismiss="modal">Batal</button>
                    <button type="submit" name="" class="btn btn-danger float-right mr-2" data-dismiss="modal" onclick="formSubmit()">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div> 

<script type="text/javascript">
    function deleteData(id) {
        var id = id;
        var url = '{{route("admin-hapus_data_galeri", ":id") }}';
        url = url.replace(':id', id);
        $("#deleteForm").attr('action', url);
    }

    function formSubmit() {
        $("#deleteForm").submit();
    }
</script>
@endsection
