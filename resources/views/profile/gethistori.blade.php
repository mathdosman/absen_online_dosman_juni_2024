<div style="margin-bottom: 70px">
@if($histori->isEmpty())
<div class="alert alert-outline-warning">
    <p>Belum ada data</p>
</div>
@endif
@foreach ($histori as $d)
@if($d->status == "h")
<ul class="listview image-listview">
    <li>
        <div class="item">
            @php
                $path = Storage :: url('uploads/absensi/'.$d->foto_in);
            @endphp
        <img src="{{ url($path) }}" alt="image" class="image">
            <div class="in">
                <div>
                    <span class="text-success">Hadir</span> <br>
                    <b> {{ date("d-m-Y",strtotime($d->tgl_presensi)) }}</b><br>
                </div>
                <div style="position: absolute ; right:2px">
                    <span class="badge {{ $d->jam_in < "07:30" ? "bg-success": "bg-danger" }}"> {{date("H:i",strtotime($d->jam_in))}}
                    </span>
                    <span class="badge bg-primary">{{$d->jam_out !== null ? date("H:i",strtotime($d->jam_out)):"00:00"}}</span>
                </div>
            </div>
        </div>
    </li>
</ul>
@elseif($d->status == "s")
<ul class="listview image-listview">
    <li>
        <div class="item">

            <img src="{{ asset('assets/img/sakit.jpg') }}" alt="image" class="image">
            <div class="in">
                <div>
                    <span class="text-warning">Sakit</span> <br>
                    <b> {{ date("d-m-Y",strtotime($d->tgl_presensi)) }}</b><br>
                </div>
                {{$d->keterangan}}
            </div>
        </div>
    </li>
</ul>
@elseif($d->status == "i")
<ul class="listview image-listview">
    <li>
        <div class="item">

            <img src="{{ asset('assets/img/izin.jpeg') }}" alt="image" class="image">
            <div class="in">
                <div>
                    <span class="text-info"><b>Izin</b></span> <br>
                    <b> {{ date("d-m-Y",strtotime($d->tgl_presensi)) }}</b>
                </div>
                {{$d->keterangan}}
            </div>
        </div>
    </li>
</ul>
@elseif($d->status == "d")
<ul class="listview image-listview">
    <li>
        <div class="item">

            <img src="{{ asset('assets/img/dispen.png') }}" alt="image" class="image">
            <div class="in">
                <div>
                    <span class="text-success"><b>Dispensasi</b></span> <br>
                    <b> {{ date("d-m-Y",strtotime($d->tgl_presensi)) }}</b>
                </div>
                {{$d->keterangan}}
            </div>
        </div>
    </li>
</ul>
@endif
@endforeach
</div>

