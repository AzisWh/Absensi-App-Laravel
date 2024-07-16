@extends('layout.homeuser')

@section('header')
{{-- datepicker --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Buat Izin</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col">
            <form action="/presensi/storeizin" method="POST" id="formijin">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input type="text" class="form-control datepicker" id="tanggal_izin" name="tanggal_izin" placeholder="Tanggal">
                        </div>
                        <div class="form-group">
                            <select name="status" id="status" class="form-control">
                                <option value="">Pilih Status</option>
                                <option value="1">Izin</option>
                                <option value="2">Sakit</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="keterangan" id="keterangan" cols="30" rows="10" class="form-control" placeholder="keterangan"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Submit Izin</button>
                        </div>
                    </div>
                </div>
               
            </form>
        </div>
    </div>
@endsection

@push('myScript')
  <script>
        var currYear = (new Date()).getFullYear();

        $(document).ready(function() {
            $(".datepicker").datepicker({
                
                format: "yyyy-mm-dd"    
            });
            $("#formijin").submit(function(){
                var tanggal = $("#tanggal_izin").val();
                var status = $("#status").val();
                var keterangan = $("#keterangan").val();
                if(tanggal == ""){
                    Swal.fire({
                    title: 'Aigo',
                    text: "Tanggal tidak boleh kosong",
                    icon: 'warning',
                    });
                    return false;
                }else if(status == ""){
                    Swal.fire({
                    title: 'Aigo',
                    text: "Status tidak boleh kosong",
                    icon: 'warning',
                    });
                    return false;
                }else if(keterangan == ""){
                    Swal.fire({
                    title: 'Aigo',
                    text: "Keterangan tidak boleh kosong",
                    icon: 'warning',
                    });
                    return false;
                }
            });
        });


  </script>
@endpush