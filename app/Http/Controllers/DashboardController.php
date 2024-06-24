<?php

namespace App\Http\Controllers;

use view;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function gethari()
    {
        $hari = date("D");
        switch($hari){
            case 'Sun':
                $hari_ini = "Minggu";
                break;
            case 'Mon':
                $hari_ini = "Senin";
                break;
            case 'Tue':
                $hari_ini = "Selasa";
                break;
            case 'Wed':
                $hari_ini = "Rabu";
                break;
            case 'Thu':
                $hari_ini = "Kamis";
                break;
            case 'Fri':
                $hari_ini = "Jumat";
                break;
            case 'Sat':
                $hari_ini = "Sabtu";
                break;

            default:
            $hari_ini = "Tidak diketahui";
            break;
        }
        return $hari_ini;
    }

    public function index(){
        $awalbulan =date("Y-m-01");
        $hariini = date("Y-m-d");
        $bulanini = date("m")*1;
        $tahunini = date("Y");
        $nisn = Auth::guard('siswa')->user()->nisn;
        $cek = DB::table('presensi')->where('nisn',$nisn)->where('tgl_presensi', $hariini)->count();
        $data = DB::table('presensi')->where('nisn',$nisn)->where('tgl_presensi', $hariini)->first();
        $siswa = DB::table('siswa')->where('nisn',$nisn)->get();

        $historibulanini = DB::table('presensi')
        ->where('nisn',$nisn)
        ->whereBetween('tgl_presensi', [ $awalbulan, $hariini])
        ->orderBy('tgl_presensi','desc')
        ->get();


        // $rekappresensi = DB::table('presensi')
        // ->selectRaw('COUNT(nisn) as jmlhadir')
        // ->where('nisn',$nisn)
        // ->where('status',"h")
        // ->whereRaw('MONTH(tgl_presensi)="'.$bulanini.'"')
        // ->whereRaw('YEAR(tgl_presensi)="'.$tahunini.'"')
        // ->first();

        $leaderboard = DB::table('presensi')
        ->join('siswa','presensi.nisn','=','siswa.nisn')
        ->where('tgl_presensi', $hariini)
        ->orderBy('jam_in','desc')
        ->get();

        $jmlabsen = DB::table('presensi')
        ->where('nisn',$nisn)
        ->where('status',"h")
        ->whereBetween('tgl_presensi', [ $awalbulan, $hariini])
        ->count();

        $ajuansakit = DB::table('presensi')
        ->where('nisn',$nisn)
        ->where('status',"s")
        ->whereBetween('tgl_presensi', [ $awalbulan, $hariini])
        ->count();

        $ajuanizin = DB::table('presensi')
        ->where('nisn',$nisn)
        ->where('status',"i")
        ->whereBetween('tgl_presensi', [ $awalbulan, $hariini])
        ->count();

        $ajuandispen = DB::table('presensi')
        ->where('nisn',$nisn)
        ->where('status',"d")
        ->whereBetween('tgl_presensi', [ $awalbulan, $hariini])
        ->count();

        $hadir = $jmlabsen + $ajuandispen;

        // $jumHari = cal_days_in_month(CAL_GREGORIAN, 2, 1804);
        $now = date("d")*1;
        $alpha = $now - $ajuansakit - $ajuanizin - $hadir;

        return view('dashboard.dashboard',compact('cek','data','siswa','historibulanini','hariini','leaderboard','ajuansakit','ajuanizin','alpha','hadir'));
    }


    public function dashboardadmin(){
        $awalbulan =date("Y-m-01");
        $hariini = date("Y-m-d");
        $bulanini = date("m")*1;
        $tahunini = date("Y");

        $rekappresensi = DB::table('presensi')
        ->selectRaw('SUM(IF(jam_in > "07:30",1,0)) as jmlterlambat , SUM(IF(jam_in <= "07:30",1,0)) as tepatwaktu')
        -> where('tgl_presensi', $hariini)
        -> first();

        $jmlsiswa = DB::table('siswa')->where('jabatan',"siswa")->count();

        $jmlhadirhariini = DB::table('presensi')
        ->where('tgl_presensi',$hariini)
        ->count();

        $sakitperbulan = DB::table('pengajuan_izin')
        ->where('status',"s")
        ->whereBetween('tgl_izin_dari', [ $awalbulan, $hariini])
        ->where('status_approved',"1")
        ->count();

        $sakitperhari = DB::table('pengajuan_izin')
        ->where('status',"s")
        ->where('tgl_izin_dari', $hariini)
        ->where('status_approved',"1")
        ->count();

        $izinperbulan = DB::table('pengajuan_izin')
        ->where('status',"i")
        ->whereBetween('tgl_izin_dari', [ $awalbulan, $hariini])
        ->where('status_approved',"1")
        ->count();

        $izinperhari = DB::table('pengajuan_izin')
        ->where('status',"i")
        ->where('tgl_izin_dari', $hariini)
        ->where('status_approved',"1")
        ->count();

        $dispenperbulan = DB::table('pengajuan_izin')
        ->where('status',"d")
        ->whereBetween('tgl_izin_dari', [ $awalbulan, $hariini])
        ->where('status_approved',"1")
        ->count();

        $dispenperhari = DB::table('pengajuan_izin')
        ->where('status',"d")
        ->where('tgl_izin_dari', $hariini)
        ->where('status_approved',"1")
        ->count();

        $alpha = $jmlsiswa-$jmlhadirhariini - $sakitperhari - $izinperhari - $dispenperhari;

        // $jumHari = cal_days_in_month(CAL_GREGORIAN, 2, 1804);
        $now = date("d")*1;
        // $alpha = $now - $ajuansakit - $ajuanizin - $hadir;

        $namabulan =["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $bulanini = date('m')*1;
        $tahun = date('Y');
        $namahari = $this ->gethari();

        return view('dashboard.dashboardadmin',compact('jmlhadirhariini','jmlsiswa','sakitperbulan','sakitperhari','izinperbulan', 'izinperhari','dispenperbulan','dispenperhari','rekappresensi','alpha','namabulan','bulanini','tahun','namahari'));
    }
}
