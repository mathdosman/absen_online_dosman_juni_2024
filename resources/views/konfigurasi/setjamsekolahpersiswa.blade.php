@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
        <div class="col">
        <!-- Page pre-title -->
          <div class="page-pretitle">
          SMA Negeri 1 Gianyar
          </div>
          <h2 class="page-title">
          SET JAM SEKOLAH PER SISWA
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
                                    <div class="col">
                                    @if(Session::get('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                            @endif

                            @if(Session::get('warning'))
                            <div class="alert alert-warning">
                                {{ Session::get('warning') }}
                            </div>
                            @endif
                                    </div>
                                </div>
                                <table class="table">
                                    <tr>
                                        <th>NISN</th>
                                        <td>:</td>
                                        <td>{{$siswa->nisn}}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Lengkap</th>
                                        <td>:</td>
                                        <td>{{$siswa->nama_siswa}}</td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 border">
                                        <form action="/konfigurasi/storesetjamsekolah" method="POST">
                                            @csrf
                                            <input type="hidden" name="nisn" value="{{$siswa->nisn}}">
                                            <table class="table">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th>Hari</th>
                                                        <th>Sekolah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Senin
                                                            <input type="hidden" name="hari[]" value="Senin">
                                                        </td>
                                                        <td>
                                                            <select name="kode_jam[]" id="kode_jam" class="form-select">
                                                                <option value="">Pilih Jam Sekolah</option>
                                                                @foreach ($jamsekolah as $d)
                                                                    <option value="{{$d->kode_jam}}">({{$d->kode_jam}}) {{$d->nama_jam}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Selasa
                                                            <input type="hidden" name="hari[]" value="Selasa">
                                                        </td>
                                                        <td>
                                                            <select name="kode_jam[]" id="kode_jam" class="form-select">
                                                                <option value="">Pilih Jam Sekolah</option>
                                                                @foreach ($jamsekolah as $d)
                                                                    <option value="{{$d->kode_jam}}">({{$d->kode_jam}}) {{$d->nama_jam}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Rabu
                                                            <input type="hidden" name="hari[]" value="Rabu">
                                                        </td>
                                                        <td>
                                                            <select name="kode_jam[]" id="kode_jam" class="form-select">
                                                                <option value="">Pilih Jam Sekolah</option>
                                                                @foreach ($jamsekolah as $d)
                                                                    <option value="{{$d->kode_jam}}">({{$d->kode_jam}}) {{$d->nama_jam}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kamis
                                                            <input type="hidden" name="hari[]" value="Kamis">
                                                        </td>
                                                        <td>
                                                            <select name="kode_jam[]" id="kode_jam" class="form-select">
                                                                <option value="">Pilih Jam Sekolah</option>
                                                                @foreach ($jamsekolah as $d)
                                                                    <option value="{{$d->kode_jam}}">({{$d->kode_jam}}) {{$d->nama_jam}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jumat
                                                            <input type="hidden" name="hari[]" value="Jumat">
                                                        </td>
                                                        <td>
                                                            <select name="kode_jam[]" id="kode_jam" class="form-select">
                                                                <option value="">Pilih Jam Sekolah</option>
                                                                @foreach ($jamsekolah as $d)
                                                                    <option value="{{$d->kode_jam}}">({{$d->kode_jam}}) {{$d->nama_jam}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sabtu
                                                            <input type="hidden" name="hari[]" value="Sabtu">
                                                        </td>
                                                        <td>
                                                            <select name="kode_jam[]" id="kode_jam" class="form-select">
                                                                <option value="">Pilih Jam Sekolah</option>
                                                                @foreach ($jamsekolah as $d)
                                                                    <option value="{{$d->kode_jam}}">({{$d->kode_jam}}) {{$d->nama_jam}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Minggu
                                                            <input type="hidden" name="hari[]" value="Minggu">
                                                        </td>
                                                        <td>
                                                            <select name="kode_jam[]" id="kode_jam" class="form-select">
                                                                <option value="">Pilih Jam Sekolah</option>
                                                                @foreach ($jamsekolah as $d)
                                                                    <option value="{{$d->kode_jam}}">({{$d->kode_jam}}) {{$d->nama_jam}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <button class="btn btn-primary w-100" type="submit">Simpan</button>
                                        </form>
                                    </div>
                                    <div class="col-6 border">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th colspan="6" class="text-center">MASTER JAM SEKOLAH</th>
                                                </tr>
                                                <tr>
                                                    <th>Kode</th>
                                                    <th>Nama</th>
                                                    <th>Start Masuk</th>
                                                    <th>Bel Sekolah</th>
                                                    <th>Akhir Masuk</th>
                                                    <th>Bel Pulang</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($jamsekolah as $d)
                                                <tr>
                                                        <td>{{$d->kode_jam}}</td>
                                                        <td>{{$d->nama_jam}}</td>
                                                        <td>{{date("H:i",strtotime($d->start_datang))}}</td>
                                                        <td>{{date("H:i",strtotime($d->bel_sekolah))}}</td>
                                                        <td>{{date("H:i",strtotime($d->end_datang))}}</td>
                                                        <td>{{date("H:i",strtotime($d->start_pulang))}}</td>
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
    </div>
</div>
@endsection
