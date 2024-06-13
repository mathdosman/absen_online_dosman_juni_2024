@extends('layouts.presensi')
@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Cek Lokasi</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection

@section('content')
<style>
    #map { height: 380px; }
</style>
<div class="container">
    <div class="row" style="margin-top: 70px">
        <div class="col">
            <div class="col">
                @php
                    $messagesuccess=Session::get('success');
                    $messageerror=Session::get('error');
                @endphp
                @if(Session::get('success'))
                    <div class="alert alert-success">
                        {{$messagesuccess}}
                    </div>
                @endif
                @if(Session::get('error'))
                    <div class="alert alert-warning" style="font-size: 1.5rem">
                        {{$messageerror}}
                    </div>
                @endif
            <form action="/createpresensi" method="POST">
                @csrf
                <div class="responsive mb-1" id="map"></div>
                <input type="text" value="" id="lokasi" class="form-control">

                        @if($cek > 0)
                        <button class="btn btn-danger btn-lg mt-1 btn-block kamera" style="margin-bottom: 70px"><ion-icon name="arrow-forward-circle-outline"></ion-icon>Lanjut Absen Pulang</button>
                        @else
                        <button class="btn btn-primary btn-lg mt-1 btn-block kamera" style="margin-bottom: 70px"><ion-icon name="arrow-forward-circle-outline"></ion-icon>Lanjut Absen Masuk</button>
                        @endif

            </form>
        </div>
    </div>
</div>

@endsection

{{-- @push('myscript')
<script>
    var lokasi = document.getElementById('lokasi');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }
        function successCallback(position)
        {
            lokasi.value = position.coords.latitude +","+ position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 16);
            var lokasiSekolah = "{{$lokasi_sekolah->titik_lokasi}}";
            var radius = "{{$lokasi_sekolah->radius}}"
            var lok = lokasiSekolah.split(",");
            var latSekolah = lok[0];
            var longSekolah = lok[1];
            L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        }).addTo(map);

        var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        var circle = L.circle([latSekolah,longSekolah], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: radius
        }).addTo(map);
        }
        function errorCallback() {
        }

        $(function(){
        $(".kamera").click(function(){
            echo("test");
                $.ajax({
                    type: 'POST',
                    url:'/cratepresensi',
                    cache: false ,
                    data: {
                        _token: "{{csrf_token(); }}",
                    },
                    success:function(respond){
                        $("#loadabsenform").html(respond);
                    }
                });
                $("#modal-kamera").modal("show");
            });
        });
</script>
@endpush --}}
