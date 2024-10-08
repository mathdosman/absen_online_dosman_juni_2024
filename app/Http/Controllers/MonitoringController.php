<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class MonitoringController extends Controller
{
    public function monitoring()
    {
        $siswa = DB::table('siswa')->get();
        $lokasi = DB::table('lokasi')->orderBy('kode_lokasi')->get();
        $kelas = DB::table('kelas')->orderBy('kode_kelas')->get();
        return view('cetak.monitoring',compact('lokasi','kelas','siswa'));
    }

    public function getpresensi(Request $request)
    {
        $kode_kelas = Auth::guard('user')->user()->kode_kelas;
        $kode_lokasi = Auth::guard('user')->user()->kode_lokasi;

        $tanggal = $request->tanggal;

        $query = Siswa::query();
        $query -> select('siswa.*');
        if(!empty($request ->nama_siswa)){
            $query -> where('nama_siswa', 'like', '%'. $request ->nama_siswa.'%');
        }
        $query->selectRaw('siswa.nisn,nama_siswa,siswa.kode_kelas,siswa.kode_lokasi, datapresensi.id, jam_in, jam_out, foto_in, foto_out, lokasi_in, lokasi_out, datapresensi.status, bel_sekolah, nama_jam, start_pulang, keterangan,  tgl_izin_dari, tgl_izin_sampai');
        $query->leftJoin(
            DB::raw("(
                SELECT
                presensi.nisn, presensi.id, jam_in, jam_out, foto_in, foto_out, lokasi_in, lokasi_out, presensi.status, bel_sekolah, nama_jam, start_pulang, keterangan, tgl_izin_dari, tgl_izin_sampai
                FROM presensi
                LEFT JOIN jam_sekolah ON presensi.kode_jam = jam_sekolah.kode_jam
                LEFT JOIN pengajuan_izin ON presensi.kode_izin = pengajuan_izin.kode_izin
                WHERE tgl_presensi = '$tanggal'
            ) datapresensi"),
            function($join){
                $join->on('siswa.nisn','=','datapresensi.nisn');
            });

            if(!empty($request->kode_lokasi)){
                $query->where('siswa.kode_lokasi',$request->kode_lokasi);
            }
            if(!empty($request->kode_kelas)){
                $query->where('siswa.kode_kelas',$request->kode_kelas);
            }

            $query -> orderBy('kode_kelas');

            $presensi = $query->get();


        // $presensi = DB::table('presensi')
        // ->select('presensi.*','nama_siswa','siswa.kode_kelas','start_datang','nama_jam','start_pulang','keterangan','tgl_izin_dari','tgl_izin_sampai')
        // ->leftJoin('jam_sekolah','presensi.kode_jam','=','jam_sekolah.kode_jam')
        // ->leftJoin('pengajuan_izin','presensi.kode_izin','=','pengajuan_izin.kode_izin')
        // ->join('siswa','presensi.nisn','=','siswa.nisn')
        // ->join('kelas','siswa.kode_kelas','=','kelas.kode_kelas')
        // ->where('tgl_presensi',$tanggal)
        // ->get();
        return view('cetak.getpresensi',compact('presensi','tanggal'));
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
        ->select('presensi.*','keterangan','jam_sekolah.*')
        ->leftJoin('jam_sekolah','presensi.kode_jam','=','jam_sekolah.kode_jam')
        ->leftJoin('pengajuan_izin','presensi.kode_izin','=','pengajuan_izin.kode_izin')
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
        $dari = $tahun."-0".$bulan."-01";
        $sampai = date("Y-m-t",strtotime($dari));
        $namabulan =["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];


        $datalibur = getlibur($dari, $sampai);
        $jumlahlibur = count($datalibur);

        $select_date = "";
        $field_date = "";
        $i = 1;
        while(strtotime($dari)<=strtotime($sampai)){
            $rangetanggal[] = $dari;

            $select_date .= "MAX(IF(tgl_presensi = '$dari',
                    CONCAT(
                    IFNULL(jam_in,'NA'),'|',
                    IFNULL(jam_out,'NA'),'|',
                    IFNULL(presensi.status, 'NA'), '|',
                    IFNULL(nama_jam, 'NA'), '|',
                    IFNULL(start_datang, 'NA'), '|',
                    IFNULL(start_pulang, 'NA'), '|',
                    IFNULL(presensi.kode_izin, 'NA'),'|',
                    IFNULL(keterangan, 'NA'), '|'
                    ),NULL)) as tgl_".$i.",";

            $field_date .= "tgl_".$i.",";
            $i++;
            $dari = date("Y-m-d", strtotime("+1 day", strtotime($dari)));
        }

        $jmlhari = count($rangetanggal);
        $lastrange = $jmlhari - 1;

        $sampai = $rangetanggal[$lastrange];

                $query = Siswa::query();
                $query->selectRaw("$field_date siswa.nisn, nama_siswa, jabatan, kode_kelas");

                $query->leftJoin(
                    DB::raw("(
                        SELECT
                        $select_date
                        presensi.nisn

                        FROM presensi
                        LEFT JOIN jam_sekolah ON presensi.kode_jam = jam_sekolah.kode_jam
                        LEFT JOIN pengajuan_izin ON presensi.kode_izin = pengajuan_izin.kode_izin
                        WHERE tgl_presensi BETWEEN '$rangetanggal[0]' AND '$sampai'
                        GROUP BY nisn
                    ) presensi"),
                    function($join){
                        $join->on('siswa.nisn','=','presensi.nisn');
                    }
                    );

            //AKHIR
            if(!empty($kode_kelas)){
                $query->where('kode_kelas', $kode_kelas);
            }
            $query->orderBy('nama_siswa');
            $rekap = $query -> get();
            // dd($rekap);

        if(isset($_POST['exportexcel'])){
            $time = date("d-M-Y H:i:s");
            //Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");
            //Mendefiniskikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition:attachment; filename=Rekap Absensi $time.xls");
        }

        $awalbulan =date("Y-0".$bulan."-01");
        $akhirbulan = date("Y-0".$bulan."-".$jmlhari);

        $walikelas = DB::table('wali')->where('kode_kelas',$kode_kelas)->first();
        $harilibur = DB::table('hari_libur')
        ->whereBetween('tgl_libur', [ $awalbulan, $akhirbulan])
        ->orderBy('tgl_libur')->get();

        // dd($harilibur);

        return view('cetak.cetaklaporankelas',compact('jumlahlibur','datalibur','namabulan','bulan','tahun','rekap','kode_kelas','rangetanggal','jmlhari','walikelas','harilibur'));
    }

    public function koreksipresensi(Request $request){
        $nisn = $request->nisn;
        $tanggal = $request->tanggal;
        $siswa = DB::table('siswa')->where('nisn',$nisn)->first();

        $jamsekolah = DB::table('jam_sekolah')->orderBy('kode_jam')->get();
        return view('cetak.koreksipresensi', compact('siswa','tanggal','jamsekolah'));
    }

    public function storekoreksipresensi(Request $request){
        $nisn = $request->nisn;
        $tanggal = $request->tanggal;
        $jam_in = $request->jam_in;
        $kode_jam = $request->kode_jam;

        try{
            DB::table('presensi')->insert([
                'nisn'=>$nisn,
                'tgl_presensi'=>$tanggal,
                'jam_in'=>$jam_in,
                'kode_jam' =>$kode_jam,
                'status' => "m"
            ]);
            return Redirect::back()->with(['success'=>'Data Berhasil di Simpan']);
        }catch(\Throwable $th){
            return Redirect::back()->with(['error'=>'Data Gagal di Simpan']);
        }
    }
}
