@extends('layout.homeuser')

@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">History Absensi</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')

    <div class="row" style="margin-top: 70px">
        <div class="col">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <select name="bulan" id="bulan" class="form-control">
                            <option value="" >Bulan</option>
                            @for ($i = 1; $i < 12; $i++)
                                <option value="{{$i}}" {{date("m")==$i ? 'selected' : ''}} >{{$namabulan[$i]}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <select name="tahun" id="tahun" class="form-control">
                            <option value="" >Tahun</option>
                            @php
                                $tahunmulai = 2023;
                                $tahunsekarang = date('Y');
                            @endphp
                            @for ($tahun = $tahunmulai; $tahun <= $tahunsekarang; $tahun++)
                                <option value={{$tahun}} {{date("Y")==$tahun ? 'selected' : ''}}>{{$tahun}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" id="caridata">Cari Data Histori</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col" id="showHistory">

        </div>
    </div>
    
@endsection

@push('myScript')
   
    <script>
        $(function(){
            $('#caridata').click(function(){
                var bulan = $('#bulan').val();
                var tahun = $('#tahun').val();
                $.ajax({
                    type : 'POST',
                    url : '/gethistory',
                    data : {
                        _token : "{{csrf_token()}}"
                        , bulan : bulan
                        ,tahun : tahun
                    },
                    cache : false
                    ,success : function(respond){
                        $('#showHistory').html(respond);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                })
            })
        })
    </script>
@endpush