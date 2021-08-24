@extends('layouts.app-master')

@section('title')
Profil Kepala Desa
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
                <h5>Profil Kepala Desa</h5>

              </div>
              <div class="card-block">
                <div class="row">
                  <div class="col-md-3"></div>
                  <div class="col-md-6">

                  <table class="table table-striped">
                      @foreach($profil_kepala_desa as $kades)
                      <div class="text-center">
                           <form method="post" action="{{route('kepala_desa-proses_ganti_profil_kades',$kades->id)}}" enctype="multipart/form-data">
                             {{csrf_field()}}
                             {{method_field('PUT')}}
                             <span class="avatar">
                              <img src="{{asset('uploads/foto_pengelola/'.$kades->photo)}}" alt="image" style="border-radius: 100%; border: 3px solid black; width: 150px; height: auto; ">
                            </span><br><br>

                            <div class="form-group">
                              <label for="photo"> Ganti Foto Profil</label>
                              <input type="file" class="form-control" id="photo" name="photo" placeholder=" "   />
                            </div> 

                             <div class="form-group">
                              <label for="name"> Nama</label>
                              <input type="text" class="form-control" id="name" name="name" placeholder=" "  value="{{$kades->name}}"  />
                            </div> 

                             <div class="form-group">
                              <label for="email"> Email</label>
                              <input type="email" class="form-control" id="email" name="email" placeholder=" "   value="{{$kades->email}}"/>
                            </div> 

                            <div class="form-group">
                              <label for="nohp"> No Telepon</label>
                              <input type="nohp" class="form-control" id="nohp" name="nohp" placeholder=" "   value="{{$kades->nohp}}"/>
                            </div> 

                             <div class="form-group">
                              <label for="alamat"> Alamat</label>
                              <input type="text" class="form-control" id="alamat" name="alamat" placeholder=" "  value="{{$kades->alamat}}" />
                            </div> 

                            <button class="btn btn-primary">Perbarui Profil</button>
                          </form>
                        <br><br><br>
                    </div>
          
                    @endforeach
                  </table>
                </div>
                <div class="col-md-3"></div>
              </div>
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



@endsection
