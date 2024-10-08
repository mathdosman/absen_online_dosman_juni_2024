<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>A4 - Kelas {{$kode_kelas}}</title>
  <link rel="icon" type="image/png" href="{{asset('assets/img/favicondosman.png')}}" sizes="32x32">

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>@page { size: A4 }
#title{
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    font-size: 18px;
    font-weight: bold;
  }
  .tabeldatasiswa {
    margin-top:40px;
  }
  .tabelpresensi{
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}
.tabelpresensi  tr th{
      border:1px solid #0c0c0c;
      text-align: center;
    paddings: 8px;
    background-color: #d6d3d3;
    font-size: 10px;
  }
.tabelpresensi  tr td{
    border:1px solid #0c0c0c;
    paddings: 5px;
    font-size: 12px;
    text-align: center;
  }
  .avatar{
    width: 40px;
    height: 45px;
  }

  body.A4.landscape .sheet{
    width: 297mm !important;
    height: auto !important;
  }
  @media print {
  @page {
    size: A4 landscape;
    margin-top: 0.10in;
    margin-bottom: 0.75in;
    margin-left: 0.25in;
    margin-right: 0.25in;
  }
}

</style>
<style>
    .terlambat-tidak_absen_pulang {
        display: inline-block;
        width: 18px;
        height: 18px;
        border-radius: 50%; /* Membuat bentuk lingkaran */
        background-color: red; /* Warna latar belakang hijau */
        text-align: center;
        line-height: 18px; /* Menyesuaikan posisi vertikal teks */
        color:white; /* Warna teks (putih agar terlihat jelas di latar hijau) */
        }
</style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4 landscape">

  <section class="sheet padding-10mm">
<table style="width: 100%">
    <tr>
        <td style="width: 30px">
            <img src="{{asset('assets/img/logodosman.png')}}" width="100" height="100" alt="">
        </td>
        <td style="text-align: center">
            <span id="title"><b> Rekap Absensi Siswa </b>
            </span> <br>
                <span > <b> SMA Negeri 1 Gianyar</span> </b> <br>
                <span style="margin-top:2px">Jln. Ratna, Tegal Tugu Gianyar, Telp: (0361) 943034</span> <br>
                <small>Website:https//sman1-gianyar.sch.id, email:sman1.gianyar1963@gmail.com</small>
        </td>
    </tr>
</table>
<hr>
<div class="row">
    <div class="col" style="text-align: center">Rekap Laporan Absensi <br> Kelas {{$kode_kelas}} Bulan {{$namabulan[$bulan]}} Tahun {{$tahun}} </div>
