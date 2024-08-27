@extends('layouts.presensi')
@section('content')

<div class="section" id="user-section">
    <div id="user-detail">
        <div class="avatar">
            @if (!empty(Auth::guard('siswa')->user()->foto))
                @php
                    $path = Storage::url('uploads/profile/'.Auth::guard('siswa')->user()->foto);
                @endphp
                <img src="{{url($path)}}" alt="foto" class="imaged w64 fotoprofile">
                @else
                <img src="{{asset('assets/img/sample/avatar/avatar1.jpg')}}" alt="avatar" class="imaged w64 rounded">
            @endif
        </div>
        <div id="user-info">
            <h3 id="user-name">{{Auth::guard('siswa')->user()->nama_siswa}}</h3>
            <span id="user-role">{{Auth::guard('siswa')->user()->jabatan}}</span>
            <span id="user-role">{{Auth::guard('siswa')->user()->kode_kelas}} - </span>
            <span id="user-role">({{Auth::guard('siswa')->user()->kode_lokasi}})</span>
        </div>
    </div>
    <a href="/proseslogout">
        <img src="{{ asset('assets/img/logodosman.png') }}" alt="" class="imaged w32" style="position: absolute; top:7px; right:7px;">
    </a>
</div>

<div class="section mt-1" id="menu-section">
    <div class="card">
        <div class="card-body text-center">
            <div class="list-menu">
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <div class="card">
                            <div class="green" style="font-size: 40px;">
                                <span class="badge bg-danger" style="position: absolute; bottom:35px; right:30px; font-size:0.7rem; z-index:999">{{$hadir}}</span>
                                <ion-icon name="accessibility-sharp"></ion-icon>
                            </div>
                        </div>
                    </div>
                    <div class="menu-name">
                        <span class="text-center">Hadir</span>
                    </div>
                </div>
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <div class="card">
                            <div class="orange" style="font-size: 40px;">
                                <span class="badge bg-danger" style="position: absolute; bottom:35px; right:30px; font-size:0.7rem; z-index:999">{{$ajuanizin}}</span>
                                <ion-icon name="mail-open-sharp"></ion-icon>
                            </div>
                        </div>
                    </div>
                    <div class="menu-name">
                        <span class="text-center">Izin</span>
                    </div>
                </div>
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <div class="card">
                            <div class="warning" style="font-size: 40px;">
                                <span class="badge bg-danger" style="position: absolute; bottom:35px; right:30px; font-size:0.7rem; z-index:999">{{$ajuansakit}}</span>
                                <ion-icon name="medkit-sharp"></ion-icon>
                            </div>
                        </div>
                    </div>
                    <div class="menu-name">
                        <span class="text-center">Sakit</span>
                    </div>
                </div>
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <div class="card">
                            <div class="danger" style="font-size: 40px;">
                                <span class="badge bg-danger" style="position: absolute; bottom:35px; right:30px; font-size:0.7rem; z-index:999">{{$alpha}}</span>
                                <ion-icon name="thumbs-down-sharp"></ion-icon>
                            </div>
                        </div>
                    </div>
                    <div class="menu-name">
                        <span class="text-center">Alpha</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- DARI SINI TOMBOL --}}
<div class="section mt-2" id="presence-section">
    <div class="todaypresence">
        <div class="row justify-content-center">
            @if(empty($cek))
            <div class="col-6">
                <a href="/createpresensi" style="text-decoration: none">
                    <div class="card gradasigreen" style="height: 110px">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($data !== null)
                                    @php
                                        $path = Storage::url('uploads/absensi/'.$data->foto_in);
                                    @endphp
                                    <img src="{{url($path)}}" alt="image" class="imaged w64">
                                    @else
                                    <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail" style="margin-left:0.2rem">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span>{{$data!=null ? $data->jam_in : 'Belum Absen'}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                </div>
                <div class="col-6">
                    <div class="card gradasired" id="absenpulang" style="height: 110px">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($data !== null && $data->jam_out != null)
                                    @php
                                        $path = Storage::url('uploads/absensi/'.$data->foto_out);
                                    @endphp
                                    <img src="{{url($path)}}" alt="image" class="imaged w64">
                                    @else
                                    <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail" style="margin-left:0.2rem">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span><span style="font-size: 0.8rem">{{$data !== null ? $data->jam_out : "Belum Absen"}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
