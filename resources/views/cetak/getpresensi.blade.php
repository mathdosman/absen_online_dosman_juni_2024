@php
function selisih($jam_masuk, $jam_keluar)
        {
            list($h, $m, $s) = explode(":", $jam_masuk);
            $dtAwal = mktime($h, $m, $s, "1", "1", "1");
            list($h, $m, $s) = explode(":", $jam_keluar);
            $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
            $dtSelisih = $dtAkhir - $dtAwal;
            $totalmenit = $dtSelisih / 60;
            $jam = explode(".", $totalmenit / 60);
            $sisamenit = ($totalmenit / 60) - $jam[0];
            $sisamenit2 = $sisamenit * 60;
            $jml_jam = $jam[0];
            return $jml_jam . ":" . round($sisamenit2);
        }
@endphp

@foreach ($presensi as $d)
@if($d->status == "h")
@php
    $foto_in = Storage ::url('uploads/absensi/'.$d->foto_in);
    $foto_out = Storage ::url('uploads/absensi/'.$d->foto_out);
@endphp
<tr>
    <td>{{ $loop -> iteration }}</td>
    <td>{{ $d->nisn }}</td>
    <td class="text-start !important">{{ $d->nama_siswa }}</td>
    <td>{{ $d->kode_kelas }}</td>
    <td>{{$d->kode_lokasi}}</td>
    <td>
        @if($d->jam_in > $d->bel_sekolah)
        <span class="badge bg-danger text-light">{{date("H:i",strtotime($d->jam_in))}}</span>
        @else
        <span class="badge bg-success text-light">{{date("H:i",strtotime($d->jam_in))}}</span>
        @endif
    </td>
    <td>
    @if (empty($d->foto_in))
    <img src="{{asset('assets/img/sample/avatar/avatar2.jpg')}}" class="avatar" alt="xxxx">
    @else
    <a href="#" class="tampilkanfoto_in" id="{{$d->id}}">
        <img src="{{url($foto_in) }}" class="avatar w64" alt="foto_in">
    </a>
    @endif
</td>
<td>{!! $d->jam_out != null ? date("H:i",strtotime($d->jam_out)) : '<span class="badge bg-danger text-light">Belum <br> Absen</span>' !!}</td>
<td>
    @if (empty($d->foto_out))
    <img src="{{asset('assets/img/sample/avatar/avatar2.jpg')}}" class="avatar" alt="xxxx">
    @else
    <a href="#" class="tampilkanfoto_out" id="{{$d->id}}">
    <img src="{{url($foto_out) }}" class="avatar w64" alt="foto_out">
    </a>
    @endif
    </td>
    <td>
        @if($d->jam_in >= $d->bel_sekolah)
        @php
            $jamterlambat = selisih($d->bel_sekolah,$d->jam_in);
            $jamsaja = date("H",strtotime($jamterlambat))*1;
            $menitsaja = date("i",strtotime($jamterlambat))*1;
        @endphp
        <span class="badge bg-danger text-light">Terlambat <br> {{$jamsaja}} jam <br> {{$menitsaja}} menit</span>
        @else
        <span class="badge bg-success text-light">Tepat Waktu</span>
        @endif
    </td>
</tr>
@else
    <tr>
        @if($d->status == "i")
        <td>{{ $loop -> iteration }}</td>
        <td>{{ $d->nisn }}</td>
        <td class="text-start !important">{{ $d->nama_siswa }}</td>
        <td>{{ $d->kode_kelas }}</td>
        <td>{{$d->kode_lokasi}}</td>
        <td colspan="5"> <span class="badge bg-info text-light">Izin :</span> {{$d->keterangan}} <br> {{tgl_indo($d->tgl_izin_dari)}} s/d {{tgl_indo($d->tgl_izin_sampai)}}</td>
        @elseif($d->status == "s")
        <td>{{ $loop -> iteration }}</td>
        <td>{{ $d->nisn }}</td>
        <td class="text-start !important">{{ $d->nama_siswa }}</td>
        <td>{{ $d->kode_kelas }}</td>
        <td>{{$d->kode_lokasi}}</td>
        <td colspan="5"><span class="badge bg-warning text-light">Sakit :</span>{{$d->keterangan}} <br> {{tgl_indo($d->tgl_izin_dari)}} s/d {{tgl_indo($d->tgl_izin_sampai)}}</td>
        @elseif($d->status == "d")
        <td>{{ $loop -> iteration }}</td>
        <td>{{ $d->nisn }}</td>
        <td class="text-start !important">{{ $d->nama_siswa }}</td>
        <td>{{ $d->kode_kelas }}</td>
        <td>{{$d->kode_lokasi}}</td>
        <td colspan="5"><span class="badge bg-success text-light">Dispen :</span>{{$d->keterangan}} <br> {{tgl_indo($d->tgl_izin_dari)}} s/d {{tgl_indo($d->tgl_izin_sampai)}}</td>
        @elseif($d->status == "")
        <td>{{ $loop -> iteration }}</td>
        <td>{{ $d->nisn }}</td>
        <td class="text-start !important">{{ $d->nama_siswa }}</td>
        <td>{{ $d->kode_kelas }}</td>
        <td>{{$d->kode_lokasi}}</td>
        <td colspan="5" class="text-danger"><b>Belum Absen</b></td>
        @endif
    </tr>
@endif
@endforeach

<script>
    $(function(){
        $(".tampilkanfoto_in").click(function(e){
                var id = $(this).attr('id');
                $.ajax({
                    type: 'POST',
                    url:'/cetak/foto_in',
                    cache: false ,
                    data: {
                        _token: "{{csrf_token(); }}",
                        id: id
                    },
                    success:function(respond){
                        $("#loadfotoin").html(respond);
                    }
                });
                $("#modaltampilkanfoto_in").modal("show");
            });

        $(".tampilkanfoto_out").click(function(e){
                var id = $(this).attr('id');
                $.ajax({
                    type: 'POST',
                    url:'/cetak/foto_out',
                    cache: false ,
                    data: {
                        _token: "{{csrf_token(); }}",
                        id: id
                    },
                    success:function(respond){
                        $("#loadfoto_out").html(respond);
                    }
                });
                $("#modaltampilkanfoto_out").modal("show");
            });



    });
</script>

