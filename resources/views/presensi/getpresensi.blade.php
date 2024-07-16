@foreach ($presensi as $a)
@php
    $fotoIn = Storage::url('uploads/absensi/'.$a->foto_in);
    $fotoOut = Storage::url('uploads/absensi/'.$a->foto_out);
@endphp
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$a->nim}}</td>
        <td>{{$a->nama_lengkap}}</td>
        <td>{{$a->asal}}</td>
        <td>{{$a->jam_in}}</td>
        <td>
            <img src="{{url($fotoIn)}}" class="imaged w48" style="width: 150px" alt="foto masuk">
        </td>
        <td>{{$a->jam_out != null ? $a->jam_out : 'belum absen pulang'}}</td>
        <td>
            @if ($a->jam_out != null)
            <img src="{{$fotoOut}}" class="avatar" style="width: 150px" alt="foto keluar">
            @else
            <p>belum foto keluar</p>
            @endif
           
        </td>
        <td>
            @if ($a->jam_in >= "08:00")
                <span class="badge bg-danger">Terlambat</span>
            @else
                <span class="badge bg-success">Tepat Waktu</span>
            @endif
        </td>
    </tr>
@endforeach