@else
            <div class="col-6">
                    <div class="card gradasigreen" id="absenmasuk" style="height: 110px" >
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($data !== null)
                                    @php
                                        $path = Storage::url('uploads/absensi/'.$data->foto_in);
                                    @endphp
                                    @if($data->foto_in == Null)
                                    <img src="{{asset('assets/img/sample/avatar/avatar2.jpg')}}" class="imaged w64" alt="xxxx">
                                    @else
                                    <img src="{{url($path)}}" alt="image" class="imaged w64">
                                    @endif
                                    @else
                                    <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail" style="margin-left:0.2rem">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span style="font-size: 0.8rem">{{$data !== null ? $data->jam_in : "Belum Absen"}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        @if(empty($data->jam_out))
                <div class="col-6">
                <a href="/createpresensi">
                    <div class="card gradasired" style="height: 110px">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($data !== null && $data->jam_out != null)
                                    @php
                                        $path = Storage::url('uploads/absensi/'.$data->foto_out);
                                    @endphp
                                    <img src="{{url($path)}}" alt="image" class="imaged w64">
                                    @else
                                    <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail" style="margin-left:0.2rem">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span style="font-size: 0.8rem">{{$data !== null ? $data->jam_out : "Belum Absen"}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @else
            <div class="col-6">
                    <div class="card gradasired" id="komplit">
                        <div class="card-body" style="height: 110px">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($data !== null && $data->jam_out != null)
                                    @php
                                        $path = Storage::url('uploads/absensi/'.$data->foto_out);
                                    @endphp
                                    <img src="{{url($path)}}" alt="image" class="imaged w64">
                                    @else
                                    <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail" style="margin-left:0.2rem"s>
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span style="font-size: 0.8rem">{{$data !== null ? $data->jam_out : "Belum Absen"}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            @endif
@endif
        </div>
    </div>

    <div class="presencetab mt-2">
        <div class="tab-pane fade show active" id="pilled" role="tabpanel">
            <ul class="nav nav-tabs style1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                        Bulan Ini
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                        Hari ini
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content mt-2" style="margin-bottom:100px;">
            <div class="tab-pane fade show active" id="home" role="tabpanel">
                <ul class="listview image-listview">
                    @if(empty($cek))
                    <li>
                        <div class="item">
                            <div class="icon-box bg-danger">
                                <ion-icon name="alert-sharp"></ion-icon>
                            </div>
                            <div class="in">
                                @php
                                $tgl_hariini = tgl_indo(date($hariini));
                                @endphp
                                <div>Hari ini, {{$tgl_hariini}}</div>
                                <span class="badge badge-danger p-1">Belum Absen</span>
                            </div>
                        </div>
                    </li>
                    @endif


                    @foreach ($historibulanini as $d)
                    <li>
                        @php
                        $tgl_indo = tgl_indo(date($d->tgl_presensi));
                        @endphp
                        <div class="item">
                            <div class="icon-box" style="background-color: rgb(212, 211, 211)">
                                @if ($d->status == "h")
                                <img src="{{asset('assets/img/sample/avatar/avatar1.jpg')}}" alt="avatar1" class="image">
                                @elseif($d->status == "i")
                                <ion-icon name="receipt" class="text-info"></ion-icon>
                                @elseif($d->status == "s")
                                <ion-icon name="medkit" class="text-warning"></ion-icon>
                                @elseif($d->status == "d")
                                <ion-icon name="medal" class="text-success"></ion-icon>
                                @endif
                            </div>
                            <div class="in">
                                <div>{{$tgl_indo}}</div>
                                @if($d->status == "h")
                                    <span class="badge {{$d->jam_in < "07:30" ? "badge-success" : "badge-danger" }} p-1">{{date("H:i",strtotime($d->jam_in))}}</span>
                                    @if($data !== null && $d->jam_out == null)
                                    <span class="badge badge-danger p-1">00:00</span>
                                    @else
                                    <span class="badge badge-warning p-1">{{date("H:i",strtotime($d->jam_out))}}</span>
                                    @endif
                                @elseif($d->status == "i")
                                <span class="bg-info p-1">Izin</span>
                                @elseif($d->status == "s")
                                <span class="bg-warning p-1">Sakit</span>
                                @elseif($d->status == "d")
                                <span class="bg-success p-1">Dispen</span>
                                @endif
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel">
                <ul class="listview image-listview">
                    @foreach ($leaderboard as $d)
                    <li>
                        <div class="item">
                            <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                            <div class="in">
                                <div>
                                    <b> {{ $d ->nama_siswa }}</b><br>
                                </div>
                                <span class="badge {{$d->jam_in < "07:30" ? "badge-success" : "badge-danger" }} p-1">{{date("H:i",strtotime($d->jam_in))}}</span>
                                @if($data !== null && $d->jam_out == null)
                                    <span class="badge badge-danger p-1">00:00</span>
                                    @else
                                    <span class="badge badge-warning p-1">{{date("H:i",strtotime($d->jam_out))}}</span>
                                    @endif
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('myscript')
    <script>
        $("#absenmasuk").click(function(e){
            Swal.fire({
            title: "Anda sudah melakukan absen Masuk",
            icon: "success"
            });
        });
        $("#absenpulang").click(function(e){
            Swal.fire({
            title: "Absen Masuk terlebih dahulu",
            icon: "error"
            });
        });
        $("#komplit").click(function(e){
            Swal.fire({
            title: "Anda Sudah Absen Masuk dan Pulang",
            icon: "success"
            });
        });
    </script>
@endpush
