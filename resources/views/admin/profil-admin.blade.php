@extends('layouts.app-master')

@section('title')
Profil Admin
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
                <h5>Profil Admin</h5>

              </div>
              <div class="card-block">
                <div class="row">
                  <div class="col-md-3"></div>
                  <div class="col-md-6">
                    <table class="table table-striped">
                      @foreach($profil_admin as $admin)
                      <div class="text-center">
                           <form method="post" action="{{route('admin-proses_ganti_foto_profil_admin',$admin->id)}}" enctype="multipart/form-data">
                             {{csrf_field()}}
                             {{method_field('PUT')}}
                             <span class="avatar">
                              <img src="{{asset('uploads/foto_pengelola/'.$admin->photo)}}" alt="image" style="border-radius: 100%; border: 3px solid black; width: 150px; height: auto; ">
                            </span><br><br>

                            <div class="form-group">
                              <label for="photo"> Ganti Foto Profil</label>
                              <input type="file" class="form-control" id="photo" name="photo" placeholder=" " required=""  />
                            </div> 

                            <button class="btn btn-primary">Ganti Foto Profil</button>
                          </form>
                        <br><br><br>
                    </div>
                    <tr>
                      <th>Nama  </th>
                      <th> : </th>
                      <td>{{$admin->name}}</td>
                    </tr>    

                     <tr>
                      <th>Email  </th>
                      <th> : </th>
                      <td>{{$admin->email}}</td>
                    </tr>    

                     <tr>
                      <th>Alamat  </th>
                      <th> : </th>
                      <td>{{$admin->alamat}}</td>
                    </tr>    

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
