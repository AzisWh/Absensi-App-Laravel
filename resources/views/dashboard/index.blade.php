@extends('layout.homeuser')

@section('content')
<div class="section" id="user-section">
    <div id="user-detail">
        <div class="avatar">
            @if (Auth::guard('mahasiswa')->user()->foto_profile)
                @php
                    $path = Storage::url('uploads/mahasiswa/'.Auth::guard('mahasiswa')->user()->foto_profile)
                @endphp
                  <img src="{{url($path)}}" alt="avatar" class="imaged w64 " style="height: 60px">
            @else
            <img src="/assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded">
            @endif
           
        </div>
        <div id="user-info">
            <h2 id="user-name">{{ $nama }}</h2>
            <span id="user-role">{{ $asal }}</span>
        </div>
    </div>
</div>

<div class="section" id="menu-section">
    <div class="card">
        <div class="card-body text-center">
            <div class="list-menu">
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="" class="green" style="font-size: 40px;">
                            <ion-icon name="person-sharp"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name">
                        <span class="text-center">Profil</span>
                    </div>
                </div>
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="" class="danger" style="font-size: 40px;">
                            <ion-icon name="calendar-number"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name">
                        <span class="text-center">Cuti</span>
                    </div>
                </div>
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="" class="warning" style="font-size: 40px;">
                            <ion-icon name="document-text"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name">
                        <span class="text-center">Histori</span>
                    </div>
                </div>
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="" class="orange" style="font-size: 40px;">
                            <ion-icon name="location"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name">
                        Lokasi
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section mt-2" id="presence-section">
    <div class="todaypresence">
        <div class="row">
            
            <div class="col-6">
                <div class="card gradasigreen">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence">
                                @if ($absentoday != null)
                                @php
                                    $path = Storage::url('uploads/absensi/'.$absentoday->foto_in)
                                @endphp
                                <img src="{{url($path)}}" alt="" class="imaged w48">
                                @else
                                <ion-icon name="camera"></ion-icon>
                                @endif
                               
                            </div>
                            <div class="presencedetail">
                                <h4 class="presencetitle">Masuk</h4>
                                <span>{{ $absentoday != null ? $absentoday->jam_in : 'Belum Absen' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card gradasired">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence">
                                @if ($absentoday != null && $absentoday->jam_out != null)
                                @php
                                    $path = Storage::url('uploads/absensi/'.$absentoday->foto_out)
                                @endphp
                                <img src="{{url($path)}}" alt="" class="imaged w48">
                                @else
                                <ion-icon name="camera"></ion-icon>
                                @endif
                            </div>
                            <div class="presencedetail">
                                <h4 class="presencetitle">Pulang</h4>
                                <span>{{ $absentoday != null && $absentoday->jam_out != null ? $absentoday->jam_out : 'Belum Absen' }}</span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   

    <div id="rekapabsensi">
        <h3>Rekap Presensi Bulan {{$namabulan[$bulanini]}}   Tahun  {{$tahunini}}    </h3>
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <div class="card-body d-flex flex-column align-items-center" style="padding: 16px 12px !important">
                        <span class="badge bg-success" style="position: absolute; top: 3px; right:10px; font-size: 0.5rem; z-index:999">
                            {{$rekapabsen->jmlhadir}}
                        </span>
                        <ion-icon name="accessibility-outline" style="font-size: 1.6rem;" class="text-success"></ion-icon>
                        <span style="font-size: 0.8rem" class="font-weight-bold">hadir</span>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body d-flex flex-column align-items-center" style="padding: 16px 12px !important">
                        <span class="badge bg-primary" style="position: absolute; top: 3px; right:10px; font-size: 0.5rem; z-index:999">{{$dataizin->jmlizin}}</span>
                        <ion-icon name="newspaper-outline" style="font-size: 1.6rem;" class="text-primary"></ion-icon>
                        <span style="font-size: 0.8rem" class="font-weight-bold">Izin</span>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body d-flex flex-column align-items-center" style="padding: 16px 12px !important">
                        <span class="badge bg-warning" style="position: absolute; top: 3px; right:10px; font-size: 0.5rem; z-index:999">{{$dataizin->jmlsakit}}</span>
                        <ion-icon name="medkit-outline" style="font-size: 1.6rem" class="text-warning"></ion-icon>
                        <span style="font-size: 0.8rem" class="font-weight-bold">Sakit</span>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <div class="card-body d-flex flex-column align-items-center" style="padding: 16px 12px !important">
                        <span class="badge bg-danger" style="position: absolute; top: 3px; right:10px; font-size: 0.5rem; z-index:999">
                            {{$rekapabsen->jmlterlambat}}
                        </span>
                        <ion-icon name="time-outline" style="font-size: 1.6rem" class="text-danger"></ion-icon>
                        <span style="font-size: 0.8rem" class="font-weight-bold">terlambat</span>
                    </div>
                </div>
            </div>
            <div>
                {{-- <h3>Izin yang tidak ter-approve: {{$dataizin->jmlmenunggu}}</h3>
                <h3>Izin yang ditolak: {{$dataizin->jmlditolak}}</h3>
                <h3>Izin yang disetujui: {{$dataizin->jmldisetujui}}</h3> --}}
            </div>
        </div>
    </div>

    <div class="presencetab mt-2">
        <div class="tab-pane fade show active" id="pilled" role="tabpanel">
            <ul class="nav nav-tabs style1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                        Bulan Ini
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content mt-2" style="margin-bottom:100px;">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                <ul class="listview image-listview">
                   @foreach ($historyabsen as $item)
                   @php
                       $path = Storage::url('uploads/absensi/'.$item->foto_in);
                   @endphp
                   <li>
                    <div class="item">
                        <div class="icon-box bg-primary">
                         <img src="{{url($path)}}" alt="" class="imaged w64">
                        </div>
                         <div class="in">
                             <div>{{ date("d-m-Y",strtotime($item->tanggal_presensi))}}</div>
                             <div class="flex">
                                <span class="badge badge-success">{{$item->jam_in}}</span>
                                <span class="badge-badge danger">{{$absentoday != null && $item->jam_out != null ? $item->jam_out
                                : 'Belum Absen'}}</span>
                             </div>
                         </div>
                     </div>
                </li>
                   @endforeach
                </ul>
            </div>

        </div>
    </div>
</div>
@endsection