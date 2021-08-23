@extends('layouts.app-master')

@section('title')
Laporan Berkala Pengunjung
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
                                @if($cari_tahun == null)
                                <h5>Laporan Berkala Pengunjung Tahun {{$year}}</h5>
                                @endif

                                @if($cari_tahun != null)
                                 <h5>Laporan Berkala Pengunjung Tahun {{$cari_tahun}}</h5>
                                @endif
                            </div>

                            <div class="card-block">
                             <div class="col-lg-10">
                                <form action="{{route('kepala_desa-laporan_berkala_pengunjung')}}" method="GET">
                                  <div class="row">
                                    <div class="col-lg-3">
                                      <div class="form-row">
                                        <label> Filter Tahun </label>
                                        <select name="cari_tahun" class="form-control">
                                            <option selected disabled> -- Pilih Tahun -- </option>
                                            @for($i=$year; $i >= 1990 ; $i--)
                                            <option>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <label></label>
                                    <input type="submit" class="btn btn-primary" value="Filter Tahun">
                                </div>
                            </div> 
                        </form>
                    </div>
                <br><br>



                    <div class="table-responsive">
                      <div class="row">
                        <div class="col-lg-12">
                            <div class="panel">
                                <div id="chartPengunjung"></div>
                            </div>
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
            text: 'Laporan Data Pengunjung'
        },
        subtitle: {
            text: 'Agrowisata Kebun Al-Qur`an'
        },
        xAxis: {
            categories: [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
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
            data: [{{$laporan_januari}},{{$laporan_februari}},{{$laporan_maret}},{{$laporan_april}},{{$laporan_mei}},{{$laporan_juni}},{{$laporan_juli}},{{$laporan_agustus}},{{$laporan_september}},{{$laporan_oktober}},{{$laporan_november}},{{$laporan_desember}}]

        }]
    });
</script>

@endsection


