@extends('layouts.admin.tabler')
@section('header')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
            SMA Negeri 1 Gianyar
          </div>
          <h2 class="page-title">
            SET JAM SEKOLAH PER KELAS
          </h2>
        </div>

      </div>
    </div>
  </div>
@endsection

@section('content')
<div class="page-body">
    <div class="container-xl">
        <form action="/konfigurasi/jamkelas/store" method="POST">
            @csrf
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
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <select name="kode_lokasi" id="kode_lokasi" class="form-select" required>
                                                        <option value="">Pilih Lokasi</option>
                                                        @foreach ($lokasi as $d)
                                                            <option value="{{$d->kode_lokasi}}">({{$d->kode_lokasi}}) {{strtoupper($d->nama_lokasi)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <select name="kode_kelas" id="kode_kelas" class="form-select" required>
                                                        <option value="">Pilih Kelas</option>
                                                        @foreach ($kelas as $d)
                                                            <option value="{{$d->kode_kelas}}">{{strtoupper($d->nama_kelas)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 border">
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
                                                                <option value="" >Pilih Jam Sekolah</option>
                                                                @foreach ($jamsekolah as $d)
                                                                <option class="text-uppercase" value="{{$d->kode_jam}}">({{$d->kode_jam}}){{strtoupper($d->nama_jam)}}</option>
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
                                                                <option value="" >Pilih Jam Sekolah</option>
                                                                @foreach ($jamsekolah as $d)
                                                                <option class="text-uppercase" value="{{$d->kode_jam}}">({{$d->kode_jam}}) {{strtoupper($d->nama_jam)}}</option>
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
                                                                <option value="" >Pilih Jam Sekolah</option>
                                                                @foreach ($jamsekolah as $d)
                                                                <option class="text-uppercase" value="{{$d->kode_jam}}">({{$d->kode_jam}}) {{strtoupper($d->nama_jam)}}</option>
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
                                                                <option value="" >Pilih Jam Sekolah</option>
                                                                @foreach ($jamsekolah as $d)
                                                                <option class="text-uppercase" value="{{$d->kode_jam}}">({{$d->kode_jam}}) {{strtoupper($d->nama_jam)}}</option>
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
                                                                <option value="" >Pilih Jam Sekolah</option>
                                                                @foreach ($jamsekolah as $d)
                                                                <option class="text-uppercase" value="{{$d->kode_jam}}">({{$d->kode_jam}}) {{strtoupper($d->nama_jam)}}</option>
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
                                                                <option value="" >Pilih Jam Sekolah</option>
                                                                @foreach ($jamsekolah as $d)
                                                                <option class="text-uppercase" value="{{$d->kode_jam}}">({{$d->kode_jam}}) {{strtoupper($d->nama_jam)}}</option>
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
                                                                <option value="" >Pilih Jam Sekolah</option>
                                                                @foreach ($jamsekolah as $d)
                                                                <option class="text-uppercase" value="{{$d->kode_jam}}">({{$d->kode_jam}}) {{strtoupper($d->nama_jam)}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <button class="btn btn-primary w-100" type="submit">Simpan</button>

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
                                                    <th>Awal</th>
                                                    <th>Bel Masuk</th>
                                                    <th>Akhir</th>
                                                    <th>Bel Pulang</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($jamsekolah as $d)
                                                <tr>
                                                    <th>{{$d->kode_jam}}</th>
                                                    <td>{{strtoupper($d->nama_jam)}}</td>
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
        </form>
    </div>
</div>
@endsection
