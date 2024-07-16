@extends('layout.homeuser')

@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Izin Absensi</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col">
            @php
                $messagesuccess = Session::get('success');
                $messageerror = Session::get('error');
            @endphp
            @if (Session::get('success'))
                <div class="alert alert-success">{{$messagesuccess}}</div>                
            @endif
            @if (Session::get('error'))
                <div class="alert alert-danger">{{$messageerror}}</div>                
            @endif
        </div>
    </div>

    <div class="row">
       <div class="col">
            @foreach ($dataizin as $item)
            <ul class="listview image-listview">
                <li>
                    <div class="item">
                        <div class="in">
                            <div>
                                @if($item->status == "2")
                                    <b class="text-warning">{{ date("d-m-Y", strtotime($item->tanggal_izin)) }} (Sakit)</b>
                                    @else
                                    <b class="text-primary">{{ date("d-m-Y", strtotime($item->tanggal_izin)) }} (Izin)</b>
                                @endif
                                <br>
                                <span class="text-muted"> <b>Ket : </b>"{{$item->keterangan}}"</span>
                            </div>
                            @if ($item->status_acc == 0)
                                <span class="badge bg-warning">Menunggu Persetujuan</span>
                                @elseif($item->status_acc == 1)
                                <span class="badge bg-success">Disetujui</span>
                                @elseif($item->status_acc == 2)
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </div>
                    </div>
                </li>
            </ul>
            @endforeach
       </div>
    </div>

    <div class="fab-button bottom-right" style="margin-bottom: 70px">
        <a href="/presensi/makeizin" class="fab">
            <ion-icon name="add-outline"></ion-icon>
        </a>
    </div>
@endsection