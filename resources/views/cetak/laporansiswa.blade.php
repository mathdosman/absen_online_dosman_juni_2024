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
          LAPORAN ABSENSI SISWA
          </h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
    <div class="container-xl">
      <div class="row">
        <div class="col-6">
          <div class="card">
            <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <select name="bulan" id="bulan" class="form-select">
                        <option value="">-- Pilih Bulan --</option>
                        @for ($i=1; $i<= 12; $i++)
                        <option value="{{ $i }}">{{ $namabulan[$i] }}</option>
                        @endfor
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-12">
                    <div class="form-group">
                      <select name="tahun" id="tahun" class="form-select">
                        <option value="">-- Pilih Tahun --</option>
                        @php
                            $tahunmulai =2023;
                            $tahunskrg = date('Y');
                        @endphp
                        @for ($tahun=$tahunmulai; $tahun<=$tahunskrg; $tahun++)
                            <option value="{{$tahun}}">{{ $tahun }}</option>
                        @endfor
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row mt-2">
                  <div class="col-12">
                    <div class="form-group">
                      <select name="kelas" id="kelas" class="form-select">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($kelas as $d)
                            <option value="{{$d->kode_kelas}}">{{$d->nama_kelas}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col" id="loadlaporansiswa">
        </div>
    </div>
</div>
@endsection

@push('myscript')
    <script>
    $(function () {

        function loadlaporansiswa(){
            var kelas = $("#kelas").val();
            var bulan = $("#bulan").val();
            var tahun = $("#tahun").val();
            $.ajax({
                type:'POST',
                url:'/getlaporansiswa',
                data:{
                    _token:"{{csrf_token()}}",
                    kelas: kelas,
                    bulan: bulan,
                    tahun: tahun
                },
                cache:false,
                success:function(respond){
                    $("#loadlaporansiswa").html(respond);
                }
            });
        }

        $("#kelas").change(function(e){
            loadlaporansiswa();
        });

        $(document).ready(function() {
        // Disable select tingkat kedua dan ketiga
        $("#tahun").prop("disabled", true);
        $("#kelas").prop("disabled", true);

        // Enable select tingkat kedua ketika select tingkat pertama diubah
        $("#bulan").change(function() {
            if ($(this).val() !== "") {
            $("#tahun").prop("disabled", false);
            } else {
            $("#tahun").prop("disabled", true);
            $("#kelas").prop("disabled", true); // Reset select tingkat ketiga
            }
        });

        // Enable select tingkat ketiga ketika select tingkat kedua diubah
        $("#tahun").change(function() {
            if ($(this).val() !== "") {
            $("#kelas").prop("disabled", false);
            } else {
            $("#kelas").prop("disabled", true);
            }
        });
        });


    });

    </script>
@endpush




















{{-- @push('myscript')
<script>
$(function(){
    $("#frmLaporan").submit(function(e){
        var bulan = $("#bulan").val();
        var tahun = $("#tahun").val();
        var nisn = $("#nisn").val();
        if( bulan==""){
            Swal.fire({
                    title: 'Peringatan!',
                    text: 'Bulan Harus Dipilih !',
                    icon: 'warning',
                    confirmButtonText: 'Ok',
                    }).then((result)=>{
                        $("#bulan").focus();
                    });
                    return false;
        } else if ( tahun ==""){
            Swal.fire({
                    title: 'Peringatan!',
                    text: 'Tahun Harus Dipilih !',
                    icon: 'warning',
                    confirmButtonText: 'Ok',
                    }).then((result)=>{
                        $("#tahun").focus();
                    });
                    return false;
        }else if ( nisn ==""){
            Swal.fire({
                    title: 'Peringatan!',
                    text: 'Nama Siswa Harus Dipilih !',
                    icon: 'warning',
                    confirmButtonText: 'Ok',
                    }).then((result)=>{
                        $("#nisn").focus();
                    });
            return false;
        }
    });
});

</script>
@endpush --}}
