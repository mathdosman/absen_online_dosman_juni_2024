<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KelasController extends Controller
{
    public function index(Request $request){
        // $kelas = DB::table('kelas')->orderBy('kode_kelas')->get();
        $nama_kelas = $request->nama_kelas;
        $query = Kelas::query();
        $query -> select('*');
        $query -> orderBy('kode_kelas');
        if(!empty($nama_kelas)){
            $query->where('nama_kelas','like','%'.$nama_kelas.'%');
        }
        $kelas = $query -> get();
        $kelas = $query -> paginate(20);
        return  view('kelas.index',compact('kelas'));
    }


    public function store(Request $request){
        $kode_kelas = $request -> kode_kelas;
        $nama_kelas = $request -> nama_kelas;
        $data = [
            'kode_kelas' => $kode_kelas,
            'nama_kelas' => $kode_kelas
        ];
        $cek = DB::table('kelas')->where('kode_kelas',$kode_kelas)->count();
        if($cek > 0){
            return Redirect::back() ->with(['error'=>'Data dengan Kode Kelas '.$kode_kelas.' sudah ada!']);
        }
        $simpan = DB::table('kelas')-> insert($data);
        if($simpan){
            return Redirect::back() ->with(['success'=>'Data Berhasil Disimpan']);
        } else {
            return Redirect::back() ->with(['warning'=>'Data Gagal Disimpan']);
        }
    }

    public function edit(Request $request)
    {
        $kode_kelas = $request -> kode_kelas;
        $kelas = DB::table('kelas')->where('kode_kelas',$kode_kelas)->first();
        return view('kelas.editkelas',compact('kelas'));
    }

    public function update($kode_kelas, Request $request)
    {
        $nama_kelas = $request -> nama_kelas;
        $data =[
            'nama_kelas' => $nama_kelas,
        ];
        $update = DB::table('kelas')->where('kode_kelas', $kode_kelas)->update($data);
        if($update){
            return Redirect::back() ->with(['success'=>'Data Berhasil Disimpan']);
        } else {
            return Redirect::back() ->with(['warning'=>'Data Gagal Disimpan']);
        }

    }

    public function delete($kode_kelas){
        $delete = DB::table('kelas')->where('kode_kelas',$kode_kelas)->delete();
        if($delete){
            return Redirect::back()->with(['success'=>'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['warning'=>'Data Berhasil Dihapus']);
        }
    }
}
