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
          MONITORING ABSENSI
          </h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
    <div class="container-xl">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                <div class="form-group">
                <div class="input-icon mb-3">
                                <span class="input-icon-addon" >
                                  <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12.5 21h-6.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v5" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M16 19h6" /><path d="M19 16v6" /></svg>
                                </span>
                                <input type="text" value="{{ date("Y-m-d")}}" id="tanggal" name="tanggal" class="form-control" placeholder="Tanggal Absen" autocomplete="off">
                              </div>
            </div>
        </div>
                </div>
            </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered border-2">
                <thead>
                    <tr>
                        <th class="text-center !important" style="background-color: rgb(247, 202, 202)">No</th>
                        <th class="text-center !important" style="background-color: rgb(247, 202, 202)" >NISN</th>
                        <th class="text-center !important" style="background-color: rgb(247, 202, 202)" >Nama Lengkap</th>
                        <th class="text-center !important" style="background-color: rgb(247, 202, 202)" >Kelas</th>
                        <th class="text-center !important" style="background-color: rgb(247, 202, 202)" >Jadwal</th>
                        <th class="text-center !important" style="background-color: rgb(247, 202, 202)" >Jam Masuk</th>
                        <th class="text-center !important" style="background-color: rgb(247, 202, 202)" >Foto Masuk</th>
                        <th class="text-center !important" style="background-color: rgb(247, 202, 202)" >Jam Pulang</th>
                        <th class="text-center !important" style="background-color: rgb(247, 202, 202)" >Foto Pulang</th>
                        <th class="text-center !important" style="background-color: rgb(247, 202, 202)" >Keterangan</th>
                    </tr>
                </thead>
                <tbody id="loadpresensi" class="text-center">

                </tbody>
            </table>
        </div>
    </div>

    </div>
</div>
{{-- MODAL EDIT --}}
<div class="modal modal-blur fade" id="modaltampilkanfoto_in" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Foto Absen Masuk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="loadfotoin">

        </div>
      </div>
    </div>
  </div>

  <div class="modal modal-blur fade" id="modaltampilkanfoto_out" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Foto Absen Pulang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="loadfoto_out">

        </div>
      </div>
    </div>
  </div>
@endsection

@push('myscript')
    <script>
    $(function () {
        $("#tanggal").datepicker({
        autoclose: true,
        todayHighlight: true,
        format: "yyyy-mm-dd"
        });

        function loadpresensi(){
            var tanggal = $("#tanggal").val();
            $.ajax({
                type:'POST',
                url:'/getpresensi',
                data:{
                    _token:"{{csrf_token()}}",
                    tanggal: tanggal
                },
                cache:false,
                success:function(respond){
                    $("#loadpresensi").html(respond);
                }
            });
        }

        $("#tanggal").change(function(e){
            loadpresensi();
        });

        loadpresensi();
    });
    </script>
@endpush
