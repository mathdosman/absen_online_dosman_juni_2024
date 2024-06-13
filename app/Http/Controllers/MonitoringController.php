<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    public function monitoring()
    {
        return view('cetak.monitoring');
    }

    public function getpresensi(Request $request)
    {
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensi')
        ->select('presensi.*','nama_siswa','nama_kelas')
        ->join('siswa','presensi.nisn','=','siswa.nisn')
        ->join('kelas','siswa.kode_kelas','=','kelas.kode_kelas')
        ->where('tgl_presensi',$tanggal)
        ->get();
        return view('cetak.getpresensi',compact('presensi'));
    }

    public function foto_in(Request $request)
    {
        $id = $request->id;
        $foto_inx = DB::table('presensi')->where('id',$id)->first();
        return view('cetak.foto_in',compact('foto_inx'));
    }
    public function foto_out(Request $request)
    {
        $id = $request->id;
        $foto_outx = DB::table('presensi')->where('id',$id)->first();
        return view('cetak.foto_out',compact('foto_outx'));
    }

    public function laporansiswa(){
        $namabulan =["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $kelas = DB::table('kelas')->orderBy('kode_kelas')->get();

        return view('cetak.laporansiswa',compact('namabulan','kelas'));
    }

    public function getlaporansiswa(Request $request){
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $kelas = $request->kelas;
        $cetak = DB::table('siswa')
        ->select('siswa.*')
        ->where('kode_kelas',$kelas)
        ->orderBy('kode_kelas')
        ->get();
        return view('cetak.getlaporansiswa', compact('cetak','bulan','tahun'));
    }

    public function rekap_siswa($nisn, Request $request){

        $bulan = $request -> bulan;
        $tahun = $request -> tahun;
        $namabulan =["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $siswa = DB::table('siswa')->where('nisn',$nisn)
        ->join('kelas','siswa.kode_kelas',"=",'kelas.kode_kelas')
        ->first();

        $presensi = DB::table('presensi')
        -> where('presensi.nisn',$nisn)
        -> whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
        -> whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
        ->orderBy('tgl_presensi')
        ->get();

        if(isset($_POST['exportexcel'])){
            $time = date("d-m-Y H:i:s");
            header("Content-type:application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=RekapKelas$time.xls");
            return view('presensi.cetaklaporanexcel', compact('bulan', 'tahun', 'namabulan','siswa','presensi'));
        }

    return view('cetak.cetaklaporansiswa',compact('siswa','namabulan','bulan','tahun','presensi'));
    }

    public function laporankelas(){
        $namabulan =["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $kelas = DB::table('kelas')->orderBy('kode_kelas')->get();

        return view('cetak.laporankelas',compact('namabulan','kelas'));
    }

    public function rekapkelas(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $kode_kelas = $request->kode_kelas;
        $namabulan =["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $rekap = DB::table('presensi')
        ->selectRaw('presensi.nisn, nama_siswa,
        MAX(IF(DAY(tgl_presensi)=1,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_1,
        MAX(IF(DAY(tgl_presensi)=2,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_2,
        MAX(IF(DAY(tgl_presensi)=3,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_3,
        MAX(IF(DAY(tgl_presensi)=4,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_4,
        MAX(IF(DAY(tgl_presensi)=5,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_5,
        MAX(IF(DAY(tgl_presensi)=6,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_6,
        MAX(IF(DAY(tgl_presensi)=7,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_7,
        MAX(IF(DAY(tgl_presensi)=8,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_8,
        MAX(IF(DAY(tgl_presensi)=9,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_9,
        MAX(IF(DAY(tgl_presensi)=10,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_10,
        MAX(IF(DAY(tgl_presensi)=11,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_11,
        MAX(IF(DAY(tgl_presensi)=12,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_12,
        MAX(IF(DAY(tgl_presensi)=13,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_13,
        MAX(IF(DAY(tgl_presensi)=14,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_14,
        MAX(IF(DAY(tgl_presensi)=15,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_15,
        MAX(IF(DAY(tgl_presensi)=16,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_16,
        MAX(IF(DAY(tgl_presensi)=17,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_17,
        MAX(IF(DAY(tgl_presensi)=18,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_18,
        MAX(IF(DAY(tgl_presensi)=19,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_19,
        MAX(IF(DAY(tgl_presensi)=20,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_20,
        MAX(IF(DAY(tgl_presensi)=21,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_21,
        MAX(IF(DAY(tgl_presensi)=22,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_22,
        MAX(IF(DAY(tgl_presensi)=23,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_23,
        MAX(IF(DAY(tgl_presensi)=24,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_24,
        MAX(IF(DAY(tgl_presensi)=25,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_25,
        MAX(IF(DAY(tgl_presensi)=26,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_26,
        MAX(IF(DAY(tgl_presensi)=27,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_27,
        MAX(IF(DAY(tgl_presensi)=28,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_28,
        MAX(IF(DAY(tgl_presensi)=29,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_29,
        MAX(IF(DAY(tgl_presensi)=30,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_30,
        MAX(IF(DAY(tgl_presensi)=31,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_31
        ')
        ->join('siswa','presensi.nisn','=','siswa.nisn')
        ->where('kode_kelas',$kode_kelas)
        ->whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
        ->groupByRaw('presensi.nisn,nama_siswa')
        -> get();

        if(isset($_POST['exportexcel'])){
            $time = date("d-M-Y H:i:s");
            //Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");
            //Mendefiniskikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition:attachment; filename=Rekap Absensi $time.xls");
        }
        return view('cetak.cetaklaporankelas',compact('namabulan','bulan','tahun','rekap','kode_kelas'));
    }

}
