<form action="/siswa/{{$siswa->nisn}}/update" method="POST" id="frmKaryawan" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="input-icon mb-3">
            <span class="input-icon-addon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-badge-right-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 6l-.112 .006a1 1 0 0 0 -.669 1.619l3.501 4.375l-3.5 4.375a1 1 0 0 0 .78 1.625h6a1 1 0 0 0 .78 -.375l4 -5a1 1 0 0 0 0 -1.25l-4 -5a1 1 0 0 0 -.78 -.375h-6z" stroke-width="0" fill="currentColor" /></svg>
            </span>
            <input type="text" value="{{$siswa->nisn}}" class="form-control" name="nisn" id="nisn" maxlength="10" placeholder="NISN" readonly>
          </div>
    </div>
    <div class="row">
        <div class="input-icon mb-3">
            <span class="input-icon-addon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-badge-right-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 6l-.112 .006a1 1 0 0 0 -.669 1.619l3.501 4.375l-3.5 4.375a1 1 0 0 0 .78 1.625h6a1 1 0 0 0 .78 -.375l4 -5a1 1 0 0 0 0 -1.25l-4 -5a1 1 0 0 0 -.78 -.375h-6z" stroke-width="0" fill="currentColor" /></svg>
            </span>
            <input type="text" value="{{$siswa->nama_siswa}}" class="form-control" name="nama_siswa" id="nama_siswa" placeholder="Nama Siswa">
          </div>
    </div>

    <div class="row">
        <div class="input-icon mb-3">
            <span class="input-icon-addon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-badge-right-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 6l-.112 .006a1 1 0 0 0 -.669 1.619l3.501 4.375l-3.5 4.375a1 1 0 0 0 .78 1.625h6a1 1 0 0 0 .78 -.375l4 -5a1 1 0 0 0 0 -1.25l-4 -5a1 1 0 0 0 -.78 -.375h-6z" stroke-width="0" fill="currentColor" /></svg>
            </span>
            <input type="text" value="{{$siswa->no_hp}}" class="form-control" name="no_hp" id="no_hp" placeholder="No. Hp">
          </div>
    </div>

    <div class="row">
        <div class="input-icon mb-3">
            <select name="jabatan" id="jabatan" class="form-select">
                <option value="" hidden>Jabatan</option>
                <option {{ $siswa->jabatan == "Siswa" ? 'selected':''}} value="Siswa">Siswa</option>
                <option {{ $siswa->jabatan == "Guru" ? 'selected':''}} value="Guru">Guru</option>
            </select>
          </div>
    </div>
    <div class="row">
        <div class="input-icon mb-3">
            <select name="kode_kelas" id="kode_kelas" class="form-select">
                <option value="" hidden>Kelas</option>
                @foreach ($kelas as $d)
                <option {{ $siswa->kode_kelas == $d->kode_kelas ? 'selected':''}} value="{{$d -> kode_kelas }}"> {{ $d -> nama_kelas }} </option>
                @endforeach
            </select>
          </div>
    </div>
    <div class="row">
        <div class="input-icon mb-3">
            <select name="kode_lokasi" id="kode_lokasi" class="form-select">
                <option value="">Lokasi</option>
                @foreach ($lokasi as $d)
                    <option {{$siswa->kode_lokasi == $d->kode_lokasi ? 'selected':'' }} value="{{$d->kode_lokasi}}">({{strtoupper($d->kode_lokasi)}}) {{$d->nama_lokasi}}</option>
                @endforeach
            </select>
          </div>
    </div>

    <div class="mb-3">
    <div class="form-label">Tambahkan Foto Profile</div>
    <input type="file" class="form-control" name="foto" id="foto">
    <input type="hidden" name="old_foto" value="{{ $siswa -> foto}}">
    </div>

    <div class="modal-footer form-group">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
        <button type="" class="btn btn-primary" >Save changes</button>
    </div>
</form>