</div>
<table  class="tabelpresensi">
    <tr>
        <th rowspan="2">No</th>
        <th rowspan="2">NISN</th>
        <th rowspan="2">Nama Siswa</th>
        <th colspan="{{$jmlhari}}">Tanggal</th>
        <th rowspan="2">Total <br> Hadir</th>
        <th rowspan="2">s</th>
        <th rowspan="2">i</th>
        <th rowspan="2">a</th>
    </tr>
    <tr>
       @foreach ($rangetanggal as $d)
            @if ($d != null)
                <th>{{date('d',strtotime($d))}}</th>
            @endif
        {{-- {{dd($rangetanggal)}} --}}
       @endforeach
    </tr>
    @foreach ($rekap as $r)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$r->nisn}}</td>
        <td style="text-align: left">{{$r->nama_siswa}}</td>
        <?php
                    $jml_hadir = 0;
                    $jml_izin = 0;
                    $jml_sakit = 0;
                    $jml_alpha = 0;
                    $color = "";
                    for($i=1; $i<=$jmlhari ; $i++){
                        $tgl = "tgl_".$i;
                        $tgl_presensi = $rangetanggal[$i-1];
                        $search_items = [
                            'tgl_libur' => $tgl_presensi ];
                        $ceklibur = cekharilibur($datalibur, $search_items);
                        $datapresensi = explode("|",$r->$tgl);
                        if ($r->$tgl !== NULL){
                            $status = $datapresensi[2];
                            $jampulang = $datapresensi[1];
                            $jamdatang = $datapresensi[0];
                        } else {
                            $status = "";
                        }
                        if($status == "h"){
                            $jml_hadir += 1;
                            $color = "";
                        }
                        if($status == "i"){
                            $jml_izin += 1;
                            $color = "";
                        }
                        if($status == "s"){
                            $jml_sakit += 1;
                            $color = "";
                        }
                        if($status == "d"){
                            $jml_hadir += 1;
                            // $color = "";
                        }
                        if(empty($status)){
                            $jml_alpha += 1;
                            $color = "";
                        }
                        if(!empty($ceklibur)){
                            $color = "red";
                        }
                ?>
                <td style = "background-color: {{$color}}">

                    @if($status=="h")
                        @if($jamdatang > "07:30:00")
                            @if($jampulang == "NA")
                            <span><ion-icon style="color:red" name="alert-circle-outline"></ion-icon></span>
                            {{-- <span class="terlambat-tidak_absen_pulang">✔</span> --}}
                            @else
                            <span style="color: red ;">✔</span>
                            @endif
                        @else
                            @if($jampulang == "NA")
                            <span style="color: rgb(13, 241, 13);">✔</span>
                            @else
                            <span>✔</span>
                            @endif
                        @endif
                    @elseif($status == "m")
                        @if($jampulang == "NA")
                            <span><ion-icon style="color: rgb(219, 53, 11)" name="flag"></ion-icon></span>
                        @else
                            <span><ion-icon style="color: rgb(0, 26, 255)" name="flag"></ion-icon></span>
                        @endif
                    @else
                        @if($ceklibur !== null)
                        {{-- <span><ion-icon name="storefront"></ion-icon></span> --}}
                        @endif
                        {{$status}}
                    @endif
                </td>
                <?php
                    }
                ?>
            <td>{{ !empty($jml_hadir) ? $jml_hadir : 0}}</td>
            <td>{{ !empty($jml_sakit) ? $jml_sakit : 0}}</td>
            <td>{{ !empty($jml_izin) ? $jml_izin : 0}}</td>
            <td>{{ !empty($jml_alpha) ? $jml_alpha - $jumlahlibur : 0}}</td>
    </tr>
    @endforeach


</table>
<table width="100%" style="margin-top: 40px" >
    <tr>
        <td style="text-align: left">
            <span style="margin-left: 650px;">Gianyar, {{date('d-m-Y')}}</span>
            <span style="margin-left: 650px;">Wali Kelas</span>
            <br>
            <br>
            <br>
            <br>
           <u style="margin-left: 650px">{{$walikelas->nama_wali}} </u> <br>
           <i style="margin-left: 650px"><b>NIP. {{$walikelas->nip}}</b></i>
        </td>
    </tr>
</table>

        <table class="table" style="margin-top: 10px; border-style: dotted; padding: 3px">
            <tr>
                <td>✔</span></td>
                <td>: Absen Lengkap</td>
            </tr>
            <tr>
                <td><span style="color: rgb(13, 241, 13);">✔</span></td>
                <td>: Tidak Absen Pulang</td>
            </tr>
            <tr>
                <td><span style="color: red ;">✔</span></td>
                <td>: Datang Terlambat</td>
            </tr>
            <tr>
                <td><span><ion-icon style="color:red" name="alert-circle-outline"></ion-icon></span></td>
                <td>: Terlambat dan Tidak Absen Pulang</td>
            </tr>
            <tr>
                <td><span><ion-icon style="color: rgb(219, 53, 11)" name="flag"></ion-icon></span></td>
                <td>: Presensi <b>Admin</b> dan tidak absen Pulang</td>
            </tr>
            <tr>
                <td><span><ion-icon style="color: rgb(0, 26, 255)" name="flag"></ion-icon></span></td>
                <td>: Presensi <b>Admin</b> Lengkap</td>
            </tr>
            @foreach ($harilibur as $d)
                <tr>
                    <td style="color: red">{{tgl_indo($d->tgl_libur)}}</td>
                    <td style="color: red"> : {{$d->keterangan}}</td>
                </tr>
            @endforeach
        </table>




  </section>

</body>

</html>
