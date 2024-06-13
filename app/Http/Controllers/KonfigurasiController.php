<?php

namespace App\Http\Controllers;
use Exception;
use App\Models\Setjamkelas;
use Illuminate\Http\Request;
use App\Models\Setjamsekolah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiController extends Controller
{
    public function lokasi(){
            $lokasi = DB::table('lokasi')->orderBy('kode_lokasi')->get();
        return view ('konfigurasi.lokasi',compact('lokasi'));
    }

    public function store(Request $request){
        $kode_lokasi = $request->kode_lokasi;
        $nama_lokasi = $request->nama_lokasi;
        $titik_lokasi = $request->titik_lokasi;
        $radius = $request->radius;

        try {
            $data = [
                'kode_lokasi' => $kode_lokasi,
                'nama_lokasi' => $nama_lokasi,
                'titik_lokasi' => $titik_lokasi,
                'radius' => $radius
            ];
            DB::table('lokasi')->insert($data);
            return Redirect::back()->with(['success'=>'Data Berhasil Disimpan']);
        } catch (Exception $e) {
            return Redirect::back()->with(['error'=>'Data Gagal Disimpan']);
        }
    }

    public function edit(Request $request){
        $kode_lokasi = $request->kode_lokasi;
        $nama_lokasi = $request->nama_lokasi;
        $titik_lokasi = $request->titik_lokasi;
        $radius = $request->radius;

        $lokasi = DB::table('lokasi')->where('kode_lokasi', $kode_lokasi)->first();
        return view('konfigurasi.editlokasi',compact('lokasi'));
    }

    public function update(Request $request)
    {
        $kode_lokasi = $request->kode_lokasi;
        $nama_lokasi = $request->nama_lokasi;
        $titik_lokasi = $request->titik_lokasi;
        $radius = $request->radius;

        try {
            $data =[
                'nama_lokasi' => $nama_lokasi,
                'titik_lokasi' => $titik_lokasi,
                'radius' => $radius,
            ];
            $update = DB::table('lokasi')->where('kode_lokasi', $kode_lokasi)->update($data);
            return Redirect::back()->with(['success'=>'Data Berhasil Di Update']);
        } catch (Exception $e) {
            return Redirect::back()->with(['error'=>'Data Gagal Di Update']);
        }
    }

    public function delete($kode_lokasi){
        $delete = DB::table('lokasi')->where('kode_lokasi',$kode_lokasi)->delete();
        if($delete){
            return Redirect::back()->with(['success'=>'Data Berhasil di Hapus']);
        } else {
            return Redirect::back()->with(['error'=>'Data Gagal di Hapus']);
        }
    }



        // SETTING JAM
        public  function jamsekolah(){
            $jam_sekolah = DB:: table('jam_sekolah')->orderBy('kode_jam')->get();
            return view('konfigurasi.jamsekolah',compact('jam_sekolah'));
        }
        public  function storejamsekolah(Request $request){
            $kode_jam = $request->kode_jam;
            $nama_jam = $request->nama_jam;
            $start_datang = $request->start_datang;
            $bel_sekolah = $request->bel_sekolah;
            $end_datang = $request->end_datang;
            $start_pulang = $request-> start_pulang;
            try{
                $data =[
                    'kode_jam' => $kode_jam,
                    'nama_jam' => $nama_jam,
                    'start_datang' => $start_datang,
                    'bel_sekolah' => $bel_sekolah,
                    'end_datang' => $end_datang,
                    'start_pulang' => $start_pulang
                ];
                DB::table('jam_sekolah')->insert($data);
                return Redirect ::back()->with(['success'=>'Data Berhasil Disimpan']);
                } catch (\Exception $e){
                return Redirect ::back()->with(['error'=>'Data Gagal Disimpan']);
                }
        }

        public function editjamsekolah(Request $request){
            $kode_jam = $request->kode_jam;
            $kodejs=DB::table('jam_sekolah')->where('kode_jam', $kode_jam)->first();
            return view('konfigurasi.editjamsekolah', compact('kodejs'));
        }

        public function updatejs(Request $request){
            $kode_jam = $request->kode_jam;
            $nama_jam = $request->nama_jam;
            $start_datang = $request->start_datang;
            $bel_sekolah = $request->bel_sekolah;
            $end_datang = $request->end_datang;
            $start_pulang = $request->start_pulang;
            try{
                $data =[
                    'nama_jam' => $nama_jam,
                    'start_datang' => $start_datang,
                    'bel_sekolah' => $bel_sekolah,
                    'end_datang' => $end_datang,
                    'start_pulang' => $start_pulang,
                ];
                DB::table('jam_sekolah')
                ->where('kode_jam', $kode_jam)
                ->update($data);
                return Redirect ::back()->with(['success'=>'Data Berhasil Disimpan']);
            } catch (\Exception $e){
            return Redirect ::back()->with(['error'=>'Data Gagal Disimpan']);
            }
        }

        public function deletejamsekolah($kode_jam){
            $hapus = DB::table('jam_sekolah')->where('kode_jam',$kode_jam)->delete();
            if($hapus){
                return Redirect::back()->with(['success'=>'Data Berhasil Dihapus']);
            } else {
                return Redirect::back()->with(['error'=>'Data Gagal Dihapus']);
            }
        }

        public function setjamsekolah($nisn){
            $siswa =DB::table('siswa')->where('nisn',$nisn)->first();
            $jamsekolah = DB::table('jam_sekolah')->orderBy('nama_jam')->get();
            $cekjamsekolah =DB::table('konfigurasi_jam')->where('nisn',$nisn)->count();
            if($cekjamsekolah > 0){
                $setjamsekolah=DB::table('konfigurasi_jam')->where('nisn', $nisn)->get();
                return view('konfigurasi.editsetjamsekolahpersiswa',compact('siswa','jamsekolah','setjamsekolah'));
            }else{
                return view('konfigurasi.setjamsekolahpersiswa',compact('siswa','jamsekolah'));
                }
        }

        public function storesetjamsekolah(Request $request){
            $nisn= $request->nisn;
            $hari = $request->hari;
            $kode_jam = $request->kode_jam;

            for($i=0; $i<count($hari); $i++){
                $data[]=[
                    'nisn' => $nisn,
                    'hari' => $hari[$i],
                    'kode_jam' => $kode_jam[$i]
                ];
            }
            try{
                Setjamsekolah::insert($data);
                return redirect('/siswa')->with(['success'=>'Jam Sekolah Berhasil Diseting !']);
            } catch(\Exception $e){
                return redirect('/siswa')->with(['error'=>'Jam Sekolah Gagal Diseting !']);
            }
        }

        public function updatesetjamsekolah(Request $request){
            $nisn= $request->nisn;
            $hari = $request->hari;
            $kode_jam = $request->kode_jam;

            for($i=0; $i<count($hari); $i++){
                $data[]=[
                    'nisn' => $nisn,
                    'hari' => $hari[$i],
                    'kode_jam' => $kode_jam[$i]
                ];
            }
            DB::beginTransaction();
            try{
                DB::table('konfigurasi_jam')->where('nisn', $nisn)->delete();
                Setjamsekolah::insert($data);
                DB::commit();
                return redirect('/siswa')->with(['success'=>'Jam Sekolah Berhasil Diseting !']);
            } catch(\Exception $e){
                DB::rollBack();
                return redirect('/siswa')->with(['error'=>'Jam Sekolah Gagal Diseting !']);
            }
        }

        public function jamkelas(){
            $jamkelas = DB::table('konfigurasi_js_kelas')
            ->join('lokasi','konfigurasi_js_kelas.kode_lokasi','=','lokasi.kode_lokasi')
            ->join('kelas','konfigurasi_js_kelas.kode_kelas','=','kelas.kode_kelas')
            ->get();
            return view ('konfigurasi.jamkelas',compact('jamkelas'));
        }

        public function createjamkelas(){
            $jamsekolah = DB::table('jam_sekolah')->orderBy('nama_jam')->get();
            $lokasi = DB::table('lokasi')->get();
            $kelas =DB::table('kelas')->get();
            return view('konfigurasi.createjamkelas',compact('jamsekolah','lokasi','kelas'));
        }


        public function storejamkelas(Request $request){
            $kode_lokasi = $request ->kode_lokasi;
            $kode_kelas = $request ->kode_kelas;
            $hari = $request -> hari;
            $kode_jam = $request ->kode_jam;
            $kode_js_kelas = "K".$kode_lokasi.$kode_kelas;

            DB::beginTransaction();
            try{
                //menyimpan data ke tabel konfigurasi_js_kelas
                DB::table('konfigurasi_js_kelas')->insert([
                    'kode_js_kelas'=> $kode_js_kelas,
                    'kode_lokasi' => $kode_lokasi,
                    'kode_kelas' => $kode_kelas
                ]);

                for($i=0; $i<count($hari); $i++){
                    $data[]=[
                        'kode_js_kelas' => $kode_js_kelas,
                        'hari' => $hari[$i],
                        'kode_jam' => $kode_jam[$i]
                    ];
                }
                Setjamkelas::insert($data);
                DB::commit();
                return redirect('/konfigurasi/jamkelas')->with(['success'=>'Data Berhasil Disimpan !']);
            }catch(\Exception $e){
                DB::rollBack();
                return redirect('/konfigurasi/jamkelas')->with(['warning'=>'Data Gagal Disimpan !']);
            }

        }

        public function editjamkelas($kode_js_kelas){

            $jamsekolah =DB::table('jam_sekolah')->orderBy('nama_jam')->get();
            $lokasi = DB::table('lokasi')->get();
            $kelas = DB::table('kelas')->get();

            $jamkelas = DB::table('konfigurasi_js_kelas')
            ->where('kode_js_kelas', $kode_js_kelas)->first();

            $jamkelas_detail = DB::table('konfigurasi_js_kelas_detail')->where('kode_js_kelas', $kode_js_kelas)->get();

            return view('konfigurasi.editjamkelas',compact('jamsekolah','lokasi','kelas','jamkelas','jamkelas_detail'));
          }




        public function updatejamkelas($kode_js_kelas, Request $request)
        {
            $hari = $request->hari;
            $kode_jam = $request->kode_jam;

            DB::beginTransaction();
            try {
                DB::table('konfigurasi_js_kelas_detail')->where('kode_js_kelas', $kode_js_kelas)->delete();
                for($i=0; $i< count($hari); $i++){
                    $data[] = [
                        'kode_js_kelas' => $kode_js_kelas,
                        'hari' => $hari[$i],
                        'kode_jam' => $kode_jam[$i]
                    ];
                }
                Setjamkelas::insert($data);
                DB::commit();
                return redirect('konfigurasi/jamkelas')->with(['success'=>'Data Berhasil Di Update']);
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect('konfigurasi/jamkelas')->with(['warning'=>'Data Gagal Di Update']);
            }
        }


          public function deletejamkelas($kode_js_kelas)
          {
            try {
                DB::table('konfigurasi_js_kelas')->where('kode_js_kelas', $kode_js_kelas)->delete();
                return Redirect::back()->with(['success'=>'Data Berhasil di Hapus']);
            } catch (\Exception $e) {
                return Redirect::back()->with(['warning'=>'Data Gagal di Hapus']);

            }
        }

}
