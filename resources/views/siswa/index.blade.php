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
          DATA SISWA
          </h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                            @if(Session::get('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                    @endif
                    @if(Session::get('error'))
                    <div class="alert alert-warning">
                        {{ Session::get('error') }}
                    </div>
                    @endif
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col">
                                <a href="#" class="btn btn-primary" id="btntambahsiswa">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M12 11l0 6" /><path d="M9 14l6 0" /></svg>
                                Tambah Data</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <form action="/siswa/" method="GET">
                                    <div class="row mb-2">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Nama Siswa" name="nama_siswa" id="nama_siswa" value="{{Request('nama_siswa') }}">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <select name="kode_kelas" id="kode_kelas" class="form-select" >
                                                    <option value="" >Kelas</option>
                                                    @foreach ($kelas as $d)
                                                    <option {{Request('kode_kelas') == $d->kode_kelas ? 'selected' : '' }} value="{{$d -> kode_kelas }}" > {{ $d->nama_kelas }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <button class="btn btn-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                                Cari</button>
                                            </div>
                                        </div>
                                        <div class="col-2">

                                                <a href="/siswa" class="btn btn-secondary">
                                                Reset</a>

                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    <div class="row">
                        <div class="col-12">
                        <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>NISN</th>
                            <th>Kelas</th>
                            <th>Lokasi</th>
                            <th>NAMA</th>
                            <th>No. Hp</th>
                            <th>Foto</th>
                            <th>Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($siswa as $d)
                        @php
                            $path = Storage::url('uploads/profile/'.$d->foto);
                        @endphp
                        <tr class="text-center" >
                            <td>{{ $loop->iteration + $siswa->firstItem() - 1 }}</td>
                            <td>{{ $d->nisn }}</td>
                            <td>{{ $d->kode_kelas }}</td>
                            <td>{{$d->kode_lokasi}}</td>
                            <td class="text-start !important">{{ $d->nama_siswa }}</td>
                            <td>{{ $d->no_hp }}</td>
                            <td class="text-center">
                                @if(empty($d->foto))
                                <img src="{{asset('assets/img/sample/avatar/avatar1.jpg')}}" class="avatar" alt="">
                                @else
                                <a href="#" nisn="{{ $d->nisn }}" class="fotox">
                                    <img src="{{url($path)}}" class="avatar" alt="">
                                    </a>
                                    @endif
                                    </td>
                            <td>{{ $d->jabatan }}</td>
<!-- AKSI start-->
                            <td class="text-center">
                                <a href="#" class="edit bg-info border" style="padding: 0.4px;" nisn="{{$d->nisn}}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                </a>
                                <a href="/konfigurasi/{{$d->nisn}}/setjamsekolah" class="bg-success border text-light" style="padding: 0.4px;" nisn="{{ $d -> nisn }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg>
                                </a>
                                <form action="/siswa/{{$d->nisn}}/delete" method="POST">
                                @csrf
                                <a class="btn btn-danger btn-sm border delete-confirm" ><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg></a>
                                </form>
                            </td>
<!-- AKSI end -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                        </div>
                    </div>

                {{$siswa -> links('vendor.pagination.bootstrap-5')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- MODAL TAMBAH DATA --}}

<div class="modal modal-blur fade" id="modaltambahsiswa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Siswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="/siswa/store" method="POST" id="frmsiswa" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-badge-right-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 6l-.112 .006a1 1 0 0 0 -.669 1.619l3.501 4.375l-3.5 4.375a1 1 0 0 0 .78 1.625h6a1 1 0 0 0 .78 -.375l4 -5a1 1 0 0 0 0 -1.25l-4 -5a1 1 0 0 0 -.78 -.375h-6z" stroke-width="0" fill="currentColor" /></svg>
                        </span>
                        <input type="text" value="" class="form-control" name="nisn" id="nisn" maxlength="10" placeholder="NISN" required>
                      </div>
                </div>
                <div class="row">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-badge-right-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 6l-.112 .006a1 1 0 0 0 -.669 1.619l3.501 4.375l-3.5 4.375a1 1 0 0 0 .78 1.625h6a1 1 0 0 0 .78 -.375l4 -5a1 1 0 0 0 0 -1.25l-4 -5a1 1 0 0 0 -.78 -.375h-6z" stroke-width="0" fill="currentColor" /></svg>
                        </span>
                        <input type="text" value="" class="form-control" name="nama_siswa" id="nama_siswa" placeholder="Nama Siswa" required>
                      </div>
                </div>

                <div class="row">
                    <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-badge-right-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 6l-.112 .006a1 1 0 0 0 -.669 1.619l3.501 4.375l-3.5 4.375a1 1 0 0 0 .78 1.625h6a1 1 0 0 0 .78 -.375l4 -5a1 1 0 0 0 0 -1.25l-4 -5a1 1 0 0 0 -.78 -.375h-6z" stroke-width="0" fill="currentColor" /></svg>
                        </span>
                        <input type="text" value="" class="form-control" name="no_hp" id="no_hp" placeholder="No. Hp" required>
                      </div>
                </div>

                <div class="row">
                    <div class="input-icon mb-3">
                        <select name="jabatan" id="jabatan" class="form-select" required>
                            <option value="" hidden>Jabatan</option>
                            <option value="Siswa">Siswa</option>
                            <option value="Guru">Guru</option>
                        </select>
                      </div>
                </div>
                <div class="row">
                    <div class="input-icon mb-3">
                        <select name="kode_kelas" id="kode_kelas" class="form-select" required>
                            <option value="" hidden>Kelas</option>
                            @foreach ($kelas as $d)
                            <option {{Request('kode_kelas') == $d->kode_kelas ? 'selected' : '' }} value="{{$d->kode_kelas }}">{{ $d->nama_kelas }}</option>
                            @endforeach
                        </select>
                      </div>
                </div>
                <div class="row">
                    <div class="input-icon mb-3">
                        <select name="kode_lokasi" id="kode_lokasi" class="form-select" required>
                            <option value="">Lokasi</option>
                            @foreach ($lokasi as $d)
                            <option {{Request('kode_lokasi') == $d->kode_lokasi ? 'selected' : '' }} value="{{$d->kode_lokasi }}">({{strtoupper($d->kode_lokasi)}}) {{$d->nama_lokasi}}</option>
                            @endforeach
                        </select>
                      </div>
                </div>

                <div class="mb-3">
                <div class="form-label">Tambahkan Foto Profile</div>
                <input type="file" class="form-control" name="foto" id="foto">
                </div>

                <div class="modal-footer form-group">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="" class="btn btn-primary" >Save changes</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
{{-- ======================================================================================= --}}
  <div class="modal modal-blur fade" id="modaleditsiswa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="loadeditform">

        </div>
      </div>
    </div>
  </div>
{{-- =================================================================================== --}}
  <div class="modal modal-blur fade" id="modalfotosiswa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Foto Profile Siswa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="loadfotoform">

        </div>
      </div>
    </div>
  </div>
@endsection

@push('myscript')
    <script>
        $(function(){
            $("#nisn").mask("0000000000");
            $("#no_hp").mask("0000000000000");

            $("#btntambahsiswa").click(function(){
                $("#modaltambahsiswa").modal("show");
            });

            $(".edit").click(function(){
                var nisn = $(this).attr('nisn');
                $.ajax({
                    type: 'POST',
                    url:'/siswa/edit',
                    cache: false ,
                    data: {
                        _token: "{{csrf_token(); }}",
                        nisn: nisn
                    },
                    success:function(respond){
                        $("#loadeditform").html(respond);
                    }
                });
                $("#modaleditsiswa").modal("show");
            });

            $(".fotox").click(function(){
                var nisn = $(this).attr('nisn');
                $.ajax({
                    type: 'POST',
                    url:'/siswa/fotox',
                    cache: false ,
                    data: {
                        _token: "{{csrf_token(); }}",
                        nisn: nisn
                    },
                    success:function(respond){
                        $("#loadfotoform").html(respond);
                    }
                });
                $("#modalfotosiswa").modal("show");
            });

            $(".delete-confirm").click(function(e){
                var form = $(this).closest('form');
                e.preventDefault();
                Swal.fire({
                title: "Anda yakin?",
                text: "Data akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, hapus data!"
                }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire({
                    title: "Terhapus!",
                    text: "Data telah terhapus.",
                    icon: "success"
                    });
                }
                });
            });


        });
    </script>
@endpush
