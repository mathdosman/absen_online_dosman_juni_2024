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
</style>

</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4 landscape">
<?php
// function selisih($jam_masuk, $jam_keluar)
//         {
//             list($h, $m, $s) = explode(":", $jam_masuk);
//             $dtAwal = mktime($h, $m, $s, "1", "1", "1");
//             list($h, $m, $s) = explode(":", $jam_keluar);
//             $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
//             $dtSelisih = $dtAkhir - $dtAwal;
//             $totalmenit = $dtSelisih / 60;
//             $jam = explode(".", $totalmenit / 60);
//             $sisamenit = ($totalmenit / 60) - $jam[0];
//             $sisamenit2 = $sisamenit * 60;
//             $jml_jam = $jam[0];
//             return $jml_jam . ":" . round($sisamenit2);
//         }
// ?>
  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">
<table style="width: 100%">
    <tr>
        <td style="width: 30px">
            <img src="{{asset('assets/img/logodosman.png')}}" width="100" height="100" alt="">
        </td>
        <td style="text-align: center">
            <span id="title"><b> Rekap Absensi Siswa <br> Periode {{$namabulan[$bulan]}} {{$tahun}} </b>
            </span> <br>
                <span > <b> SMA Negeri 1 Gianyar</span> </b> <br>
                <span style="margin-top:2px">Jln. Ratna, Tegal Tugu Gianyar, Telp: (0361) 943034</span> <br>
                <small>Website:https//sman1-gianyar.sch.id, email:sman1.gianyar1963@gmail.com</small>
        </td>
    </tr>
</table>
<hr>
<div class="row">
    <div class="col" style="text-align: center">Rekap Laporan Absensi <br> KELAS {{$kode_kelas}} Bulan {{$bulan}} Tahun {{$tahun}} </div>
</div>
<table  class="tabelpresensi">
    <tr>
        <th rowspan="2">NISN</th>
        <th rowspan="2">Nama Siswa</th>
        <th colspan="31">Tanggal</th>
        <th rowspan="2">Total <br> Hadir</th>
        <th rowspan="2">Telat</th>
    </tr>
    <tr>
        <?php
        for($i=1; $i<=31;$i++){
            ?>
        <th>{{$i}}</th>
        <?php
        }
        ?>
    </tr>
    @foreach ($rekap as $d)
    <tr>
        <td>{{$d->nisn}}</td>
        <td style="text-align: left !important">{{$d->nama_siswa}}</td>
        <?php
        for($i=1; $i<=31;$i++){
            $tgl="tgl_".$i;
            ?>
            <td>{{$d->$tgl}}</td>
        <?php
        }
        ?>
        <td></td>
        <td></td>
    </tr>
    @endforeach


</table>
<table width="100%" style="margin-top: 80px" >
    <tr>
        <td style="text-align: left">
            <span style="margin-left: 850px;">Gianyar, {{date('d-m-Y')}}</span>
            <br>
            <br>
            <br>
            <br>
           <u style="margin-left: 850px"> I Putu Darma Putra, S.Pd </u> <br>
           <i style="margin-left: 850px"><b>Guru Piket</b></i>
        </td>
    </tr>
</table>

  </section>

</body>

</html>
