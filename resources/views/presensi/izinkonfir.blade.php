@extends('layout.admin.master')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title text-center">
                    Konfirmasi Izin
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nim</th>
                            <th>Nama</th>
                            <th>Status ijin</th>
                            <th>keterangan</th>
                            <th>Approval</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($izinsakit as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{date('d-m-Y',strtotime($item->tanggal_izin)) }}</td>
                            <td>{{$item->nim}}</td>
                            <td>{{$item->nama_lengkap}}</td>
                            <td>{{$item->status == '1' ? 'Izin' : 'Sakit'}}</td>
                            <td>{{$item->keterangan}}</td>
                            <td>
                                @if ($item->status_acc == '1')
                                    <span class="badge bg-success">Disetujui</span>
                                    @elseif($item->status_acc == '2')
                                    <span class="badge bg-danger">Ditolak</span>
                                    @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->status_acc == '0')
                                <a href="#" class="btn btn-primary" id="approve" id_izin="{{$item->id}}">
                                    =>
                                </a>
                                @else
                                <a href="/presensi/{{$item->id}}/batalapprove" class="btn btn-danger">
                                    cancel
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-approvalizin" tabindex="1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approval Izin/Sakit</h5>
                <button type="button" class="btn-close" data-bs-dissmiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/presensi/approveizin" method="POST">
                    @csrf
                    <input type="hidden" id="id_izinform" name="id_izinform">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <select class="form-select" aria-label="Default select example" name="status_acc" id="status_acc"> 
                                        <option selected>Pilih Approval</option>
                                        <option value="1">Disetujui</option>
                                        <option value="2">Ditolak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('myscript')
<script>
    $(function(){
        $('#approve').on('click', function(){
            var id_izin = $(this).attr("id_izin")
            // alert(id_izin);
            $("#id_izinform").val(id_izin);
            $('#modal-approvalizin').modal('show');
        })

    })
</script>
    
@endpush