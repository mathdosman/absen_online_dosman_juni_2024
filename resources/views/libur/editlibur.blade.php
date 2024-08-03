<form action="/konfigurasi/updatelibur" method="POST" id="frmharilibur" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="input-icon mb-3">
            <input type="date" value="" class="form-control" name="tgl_libur" id="tgl_libur" placeholder="Tanggal Libur" required>
          </div>
    </div>
    <div class="row">
        <div class="input-icon mb-3">
            <select name="kode_lokasi" id="kode_lokasi" class="form-select" required>
                <option value="">Lokasi</option>
                {{-- @foreach ($lokasi as $d)
                <option value="{{$d->kode_lokasi}}">({{$d->kode_lokasi}}) {{$d->nama_lokasi}}</option>
                @endforeach --}}
            </select>
        </div>
    </div>
    <div class="row">
        <div class="input-icon mb-3">
            <input type="textarea" value="" class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan" required>
          </div>
    </div>

    <div class="modal-footer form-group">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
        <button type="" class="btn btn-primary" >Save changes</button>
    </div>
</form>
