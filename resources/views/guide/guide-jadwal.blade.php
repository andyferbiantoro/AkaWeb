@extends('layouts.app-master')

@section('title')
jadwal Guide
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
                                <h5>Jadwal Guide</h5>
                            </div>
                            
                            <div class="card-block">
                               <div class="table-responsive">
                                <table id="dataTable" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Hari</th>
                                            <th scope="col">Pukul<th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @php $no=1 @endphp
                                            @foreach($guide_jadwal as $jadwal)
                                            <tr>
                                              <td>{{ $no++ }}</td>
                                              <td>{{date("j F Y", strtotime($jadwal->tanggal_berkunjung))}}</td>
                                              <td>{{date("H:i", strtotime($jadwal->pukul_kunjungan))}} WIB</td>
                                              <td></td>
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


@endsection
