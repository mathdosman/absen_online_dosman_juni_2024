<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class SiswaController extends Controller
{
    public function index(Request $request){

        $query = Siswa::query();
        $query -> select('siswa.*','nama_kelas');
        $query ->join('kelas','siswa.kode_kelas', '=', 'kelas.kode_kelas');
        $query -> orderBy('nama_siswa');
        if(!empty($request -> nama_siswa)){
            $query -> where('nama_siswa', 'like', '%'. $request ->nama_siswa.'%');
        }
        if(!empty($request -> kode_kelas)){
            $query -> where('siswa.kode_kelas', $request ->kode_kelas);
        }
        $siswa = $query -> paginate(50);

        $kelas=DB::table('kelas')->get();
        $lokasi = DB::table('lokasi')->orderBy('kode_lokasi')->get();
        return view('siswa.index', compact('siswa','kelas','lokasi'));
    }


    public function store(Request $request){
        $nisn = $request->nisn;
        $kode_kelas = $request->kode_kelas;
        $jabatan = $request->jabatan;
        $nama_siswa = $request->nama_siswa;
        $no_hp = $request->no_hp;
        $password = Hash::make('123456');
        $kode_lokasi = $request->kode_lokasi;
        if($request ->hasFile('foto')){
            $foto = $nisn.".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto=null;
        }

        try{
            $data = [
                'nisn' => $nisn,
                'kode_kelas' => $kode_kelas,
                'jabatan' => $jabatan,
                'nama_siswa' => $nama_siswa,
                'no_hp' => $no_hp,
                'kode_lokasi' => $kode_lokasi,
                'foto' => $foto,
                'password' => $password
            ];
            $simpan = DB::table('siswa')->insert($data);

            if ($simpan){
                if($request->hasFile('foto')){
                    $folderPath = "public/uploads/profile/";
                    $request -> file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success'=>'Data Berhasil Disimpan']);
            }
        } catch (\Exception $e){
            if($e->getCode()==23000){
                $message="(Data dengan NISN ".$nisn." sudah ada!)";
            } else {
                $message = "Hubungi TIM IT";
            }
            return Redirect::back()->with(['error'=>'Data Gagal Disimpan '.$message]);
        }
    }

    public function edit(Request $request)
    {
        $nisn = $request->nisn;
        $kelas=DB::table('kelas')->get();
        $siswa = DB::table('siswa')->where('nisn',$nisn)->first();
        $lokasi = DB::table('lokasi')->orderBy('kode_lokasi')->get();
        return view('siswa.edit',compact('kelas','siswa','lokasi'));
    }
    public function foto(Request $request)
    {
        $nisn = $request->nisn;
        $siswa = DB::table('siswa')->where('nisn',$nisn)->first();
        return view('siswa.foto',compact('siswa'));
    }

    public function update($nisn, Request $request)
    {
        $nisn = $request->nisn;
        $kode_kelas = $request->kode_kelas;
        $kode_lokasi = $request->kode_lokasi;
        $jabatan = $request->jabatan;
        $nama_siswa = $request-> nama_siswa;
        $no_hp = $request-> no_hp;
        $password = Hash::make('123456');
        $old_foto = $request->old_foto;
        if($request ->hasFile('foto')){
            $foto = $nisn.".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = $old_foto;
        }

        try{
            $data = [
                'kode_kelas' => $kode_kelas,
                'nama_siswa' => $nama_siswa,
                'no_hp' => $no_hp,
                'foto' => $foto,
                'kode_lokasi' => $kode_lokasi,
                'password' => $password
            ];
            $update = DB::table('siswa')->where('nisn', $nisn)->update($data);

            if ($update){
                if($request->hasFile('foto')){
                    $folderPath = "public/uploads/profile/";
                    $folderPathOld = "public/uploads/profile/".$old_foto;
                    Storage::delete($folderPathOld);
                    $request -> file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success'=>'Data Berhasil Disimpan']);
            }
        } catch (\Exception $e){
            return Redirect::back()->with(['error'=>'Data Gagal Disimpan']);
        }
    }

    public  function delete($nisn){
        $delete = DB::table('siswa')->where('nisn',$nisn)->delete();
        if($delete){
            return Redirect::back()->with(['success'=>'Data Berhasil Disimpan']);
        } else {
            return Redirect::back()->with(['error'=>'Data Berhasil Dihapus']);
        }
    }


}
