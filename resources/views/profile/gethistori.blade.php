@if($histori->isEmpty())
<div class="alert alert-outline-warning">
    <p>Belum ada data</p>
</div>
@endif
@foreach ($histori as $d)
<ul class="listview image-listview">
    <li>
        <div class="item">
            @php
                $path = Storage :: url('uploads/absensi/'.$d->foto_in);
            @endphp
        <img src="{{ url($path) }}" alt="image" class="image">
            <div class="in">
                <div>
                    <b> {{ date("d-m-Y",strtotime($d->tgl_presensi)) }}</b><br>
                </div>
                <div style="position: absolute ; right:2px">
                    <span class="badge {{ $d->jam_in < "07:30" ? "bg-success": "bg-danger" }}"> {{date("H:i",strtotime($d->jam_in))}}
                    </span>
                    <span class="badge bg-primary">{{date("H:i",strtotime($d->jam_out))}}</span>
                </div>
            </div>
        </div>
    </li>
</ul>
@endforeach

