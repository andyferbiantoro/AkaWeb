@extends('layouts.app-master')

@section('title')
Beranda Guide
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
                                <h1 style="color: #009970">Selamat Datang</h1>
                            </div>
                            
                            <div class="card-block">

                              <div class="accordion-desc">
                                <h3>
                                    Selamat Bekerja !, Gunakan SIstem ini untuk Bekerja
                                </h3>
                                <h3>
                                    Semoga Harimu Menyenangkan !
                                </h3>
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
