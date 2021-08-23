@extends('layouts.app-master')

@section('title')
Laporan Pendapatan
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
                <h5>Data Pendapatan</h5>

              </div>

              <div class="card-block">
               <div class="row">
                <div class="col-lg-2"> 
                 <button class="btn btn-success" onclick="print('printPDF')">Cetak PDF</button>
               </div>

               <div class="col-lg-10">
                <form action="{{route('admin-laporan_pendapatan')}}" method="GET">
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="form-row">
                        <label>Mulai Tanggal</label>
                        <input type="date" class="form-control" name="from" placeholder="Cari tanggal .." value="{{ old('from') }}">
                      </div>
                    </div>

                    <div class="col-lg-3">
                     <div class="form-row">
                      <label>Sampai Tanggal</label>
                      <input type="date" class="form-control" name="to" placeholder="Cari tanggal .." value="{{ old('to') }}">
                    </div>
                  </div>

                  <div class="col-lg-2">
                    <label></label>
                    <input type="submit" class="btn btn-primary" value="Filter Tanggal">
                  </div>
                </div> 
              </form>
            </div>
          </div><br><br>



          <div class="table-responsive">
            <div id="printPDF">
              
              @if($from == null && $to == null)
              <div class="row">
                <div class="col-lg-12"><p style="color: red" class="text-center">Tanggal Tidak Difilter</p></div>
              </div><br>
              @endif
              @if($from != null && $to != null)
              <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-3">Mulai tanggal : {{date("j F Y", strtotime($from))}}</div>
                <div class="col-lg-3">Sampai tanggal : {{date("j F Y", strtotime($to))}}</div>
                <div class="col-lg-3"></div>
              </div><br><br>
              @endif
              <table  class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Total Pendapatan</th>
                  </tr>
                </thead>
                <tbody>
                  @php $no=1 @endphp
                  @foreach($data_pendapatan as $pendapatan)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{$pendapatan->created_at}}</td>
                    <td>{{$pendapatan->total_pendapatan}}</td>
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
</div>
<!-- Page-body end -->
</div>
<div id="styleSelector"> </div>
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
</script>

<script type="text/javascript">
  function print(elem) {
    var mywindow = window.open('', 'PRINT', 'height=1000,width=1200');

    mywindow.document.write('<html><head><link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<h1 class="text-center">' + 'Laporan Pendapatan' + '</h1>');
    mywindow.document.write('<br><br>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');
    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    // mywindow.close();

    return true;

  }
</script>
@endsection
