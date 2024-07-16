@extends('layout.admin.master')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col text-center">
          <!-- Page pre-title -->
          <div class="page-pretitle">
            Overview
          </div>
          <h2 class="page-title">
            Master Mahasiswa
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
                                    @if (Session::get('success'))
                                        <div class="alert alert-success">
                                        {{Session::get('success')}}

                                        </div>
                                    @elseif (Session::get('warning'))
                                    <div class="alert alert-danger">
                                        {{Session::get('warning')}}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="#" id="modalmahasiswa" class="btn btn-primary">Tambah Mahasiswa</a>
                            </div>
                        </div>
                        
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Nim</th>
                                    <th>Kampus Asal</th>
                                    <th>Nomor Hp</th>
                                    <th>Profile</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($mahasiswa as $item)
                                @php
                                    $path = Storage::url('uploads/mahasiswa/'.$item->foto_profile)
                                @endphp
                                <tr>
                                    <th>{{$loop->iteration}}</th>
                                    <th>{{$item->nama_lengkap}}</th>
                                    <th>{{$item->nim}}</th>
                                    <th>{{$item->asal}}</th>
                                    <th>{{$item->no_hp}}</th>
                                    <th>
                                        @if (empty($item->foto_profile))
                                        <img src="https://img.freepik.com/premium-photo/graphic-designer-digital-avatar-generative-ai_934475-9292.jpg" alt="/" class="img-thumbnail" style="width: 100px">
                                        @else
                                        <img src="{{url($path)}}" alt="/" class="img-thumbnail" style="width: 100px">
                                        @endif
                                    </th>
                                    <th>
                                        <div class="d-flex">
                                            <a href="#" class="edit" nim="{{$item->nim}}">
                                                <button class="btn btn-primary">edit</button>
                                            </a>
                                            <form action="{{ url('/mahasiswa/' . $item->nim . '/delete') }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger delete-alert">hapus</button>
                                            </form>
                                           
                                        </div>
                                    </th>
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
  
  {{-- modal tambah --}}
  <div class="modal modal-blur fade" id="modal-simple" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Mahasiswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/mahasiswa/store" method="POST" id="formmhs" enctype="multipart/form-data">
            @csrf
            <div class="row mt-3">
                <div class="col-12">
                    <input type="text" value="" id="nama_lengkap" class="form-control" name="nama_lengkap" placeholder="Nama Lengkap">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <input type="text" value="" id="nim" class="form-control" name="nim" placeholder="Nim">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <input type="text" value="" id="asal" class="form-control" name="asal" placeholder="Asal Kampus">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <input type="text" value="" id="no_hp" class="form-control" name="no_hp" placeholder="Nomor Hp">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <input type="file" value="" id="foto_profile" class="form-control" name="foto_profile" placeholder="Foto Profile">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                   <div class="form-group">
                    <button class="btn btn-primary w-100" type="submit">Simpan Data</button>
                   </div>
                </div>
            </div>
          </form>
        </div>
        
      </div>
    </div>
  </div>

  {{-- modaledit --}}
  <div class="modal modal-blur fade" id="modal-edit" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="loadeditform">
                
            </div>
        </div>
    </div>

</div>


@endsection

@push('myscript')
    <script>
        $(function(){
            $('#modalmahasiswa').on('click', function(){
                $('#modal-simple').modal('show');
            })  

            $('.edit').on('click', function(){
                var nim = $(this).attr('nim');
                $.ajax({
                    type: 'POST',
                    url: '/mahasiswa/edit',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        nim: nim
                    },
                    success: function(respond){
                        $('#loadeditform').html(respond);
                        $('#modal-edit').modal('show');
                    }
                })
            })   

            $('.delete-alert').on('click', function(){
                    var form = $(this).closest("form");

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: 'Data ini akan dihapus!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Tidak, batalkan'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire(
                                'Dibatalkan',
                                'Data Gagal ter Hapus',
                                'error'
                            );
                        }
                    });
                });                                             
        });

               
            

            $('#formmhs').submit(function(event){
                event.preventDefault();
                var nama_lengkap = $('#nama_lengkap').val();
                var nim = $('#nim').val();
                var asal = $('#asal').val();
                var no_hp = $('#no_hp').val();
                var foto_profile = $('#foto_profile').val();

                if(nama_lengkap == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Nama lengkap tidak boleh kosong',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    $("#nama_lengkap").focus();
                    return false;
                }
                if(nim == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Nim tidak boleh kosong',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    $("#nim").focus();
                    return false;
                }
                if(asal == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Asal kampus tidak boleh kosong',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    $("#asal").focus();
                    return false;
                }
                if(no_hp == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Nomor HP tidak boleh kosong',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    $("#no_hp").focus();
                    return false;
                }
                if(foto_profile == ""){
                    Swal.fire({
                        title: 'Error!',
                        text: 'Foto profile tidak boleh kosong',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    $("#foto_profile").focus();
                    return false;
                }

                this.submit();
            });
        


       
   

    </script>
@endpush
