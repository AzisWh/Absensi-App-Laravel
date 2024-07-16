@extends('layout.admin.master')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col text-center">
        
          <h2 class="page-title">
           Monitoring Absensi
          </h2>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    <div class="container-xl">
       <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar">Pilih Tanggal</i></span>
                                <input type="text" class="form-control" id="tanggal" name="tanggal" placeholder="tanggal presensi" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    {{-- table --}}
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-stripped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nim</th>
                                        <th>Nama</th>
                                        <th>Asal Univ/Sekolah</th>
                                        <th>Jam Masuk</th>
                                        <th>Foto</th>
                                        <th>Jam Pulang</th>
                                        <th>Foto</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="loadpresensi"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       </div>
    </div>
  </div>
  


@endsection

@push('myscript')
    <script>
        $(function () {
            $("#tanggal").datepicker({ 
                    autoclose: true, 
                    todayHighlight: true,
                    format : 'yyyy-mm-dd'
            }).datepicker('update', new Date());


            $("#tanggal").change(function (e){
                var tanggal = $(this).val();
                $.ajax({
                    url: '/getpresensi',
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal
                    },
                    cache: false,
                    success: function (respond) {
                        $("#loadpresensi").html(respond);
                    }
                });
            });


        });

    </script>
@endpush
