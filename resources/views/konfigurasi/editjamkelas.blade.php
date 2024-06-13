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
            EDIT JAM SEKOLAH PER KELAS
          </h2>
        </div>

      </div>
    </div>
  </div>
@endsection

@section('content')
<div class="page-body">
    <div class="container-xl">
        <form action="/konfigurasi/jamkelas/{{$jamkelas->kode_js_kelas}}/update" method="POST">
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
                                                    <select name="kode_lokasi" id="kode_lokasi" class="form-select" disabled>
                                                        <option value="">Pilih Lokasi</option>
                                                        @foreach ($lokasi as $d)
                                                            <option {{$jamkelas->kode_lokasi == $d->kode_lokasi ? 'selected' : ''}} value="{{$d->kode_lokasi}}">({{$d->kode_lokasi}}) {{strtoupper($d->nama_lokasi)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <select name="kode_kelas" id="kode_kelas" class="form-select" disabled>
                                                        <option value="">Pilih Kelas</option>
                                                        @foreach ($kelas as $d)
                                                            <option {{$jamkelas->kode_kelas == $d->kode_kelas ? 'selected' : ''}} value="{{$d->kode_kelas}}" >{{strtoupper($d->nama_kelas)}}</option>
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
                                                    @foreach ($jamkelas_detail as $s)
                                                    <tr>
                                                        <td>
                                                            {{$s->hari}}
                                                            <input type="hidden" name="hari[]" value="{{$s->hari}}">
                                                        </td>
                                                        <td>
                                                            <select name="kode_jam[]" id="kode_jam" class="form-select">
                                                                <option value="">Pilih Jam Sekolah</option>
                                                                @foreach ($jamsekolah as $d)
                                                                    <option  {{$d->kode_jam ==$s->kode_jam ? 'selected' : ''}} value="{{$d->kode_jam}}">({{$d->kode_jam}}) {{$d->nama_jam}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <button class="btn btn-primary w-100" type="submit">UPDATE</button>

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
                                                    <th>Awal Masuk</th>
                                                    <th>Bel Masuk</th>
                                                    <th>Akhir Masuk</th>
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
