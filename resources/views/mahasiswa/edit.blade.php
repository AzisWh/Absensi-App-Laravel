<form action="/mahasiswa/{{$mahasiswa->nim}}/update" method="POST" id="formmhs" enctype="multipart/form-data">
    @csrf
    <div class="row mt-3">
        <div class="col-12">
            <input type="text" readonly value="{{$mahasiswa->nim}}" id="nim" class="form-control" name="nim" placeholder="Nim">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <input type="text" value="{{$mahasiswa->nama_lengkap}}" id="nama_lengkap" class="form-control" name="nama_lengkap" placeholder="Nama Lengkap">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <input type="text" value="{{$mahasiswa->asal}}" id="asal" class="form-control" name="asal" placeholder="Asal Kampus">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <input type="text" value="{{$mahasiswa->no_hp}}" id="no_hp" class="form-control" name="no_hp" placeholder="Nomor Hp">
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <input type="file" value="{{$mahasiswa->foto_profile}}" id="foto_profile" class="form-control" name="foto_profile" placeholder="Foto Profile">
            <input type="hidden" name="old_foto" value="{{$mahasiswa->foto_profile}}">
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