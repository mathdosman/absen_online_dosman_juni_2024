@extends('layouts.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">NOTIFIKASI</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection
@section('content')
<div class="container">
<div class="row" style="margin-top: 70px">
    <div class="col bg-warning rounded p-3">
        <h2 class="text-center"> Tidak ada jadwal absen hari ini atau anda mengajukan izin</h2>
    </div>
</div>
</div>
@endsection
