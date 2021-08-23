@extends('layouts.app-master')

@section('title')
Laporan Berkala Paket Wisata
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
                                @if($cari_bulan == null)
                                <h5>Laporan Berkala Paket Wisata Bulan 
                                    @if($month == '01')
                                   Januari
                                   @elseif($month == '02')
                                   Februari
                                   @elseif($month == '03')
                                   Maret
                                   @elseif($month == '04')
                                   April
                                   @elseif($month == '05')
                                   Mei
                                   @elseif($month == '06')
                                   Juni
                                   @elseif($month == '07')
                                   Juli
                                   @elseif($month == '08')
                                   Agustus
                                   @elseif($month == '09')
                                   September
                                   @elseif($month == '10')
                                   Oktober
                                   @elseif($month == '11')
                                   November
                                   @elseif($month == '12')
                                   Desember
                                   @endif

                                </h5>
                                @endif

                                @if($cari_bulan != null)
                                 <h5>Laporan Berkala Paket Wisata Bulan 
                                   @if($cari_bulan == '01')
                                   Januari
                                   @elseif($cari_bulan == '02')
                                   Februari
                                   @elseif($cari_bulan == '03')
                                   Maret
                                   @elseif($cari_bulan == '04')
                                   April
                                   @elseif($cari_bulan == '05')
                                   Mei
                                   @elseif($cari_bulan == '06')
                                   Juni
                                   @elseif($cari_bulan == '07')
                                   Juli
                                   @elseif($cari_bulan == '08')
                                   Agustus
                                   @elseif($cari_bulan == '09')
                                   September
                                   @elseif($cari_bulan == '10')
                                   Oktober
                                   @elseif($cari_bulan == '11')
                                   November
                                   @elseif($cari_bulan == '12')
                                   Desember
                                   @endif
                                 </h5>
                                @endif
                            </div>

                            <div class="card-block">
                                <div class="col-lg-10">
                                    <form action="{{route('kepala_desa-laporan_berkala_pemesanan_paket')}}" method="GET">
                                      <div class="row">
                                        <div class="col-lg-3">
                                          <div class="form-row">
                                            <label>Filter Bulan</label>
                                            <select name="cari_bulan" class="form-control">
                                                <option selected disabled> -- Pilih Bulan -- </option>
                                                <option value="01">Januari</option>
                                                <option value="02">Ferbruari</option>
                                                <option value="03">Maret</option>
                                                <option value="04">April</option>
                                                <option value="05">Mei</option>
                                                <option value="06">Juni</option>
                                                <option value="07">Juli</option>
                                                <option value="08">Agustus</option>
                                                <option value="09">Sebtember</option>
                                                <option value="11">Oktober</option>
                                                <option value="11">November</option>
                                                <option value="12">Desember</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <label></label>
                                        <input type="submit" class="btn btn-primary" value="Filter Bulan">
                                    </div>
                                </div> 
                            </form>
                        </div>
                        <br><br>
                        <br><br>
                        <div class="table-responsive">
                          <div class="row">
                            <div class="col-lg-12">
                                <div class="panel">
                                    <div id="chartPaketWisata"></div>
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

@endsection


