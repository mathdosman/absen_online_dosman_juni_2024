@extends('layouts.presensi')
@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">e-Presensi</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
<style>


    .webcam-capture,
    .webcam-capture video{
        display: inline-block;
        width: 100% !important;
        margin: auto;
        height: auto !important;
        border-radius: 15px;
    }
    #map { height: 200px; }

    .jam-digital-malasngoding {

        background-color: #27272783;
        position: absolute;
        top: 65px;
        right: 8px;
        z-index: 9999;
        width: 150px;
        border-radius: 10px;
        padding: 5px;
        }



    .jam-digital-malasngoding p {
        color: #fff;
        font-size: 16px;
        text-align: center;
        margin-top: 0;
        margin-bottom: 0;
        }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection
@section('content')

{{-- CAmera --}}
<div class="row" style="margin-top: 63px">
    <div class="col">
        <input type="hidden" id="lokasi">
        <div class="webcam-capture">
        </div>
    </div>
</div>

<div class="jam-digital-malasngoding">
    <p>{{date("d-m-Y")}}</p>
    <p id="jam"></p>
    <p>{{$jamsekolah->kode_jam}}</p>
    <p>Jadwal : {{date("H:i",strtotime($jamsekolah->start_datang))}} s/d {{date("H:i",strtotime($jamsekolah->end_datang))}}</p>
    <p>Pulang : {{date("H:i",strtotime($jamsekolah->start_pulang))}}</p>
</div>
<div class="container">
    <div class="row">
        <div class="col">
            @if ($cek > 0)
            <button id="takeabsen" class="btn  btn-danger  btn-block" ><ion-icon name="camera-outline"></ion-icon> ABSEN PULANG</button>
            @else
            <button id="takeabsen" class="btn  btn-primary  btn-block"><ion-icon name="camera-outline"></ion-icon> ABSEN MASUK</button>
            @endif
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col">
        <div id="map"></div>
    </div>
</div>
<section style="margin-bottom: 75px"></section>
<audio id="notifikasi_in">
    <source src="{{asset('assets/audio/notifikasi_in.mp3')}}" type="audio/mpeg">
</audio>
<audio id="notifikasi_out">
    <source src="{{asset('assets/audio/notifikasi_out.mp3')}}" type="audio/mpeg">
</audio>
@endsection

@push('myscript')
    <script>
        var notifikasi_in = document.getElementById('notifikasi_in');
        var notifikasi_out = document.getElementById('notifikasi_out');
        // var radius_sound = document.getElementById('radius_sound');
        Webcam.set({
            height: 480,
            width: 480,
            image_format: 'jpeg',
            jpeg_quality: 80,
            flip_horiz: true
        });
        Webcam.attach('.webcam-capture');

        var lokasi = document.getElementById('lokasi');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(position) { lokasi.value = position.coords.latitude +","+ position.coords.longitude;
        var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 16);

        var lokasi_sekolah = "{{$lok_sekolah->titik_lokasi}}";
        var lok = lokasi_sekolah.split(",");
        var lat_sekolah = lok[0];
        var long_sekolah = lok[1];
        var radius = "{{$lok_sekolah->radius}}"

        L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
            maxZoom: 20,
            subdomains:['mt0','mt1','mt2','mt3']
        }).addTo(map);

        // L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        //     maxZoom: 19,
        //     attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        // }).addTo(map);

        var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        var circle = L.circle([lat_sekolah,long_sekolah], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: radius
        }).addTo(map);
        }
        function errorCallback() {
        }

        $("#takeabsen").click(function(e){
        Webcam.snap(function(uri){
            image = uri;
        });
        var lokasi = $("#lokasi").val();
        $.ajax({
            type: 'POST',
            url:'/presensi/store',
            data:{
                _token:"{{ csrf_token()}}",
                image:image,
                lokasi:lokasi
            },
            cache:false,
            success: function(respond){
                var status = respond.split("|")
                if(status[0] == "success"){
                    if(status[2]=="in"){
                        notifikasi_in.play();
                    }if(status[2]=="out"){
                        notifikasi_out.play();
                    }
                    Swal.fire({
                    title: 'Berhasil!',
                    text: status[1],
                    icon: 'success',
                    confirmButtonText: 'Ok'
                    });
                    setTimeout("location.href='/dashboard'", 3000)
                return redirect('dashboard');
                }else{
                    if(status[2]=="radius" || status[0]=="error"){
                        Swal.fire({
                    title: 'Gagal Absen!',
                    text: status[1],
                    icon: 'error',
                    confirmButtonText: 'Ok'
                    });
                    }
                }
            }
        });
    });

    </script>
    <script type="text/javascript">
        window.onload = function() {
            jam();
        }
        function jam() {
            var e = document.getElementById('jam')
                , d = new Date()
                , h, m, s;
            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());

            e.innerHTML = h + ':' + m + ':' + s;

            setTimeout('jam()', 1000);
        }

        function set(e) {
            e = e < 10 ? '0' + e : e;
            return e;
        }
    </script>
@endpush
