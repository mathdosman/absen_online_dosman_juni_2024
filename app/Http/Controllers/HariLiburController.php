<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class HariLiburController extends Controller
{
    public function index(){
        $lokasi = DB::table('lokasi')->orderBy('kode_lokasi')->get();
        $datalibur = DB::table('hari_libur')->orderBy('tgl_libur')->get();
        return view('libur.index',compact('lokasi','datalibur'));
    }

    public function storelibur(Request $request)
    {
        $tgl_libur = $request->tgl_libur;
        $kode_lokasi = $request->kode_lokasi;
        $keterangan = $request->keterangan;
        $bulan = date("m",strtotime($tgl_libur));
        $tahun = date("Y",strtotime($tgl_libur));
        $day = date("d",strtotime($tgl_libur));
        $kode_libur = "L".$tahun.$bulan.$day;

        try{
            $data = [
                'tgl_libur' => $tgl_libur,
                'kode_libur' => $kode_libur,
                'kode_lokasi' => $kode_lokasi,
                'keterangan' => $keterangan
            ];
                $simpan = DB::table('hari_libur')->insert($data);
                $delete_presensi = DB::table('presensi')->where('tgl_presensi',$tgl_libur)->delete();
                return Redirect::back()->with(['success'=>'Data Berhasil Disimpan']);
                } catch (\Exception $e){
                return Redirect::back()->with(['error'=>'Data Gagal Disimpan']);
            }
    }
    public  function deletelibur($kode_libur){
        $delete = DB::table('hari_libur')->where('kode_libur',$kode_libur)->delete();
        if($delete){
            return Redirect::back()->with(['success'=>'Data Berhasil Disimpan']);
        } else {
            return Redirect::back()->with(['error'=>'Data Berhasil Dihapus']);
        }
    }

}
