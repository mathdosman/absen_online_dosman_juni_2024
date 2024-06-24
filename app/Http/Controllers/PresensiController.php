<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
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

    public function createpresensi(){
        $hariini = date("Y-m-d");
        $namahari = $this ->gethari();
        $nisn = Auth::guard('siswa')->user()->nisn;
        $kode_kelas = Auth::guard('siswa')->user()->kode_kelas;
        $cek = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nisn', $nisn)->count();
        $kode_lokasi = Auth::guard('siswa')->user()->kode_lokasi;
        $lok_sekolah = DB::table('lokasi')->where('kode_lokasi',$kode_lokasi)->first();

        $jamsekolah = DB::table('konfigurasi_jam')
        ->join('jam_sekolah','konfigurasi_jam.kode_jam','=','jam_sekolah.kode_jam')
        ->where('nisn',$nisn)
        ->where('hari', $namahari)
        ->first();

        $status= DB::table('presensi')->where('tgl_presensi', $hariini)->where('nisn', $nisn)->first();


        if($jamsekolah ==null){
            $jamsekolah = DB::table('konfigurasi_js_kelas_detail')
            ->join('konfigurasi_js_kelas','konfigurasi_js_kelas_detail.kode_js_kelas','=','konfigurasi_js_kelas.kode_js_kelas')
            ->join('jam_sekolah','konfigurasi_js_kelas_detail.kode_jam','=','jam_sekolah.kode_jam')
            ->where('kode_kelas', $kode_kelas)
            ->where('kode_lokasi', $kode_lokasi)
            ->where('hari', $namahari)
            ->first();
        }

        // if($jamsekolah == null){
        //     return view('presensi.notifjadwal', compact('status'));
        // }else{
        //     return view('presensi.create_presensi', compact('cek','lok_sekolah','jamsekolah'));
        // }

        if(!empty($status) && !empty($status->jam_out)){
            return view('presensi.notifjadwal', compact('status'));
        }else{
            if(!empty($status) && $status->status !== "h"){
                return view('presensi.notifjadwal', compact('status'));
            }else{
                if($jamsekolah == null){
                    return view('presensi.notifjadwal', compact('status'));
                }else{
                    return view('presensi.create_presensi', compact('cek','lok_sekolah','jamsekolah'));
                }
            }
        }

    }

    // STORE++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function store(Request $request){
        $nisn = Auth :: guard('siswa')->user()->nisn;
        $kode_lokasi = Auth :: guard('siswa')->user()->kode_lokasi;
        $kode_kelas = Auth::guard('siswa')->user()->kode_kelas;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lok_sekolah = DB::table('lokasi')->where('kode_lokasi',$kode_lokasi)->first();
        $lok = explode(",",$lok_sekolah->titik_lokasi);
        $latitudesekolah = $lok[0];
        $longitudesekolah = $lok[1];
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latitudesekolah, $longitudesekolah, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);

        $namahari = $this ->gethari();
        $jamsekolah = DB::table('konfigurasi_jam')
        ->join('jam_sekolah','konfigurasi_jam.kode_jam','=','jam_sekolah.kode_jam')
        ->where('nisn',$nisn)
        ->where('hari', $namahari)
        ->first();


        if($jamsekolah == null){
            $jamsekolah = DB::table('konfigurasi_js_kelas_detail')
            ->join('konfigurasi_js_kelas','konfigurasi_js_kelas_detail.kode_js_kelas','=','konfigurasi_js_kelas.kode_js_kelas')
            ->join('jam_sekolah','konfigurasi_js_kelas_detail.kode_jam','=','jam_sekolah.kode_jam')
            ->where('kode_kelas', $kode_kelas)
            ->where('kode_lokasi', $kode_lokasi)
            ->where('hari', $namahari)
            ->first();
        }

        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nisn', $nisn)->count();

        if($cek > 0){
            $ket = "out";
        } else{
            $ket = "in";
        }
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = $nisn."-".$tgl_presensi."-".$ket;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName.".png";
        $file = $folderPath . $fileName;

        $datasiswa = DB::table('siswa')->where('nisn',$nisn)->first();
        $no_hp = $datasiswa->no_hp;

        if($radius > $lok_sekolah->radius){
            echo "error|Maaf Anda Berada diluar radius, Anda berada $radius meter dari titik absen, radius yang di izinkan harus kurang dari $lok_sekolah->radius meter|radius";
        } else{
             if($cek > 0){
                if($jam<$jamsekolah->start_pulang){
                    echo "error|Maaf Belum waktunya melakukan Absensi Pulang|out";
                } else {
                    $data_pulang = [
                        'jam_out' => $jam,
                        'foto_out' => $fileName,
                        'lokasi_out' => $lokasi
                    ];
                    $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nisn', $nisn)->update($data_pulang);
                    if($update){
                        echo "success|Absen Berhasil, Hati-hati dijalan!|out";
                        Storage::put($file, $image_base64);

                        $curl = curl_init();

                    curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://wadosman.sman1-gianyar.sch.id/send-message',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array('message' => 'Terima Kasih Sudah Melakukan Absen Pulang, '.$datasiswa->nama_siswa.' melakukan Absen pada Jam '.$jam ,'number' => $no_hp,'file_dikirim'=>''),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    // echo $response;


                    }else{
                        echo "error|Maaf Gagal Absen, Hubungi Tim IT|out";
                    }
                }
        } else{
            if($jam < $jamsekolah->start_datang){
                echo "error|Maaf Belum waktunya melakukan presensi|in";
            }else if($jam > $jamsekolah->end_datang){
                echo "error|Maaf Sesi presensi telah berakhir|in";
            } else{
                $data = [
                    'nisn' => $nisn,
                    'tgl_presensi' =>$tgl_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $fileName,
                    'lokasi_in' => $lokasi,
                    'status' =>'h',
                    'kode_jam'=>$jamsekolah->kode_jam
                ];
                $simpan = DB::table('presensi')->insert($data);
                if($simpan){
                    echo "success|Absen Berhasil, Selamat Belajar!|in";
                    Storage::put($file, $image_base64);

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://wadosman.sman1-gianyar.sch.id/send-message',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array('message' => 'Terima Kasih Sudah Melakukan Absen Masuk, '.$datasiswa->nama_siswa.' melakukan Absen pada Jam '.$jam ,'number' => $no_hp,'file_dikirim'=>''),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    // echo $response;

                }else{
                    echo "error|Maaf Gagal Absen, Hubungi Tim IT|out";
                }
            }
        }
        }
    }

    //menghitung jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }


}
