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
            DATA PENGAJUAN IZIN & SAKIT
          </h2>
        </div>

      </div>
    </div>
  </div>

@endsection
@section('content')
<div class="page-body">
    <div class="container-xl">
       <div class="card">
        <div class="card-body">
            <div class="col">
                @php
                    $messagesuccess=Session::get('success');
                    $messageerror=Session::get('warning');
                @endphp
                @if(Session::get('success'))
                    <div class="alert alert-success">
                        {{$messagesuccess}}
                    </div>
                @endif
                @if(Session::get('warning'))
                    <div class="alert alert-danger">
                        {{$messageerror}}
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="/presensi/izinsakit" method="GET" autocomplete="off">
                        <div class="row">
                            <div class="col-3">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                      <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                                    </span>
                                    <input type="text" value="{{Request('dari')}}" name="dari" id="dari" class="form-control" placeholder="Dari">
                                    </div>
                            </div>
                            <div class="col-3">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                      <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                                    </span>
                                    <input type="text" value="{{Request('sampai')}}" name="sampai" id="sampai" class="form-control" placeholder="Sampai">
                                    </div>
                            </div>
                            <div class="col-3">
                                <div class="input-icon mb-3">
                                    <select name="kode_kelas" id="kode_kelas" class="form-select">
                                        <option  value="">Kelas</option>
                                        @foreach ($kelas as $d)
                                        <option {{Request('kode_kelas') == $d->kode_kelas ? 'selected' : '' }} value="{{$d->kode_kelas }}">{{ $d->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                  </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                      <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-prompt" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 7l5 5l-5 5" /><path d="M13 17l6 0" /></svg>
                                    </span>
                                    <input type="text" value="{{Request('nisn')}}" name="nisn" id="nisn" class="form-control" placeholder="NISN">
                                    </div>
                            </div>
                            <div class="col-3">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                      <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                                    </span>
                                    <input type="text" value="{{Request('nama_siswa')}}" name="nama_siswa" id="nama_siswa" class="form-control" placeholder="Nama Siswa">
                                    </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <select name="status_approved" id="status_approved" class="form-select">
                                        <option value="" hidden>Pilih Status</option>
                                        <option value="0" {{Request('status_approved')=== '0' ? 'selected' : ''}}>Menunggu</option>
                                        <option value="1" {{Request('status_approved')== 1 ? 'selected' : ''}}>Disetujui</option>
                                        <option value="2" {{Request('status_approved')== 2 ? 'selected' : ''}}>Ditolak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                        Search
                                    </button>
                                </div>
                            </div>
                            <div class="col-1 ms-2">
                                <div class="form-group">
                                    <a class="btn btn-secondary" href="/presensi/izinsakit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" /><path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" /></svg>
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-hover">
                            <thead class="text-center">
                                <tr>
                                    <th>No.</th>
                                    <th>Kode Ajuan</th>
                                    <th>Tanggal</th>
                                    <th>NISN</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Pengajuan</th>
                                    <th>Berkas</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="text-center">
                                @foreach ($izinsakit as $d)
                                   <tr>
                                    <td>{{$loop->iteration + $izinsakit->firstItem() -1}}</td>
                                    <td>{{$d->kode_izin}}</td>
                                    @if($d->tgl_izin_sampai == $d->tgl_izin_dari)
                                    <td width="150px">{{date('d-m-Y',strtotime($d->tgl_izin_dari))}}</td>
                                    @else
                                    <td width="150px">{{date('d-m-Y',strtotime($d->tgl_izin_dari))}} <br> s/d <br>{{date('d-m-Y',strtotime($d->tgl_izin_sampai))}}</td>
                                    @endif
                                    <td>{{$d->nisn}}</td>
                                    <td class="text-start">{{$d->nama_siswa}}</td>
                                    <td>{{$d->kode_kelas}}</td>
                                    @if($d->status== "i")
                                    <td>Izin <br> {{hitunghari($d->tgl_izin_dari,$d->tgl_izin_sampai)}} hari</td>
                                    @elseif($d->status== "s")
                                    <td>Sakit <br> {{hitunghari($d->tgl_izin_dari,$d->tgl_izin_sampai)}} hari</td>
                                    @elseif($d->status== "d")
                                    <td>Dispen <br> {{hitunghari($d->tgl_izin_dari,$d->tgl_izin_sampai)}} hari</td>
                                    @endif
                                    {{-- <td>{{$d->status== "i" ? "izin" : "sakit"}} <br> {{hitunghari($d->tgl_izin_dari,$d->tgl_izin_sampai)}} hari</td> --}}
                                    <td>
                                        <svg  xmlns="http://www.w3.org/2000/svg" class="suratizin text-success" kode_izin2="{{$d->kode_izin}}"   width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-briefcase"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M22 13.478v4.522a3 3 0 0 1 -3 3h-14a3 3 0 0 1 -3 -3v-4.522l.553 .277a20.999 20.999 0 0 0 18.897 -.002l.55 -.275zm-8 -11.478a3 3 0 0 1 3 3v1h2a3 3 0 0 1 3 3v2.242l-1.447 .724a19.002 19.002 0 0 1 -16.726 .186l-.647 -.32l-1.18 -.59v-2.242a3 3 0 0 1 3 -3h2v-1a3 3 0 0 1 3 -3h4zm-2 8a1 1 0 0 0 -1 1a1 1 0 1 0 2 .01c0 -.562 -.448 -1.01 -1 -1.01zm2 -6h-4a1 1 0 0 0 -1 1v1h6v-1a1 1 0 0 0 -1 -1z" /></svg>

                                        {{-- <a target="_blank" href="{{asset('storage/uploads/sid/'.$d->doc_sid)}}" id="kakul" style="color: blue;"><ion-icon name="attach-outline"></ion-icon>{{$d->doc_sid}}</a> --}}
                                    </td>
                                    <td class="text-start" width="300px">{{$d->keterangan}}</td>
                                    <td>
                                        @if ($d->status_approved == 1)
                                            <span class="badge bg-success text-light">Disetujui</span>
                                            @elseif ($d->status_approved == 2)
                                            <span class="badge bg-danger text-light">Ditolak</span>
                                            <br>
                                            <span>{{$d->alasan_tolak}}</span>
                                            @else
                                            <span class="badge bg-warning text-light">Menunggu</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($d->status_approved==0)
                                        <a href="#" class="btn btn-sm btn-primary persetujuan" kode_izin="{{$d->kode_izin}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                        </a>
                                        @else
                                        <a href="/presensi/{{$d->kode_izin}}/batalkanizinsakit" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Batalkan ajuan">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                    </a>
                                    @endif
                                    <a href="/ajuan/{{$d->kode_izin}}/delete" class=" delete-confirm btn btn-sm" data-toggle="tooltip" data-placement="top" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                    </a>
                                </td>

                                   </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$izinsakit->links('vendor.pagination.bootstrap-5')}}
                    </div>
                </div>
            </div>

            <div class="modal modal-blur fade" id="modalberkasajuan" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Berkas</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="loadberkasajuan">

                    </div>
                  </div>
                </div>
              </div>


      </div>
    </div>
  </div>
