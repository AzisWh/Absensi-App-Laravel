@extends('layout.homeuser')

@section('header')
<!-- App Header -->
<div class="appHeader bg-danger text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Presensi Magang</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
<style>
    .webcam-container,
    .webcam-container video {
        display: inline-block;
        width: 100% !important;
        margin: auto;
        height: auto !important;
        max-height: 480px;
        border-radius: 15px;
    }

    #map {
        height: 180px;
    }
</style>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

@endsection

@section('content')
<div class="row" style="margin-top: 70px">
    <div class="col">
        {{-- cek getlocation --}}
        <input type="block" id="lokasi">
        <div class="webcam-container"></div>

    </div>

</div>
<div class="row">
    <div class="col">

        @if ($cek > 0)
        <button id="takeabsensi" class="btn btn-danger btn-block">Absen Pulang</button>
        @else

        <button id="takeabsensi" class="btn btn-primary btn-block">Absen Masuk</button>
        @endif

      
    </div>
</div>

{{-- maploc --}}
<div class="row mt-2">
    <div class="col">
        <div id="map"></div>
    </div>
</div>
@endsection

@push('myScript')
<script>
    Webcam.set({
        height: 480,
        width: 640,
        image_format: 'jpeg',
        jpeg_quality: 80
    });

    Webcam.attach('.webcam-container');

    var lokasi = document.getElementById('lokasi');
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            lokasi.value = position.coords.latitude + ',' + position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 18);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
            // var circle = L.circle([-6.982243732547198, 110.41295305719896], {
            var circle = L.circle([position.coords.latitude, position.coords.longitude], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 20
            }).addTo(map);
        });
    }

    $("#takeabsensi").click(function (e) {
    Webcam.snap(function (uri) {
        image = uri;
    });

    var lokasi = $("#lokasi").val();
    $.ajax({
        type: 'POST',
        url: '/presensi/store', 
        data: {
            _token: "{{ csrf_token() }}",
            image: image,
            lokasi: lokasi,
        },
        cache: false,
        success: function (respond) {
            // split data
            var status = respond.split("|");
            if(status[0] == 'success'){
                 Swal.fire({
                    title: 'Berhasil!',
                    text: status[1],
                    icon: 'success',
                    confirmButtonText: 'OK'
                    });
                    setTimeout(function () {
                        window.location.href = '/dashboard'; // Perbaikan pada penulisan 'location.href'
                    }, 3000);
            }else{
                Swal.fire({
                    title: 'Error!',
                    text: status[1],
                    icon: 'error',
                    confirmButtonText: 'OK'
                    });
            }
        },
        error: function (xhr, status, error) {
            // Tambahkan penanganan kesalahan AJAX
            console.error(xhr.responseText);
        }
    })
});

</script>

@endpush
