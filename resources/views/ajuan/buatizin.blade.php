@extends('layouts.presensi')
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<style>
    .datepicker-modal{
        max-height: 460px !important;
    }
</style>
<!-- app header -->
<div class="appHeader text-light" style="background-color: #26a29a">
    <div class="left">
        <a href="javascript::" class="headerButton goBack">
        <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Form izin</div>
    <div class="right"></div>
</div>
<!-- appheader -->
@endsection

@section('content')
<div class="row" style="margin-top: 4rem">
    <div class="col">
        <form method="POST" action="/ajuan/storeizin" id="frmIzin">
            @csrf
        <div class="form-group">
            <input type="text" id="tgl_izin" name="tgl_izin" class="form-control datepicker" placeholder="Tanggal" autocomplete="off">
        </div>

        <div class="form-group">
            <select name="status" id="status" class="form-control">
            <option value="">Status</option>
            <option value="i">Izin</option>
            <option value="s">Sakit</option>
            <option value="d">Dispensasi</option>
            </select>
        </div>

        <div class="form-group">
            <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="Keterangan"></textarea>
        </div>
        <div class="form-group">
            <button class="btn btn-block">Kirim</button>
        </div>
        </form>
    </div>
</div>
@endsection

@push('myscript')
<script>
    var currYear = (new Date()).getFullYear();

$(document).ready(function() {
    $(".datepicker").datepicker({
    format: "yyyy-mm-dd"
    });

    $("#tgl_izin").change(function(e){
        var tgl_izin = $(this).val();
        $.ajax({
            type: 'POST',
            url:'/ajuan/cekpengajuanizin',
            data:{
                _token:"{{csrf_token()}}",
                tgl_izin: tgl_izin
            },
            cache:false ,
            success:function(respond){
                if(respond==1){
                    Swal.fire({
                    title: "Oops !!",
                    text: 'Anda Sudah Mengajukan Izin/Sakit pada Tanggal tersebut!',
                    icon: "warning"
                    }).then((result)=>{
                        $("#tgl_izin").val("");
                    });
                }
            }
        });
    });

    $("#frmIzin").submit(function(){
        var tgl_izin = $("#tgl_izin").val();
        var status = $("#status").val();
        var keterangan = $("#keterangan").val();
        if(tgl_izin==""){
            Swal.fire({
                    title: "Oops !!",
                    text: 'Tanggal Harus Diisi',
                    icon: "warning"
                    });
            return false;
        }else if(status=="") {
            Swal.fire({
                    title: "Oops !!",
                    text: 'Status Harus Diisi',
                    icon: "warning"
                    });
            return false;
        }else if(keterangan=="") {
            Swal.fire({
                    title: "Oops !!",
                    text: 'Keterangan Harus Diisi',
                    icon: "warning"
                    });
            return false;
        }
    });
});


</script>
@endpush