</div>

{{-- MODAL --}}
<div class="modal modal-blur fade" id="modal-izinsakit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Proses Pengajuan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/presensi/approveizinsakit" method="POST">
            @csrf
            <input type="hidden" id="kode_izin_form" name="kode_izin_form">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                    <select name="persetujuan" id="persetujuan" class="form-select">
                        <option value="1">Disetujui</option>
                        <option value="2">Ditolak</option>
                    </select>
                    <div class="row" id="frm_alasan">
                        <div class=" mb-2 mt-3">
                            <input type="text" value="" class="form-control" name="alasan_tolak" id="alasan_tolak" placeholder="Alasan tolak (kosongkan jika disetujui)">
                          </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-primary w-100" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-send" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 14l11 -11" /><path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" /></svg>
                            SUBMIT
                        </button>
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
            function load_alasan(){
                var persetujuan = $("#persetujuan").val();
                if(persetujuan == 1){
                    $("#frm_alasan").hide();
                    $("#alasan_tolak").removeAttr("required");
                }else{
                    $("#frm_alasan").show();
                    $("#alasan_tolak").attr("required", true);
                    }
                }

                $("#frm_alasan").hide();
                $("#persetujuan").change(function(e){
                    load_alasan();
                });

            $(".persetujuan").click(function(e){
                e.preventDefault();
                var kode_izin = $(this).attr("kode_izin");
                $("#kode_izin_form").val(kode_izin);
                $("#modal-izinsakit").modal("show");
            });
            $(".suratizin").click(function(){
                var kode_izin2 = $(this).attr('kode_izin2');
                $.ajax({
                    type: 'POST',
                    url:'/ajuan/surat',
                    cache: false ,
                    data: {
                        _token: "{{csrf_token(); }}",
                        kode_izin2: kode_izin2
                    },
                    success:function(respond){
                        $("#loadberkasajuan").html(respond);
                    }
                });
                $("#modalberkasajuan").modal("show");
            });

            $("#dari, #sampai").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: "yyyy-mm-dd"
        });

        $(".delete-confirm").click(function(e){
                var url = $(this).attr('href');
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
                    window.location.href = url;
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
