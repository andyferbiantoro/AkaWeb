@extends('layouts.app-master')

@section('title')
Beranda Paket Wisata
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
                                <h5>Beranda</h5>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
                                   <a href="{{route('admin-beranda')}}"><button class="btn btn-success">data Pengunjung</button></a>
                                   <a href="#"><button class="btn btn-primary">data Paket Wisata</button></a>
                                   <a href="{{route('admin-beranda_pendapatan')}}"><button class="btn btn-success">data Pendapatan</button></a><br><br>
                                   <div class="panel">
                                    <div class="row">
                                        <div id="chartPengunjung"></div>
                                    </div>

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
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript">
    Highcharts.chart('chartPengunjung', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Laporan Data Pemesanan Paket Wisata'
        },
        subtitle: {
            text: 'Agrowisata Kebun Al-Qur`an'
        },
        xAxis: {
            categories: {!!json_encode($nama_paket)!!},
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total Dipesan'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: 
            '<td style="padding:0"><b>{point.y} Kali Dipesan</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Paket Wisata',
            data: {!!json_encode($total_orderan)!!}

        }]
    });
</script>
@endsection


