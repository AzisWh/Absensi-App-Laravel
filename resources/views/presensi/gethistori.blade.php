@if ($history->isEmpty())
    <div class="alert alert-warning">
        <p>Data Belum Ada</p>
    </div>
@endif

@foreach ($history as $item)
    <ul class="listview image-listview">
        <li>
            <div class="item">
                @php
                        $path = Storage::url('uploads/absensi/'.$item->foto_in);
                @endphp
              
                 <img src="{{url($path)}}" alt="image" class="imaged w64">
                 <div class="in">
                     <div>{{ date("d-m-Y",strtotime($item->tanggal_presensi))}}</div>
                        <span class="badge {{$item->jam_in < "11.40" ? "bg-success" : "bg-danger"}}">
                            {{$item->jam_in}}
                        </span>                    
                        <span class="badge bg-primary">{{$item->jam_out}}</span>
                 </div>
             </div>
        </li>
    </ul>
@endforeach