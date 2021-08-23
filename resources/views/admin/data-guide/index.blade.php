@extends('layouts.app-master')

@section('title')
Data Guide
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
                                <h5>Data Guide</h5>
                                <button type="button" style="float: right;" class="btn btn-success right"  data-toggle="modal" data-target="#ModalTambahGuide" >
                                    Tambah Guide
                                </button>
                            </div>

                            <div class="card-block">
                             <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Profile</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Alamat</th>
                                            <th scope="col">Aksi</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no=1 @endphp
                                        @foreach($data_guide as $guide)
                                        <tr>
                                          <td>{{ $no++ }}</td>
                                          <td>
                                            <img src="{{asset('uploads/foto_guide/'.$guide->photo)}}" width="100px" height="100px" style="border-radius: 0%;">
                                        </td>
                                        <td>{{$guide->name}}</td>
                                        <td>{{$guide->email}}</td>
                                        <td>{{$guide->alamat}}</td>
                                        <td>
                                            <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$guide->id}})" data-target="#DeleteModal">
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
<div class="modal fade" id="ModalTambahGuide" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Guide</h5>

    </div>
    <div class="modal-body">
        <form class="md-float-material form-material" action="{{route('admin-tambah_guide')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            

            <div class="form-group form-primary">
                <input type="text" name="name" id="name" class="form-control" required="">
                <span class="form-bar"></span>
                <label class="float-label">Nama Guide</label>
            </div>
            <div class="form-group form-primary">
                <input type="email" name="email" id="email" class="form-control" required="">
                <span class="form-bar"></span>
                <label class="float-label">Email Guide</label>
            </div>
            <div class="form-group form-primary">
                <input type="text" name="alamat" id="alamat" class="form-control" required="">
                <span class="form-bar"></span>
                <label class="float-label">Alamat Guide</label>
            </div>
            <div class="form-group form-primary">
                <input type="password" name="password" id="password" class="form-control" required="">
                <span class="form-bar"></span>
                <label class="float-label">Password Guide</label>
            </div>
            <div class="form-group form-primary">
                <label style="color: #009970">Foto Guide</label>
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
        <form action="" id="deleteForm" method="post">
          
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Guide</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('POST') }}
                    <p>Apakah anda yakin ingin menghapus data guide ini ?</p>
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
        var url = '{{route("admin-hapus_data_guide", ":id") }}';
        url = url.replace(':id', id);
        $("#deleteForm").attr('action', url);
    }

    function formSubmit() {
        $("#deleteForm").submit();
    }


    function BatalFunction() {
        
    document.getElementById("name").value = "";
    document.getElementById("email").value = "";
    document.getElementById("alamat").value = "";
    document.getElementById("password").value = "";
    document.getElementById("photo").value = "";
    }
</script>
@endsection
