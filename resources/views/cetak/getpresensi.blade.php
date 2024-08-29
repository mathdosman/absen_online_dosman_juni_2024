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
@if($d->status == "h" || $d->status == "m")
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
                <td>
                    @if($d->foto_in == Null)
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-pennant-2 text-danger"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 2a1 1 0 0 1 .993 .883l.007 .117v17h1a1 1 0 0 1 .117 1.993l-.117 .007h-4a1 1 0 0 1 -.117 -1.993l.117 -.007h1v-7.351l-8.406 -3.735c-.752 -.335 -.79 -1.365 -.113 -1.77l.113 -.058l8.406 -3.736v-.35a1 1 0 0 1 1 -1z" /></svg>@endif
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
 {{-- TOMBOL EDIT --}}
        <td>
            <a href="#" class="bg-success border text-light koreksipresensi" style="padding: 0.4px;" nisn="{{$d->nisn}}">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg>
            </a>
        </td>
{{-- TOMBOL EDIT --}}
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

            $(".koreksipresensi").click(function(e){
                var nisn = $(this).attr('nisn');
                var tanggal = "{{$tanggal}}";

                $.ajax({
                    type: 'POST',
                    url:'/koreksipresensi',
                    data: {
                        _token: "{{csrf_token() }}",
                        nisn: nisn,
                        tanggal: tanggal
                    },
                    cache: false ,
                    success:function(respond){
                        $("#loadkoreksipresensi").html(respond);
                    }
                });
                $("#modalkoreksipresensi").modal("show");
            });



    });
</script>

