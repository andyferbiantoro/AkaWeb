@extends('layouts.app-master')

@section('title')
Beranda Kepala Desa
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
                                <h5>Beranda Kepala Desa</h5>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">

                                  <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                      <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="panel">
                                                        <div id="chartPengunjung"></div>                                
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="panel">
                                                        <div id="chartPaketWisata"></div>                                
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <div class="panel">
                                               <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="panel">
                                                        <div id="chartPendapatan"></div>                                
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
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
            text: 'Laporan Data Pengunjung'
        },
        subtitle: {
            text: 'Agrowisata Kebun Al-Qur`an'
        },
        xAxis: {
            categories: [
            'Hari Ini',
            'Bulan Ini',
            'Tahun Ini',
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Banyak Kunjunagan'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: 
            '<td style="padding:0"><b>{point.y} Pengunjung</b></td></tr>',
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
            name: 'Pengunjung',
            data: [{{$laporan_pengunjung_hari}},{{$laporan_pengunjung_bulan}},{{$laporan_pengunjung_tahun}}]

        }]
    });
</script>

<script type="text/javascript">
    Highcharts.chart('chartPaketWisata', {
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


<script type="text/javascript">
    Highcharts.chart('chartPendapatan', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Laporan Data Pendapatan'
        },
        subtitle: {
            text: 'Agrowisata Kebun Al-Qur`an'
        },
        xAxis: {
            categories: [
            'Hari Ini',
            'Bulan Ini',
            'Tahun Ini',
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total Pendapatan (Rp)'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: 
            '<td style="padding:0"><b>Rp. {point.y},00</b></td></tr>',
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
            name: 'Pendapatan',
            data: [{{$laporan_pendapatan_hari}},{{$laporan_pendapatan_bulan}},{{$laporan_pendapatan_tahun}}]

        }]
    });
</script>
@endsection


