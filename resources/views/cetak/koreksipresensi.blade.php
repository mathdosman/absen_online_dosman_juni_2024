<form action="/storekoreksipresensi" method="POST" id="koreksipresensi">
    @csrf
    <input type="hidden" name="nisn" value="{{$siswa->nisn}}">
    <input type="hidden" name="tanggal" value="{{$tanggal}}">
    <table class="table">
        <tr>
            <th>NIK</th>
            <td>:</td>
            <td>{{$siswa->nisn}}</td>
        </tr>
        <tr>
            <th>NAMA</th>
            <td>:</td>
            <td>{{$siswa->nama_siswa}}</td>
        </tr>
        <tr>
            <th>TANGGAL</th>
            <td>:</td>
            <td>{{tgl_indo($tanggal)}}</td>
        </tr>
    </table>


    <div class="form-group">
        <div class="row">
            <div class="col-12">
                <span class="text-warning">Jam Masuk</span>
                <div class="input-icon mb-1">
                    <span class="input-icon-addon">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clock"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>
                    </span>
                    <input type="time" value="" class="form-control" name="jam_in" id="jam_in" maxlength="10" placeholder="Jam Masuk">
                  </div>
                {{-- <div class="input-icon mb-1">
                    <span class="input-icon-addon">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clock"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>
                    </span>
                    <input type="time" value="" class="form-control" name="jam_out" id="jam_out" maxlength="10" placeholder="Jam Pulang">
                  </div> --}}
                  <div class="form-group">
                    <select name="kode_jam" id="kode_jam" class="form-select" required>
                        <option value="">Pilih Jam Sekolah</option>
                        @foreach ($jamsekolah as $d)
                            <option value="{{$d->kode_jam}}">({{$d->kode_jam}}) {{$d->nama_jam}}</option>
                        @endforeach
                    </select>
                  </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <button class="btn btn-primary w-100"></button>
                </div>
            </div>
        </div>
    </div>
</form>
