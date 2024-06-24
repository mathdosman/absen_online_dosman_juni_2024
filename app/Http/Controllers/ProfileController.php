<?php

namespace App\Http\Controllers;

use view;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    public function editprofile(){
        $nisn = Auth::guard('siswa')->user()->nisn;
        $datasiswa = DB::table('siswa')->where('nisn', $nisn)->first();
        return view('profile.editprofile', compact('datasiswa'));
    }

    public function updateprofile(Request $request){
        $nisn = Auth::guard('siswa')->user()->nisn;
        $nama_siswa = $request->nama_siswa;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $datasiswa = DB::table('siswa')->where('nisn', $nisn)->first();
        $request->validate([
            'foto'=> 'image|mimes:png,jpg|max:500',
        ]);


        if($request ->hasFile('foto')){
            $foto = $nisn.".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto=$datasiswa->foto;
        }

        if(empty($request -> password)){
            $data = [
                'nama_siswa' => $nama_siswa,
                'no_hp' => $no_hp,
                'foto' => $foto
            ];
        }else{
            $data = [
                'nama_siswa' => $nama_siswa,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $foto
            ];
        }

        $update = DB::table('siswa')->where('nisn', $nisn)->update($data);
        if($update){
            if($request->hasFile('foto')){
                $folderPath = "public/uploads/profile/";
                $request -> file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
        }else{
            return Redirect::back()->with(['error'=>'Data Gagal di Diupdate']);
        }
    }

    public function histori()
    {
        $namabulan =["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        return view('profile.histori',compact('namabulan'));
    }

    public function gethistori(Request $request){
        $bulan = $request -> bulan;
        $tahun = $request -> tahun;
        $nisn = Auth::guard('siswa')->user()->nisn;

        $histori = DB::table('presensi')
        ->select('presensi.*','keterangan')
        -> leftJoin('pengajuan_izin','pengajuan_izin.kode_izin','=','presensi.kode_izin')
        -> whereRaw('MONTH(tgl_presensi)="'.$bulan.'"')
        -> whereRaw('YEAR(tgl_presensi)="'.$tahun.'"')
        ->where('presensi.nisn',$nisn)
        ->orderBy('tgl_presensi','desc')
        ->get();

        return view('profile.gethistori', compact('histori'));
    }

}
