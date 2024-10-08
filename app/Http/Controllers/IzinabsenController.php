<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuanizin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class IzinabsenController extends Controller
{
    public function showact($kode_izin){

        $dataizin = DB::table('pengajuan_izin')
        ->where('kode_izin', $kode_izin)->first();

        return view('ajuan.showact',compact('dataizin'));
    }

// USER
    public function rekapizin(Request $request){
        $nisn = Auth::guard('siswa')->user()->nisn;

        if(!empty($request->bulan) && !empty($request->tahun)){
            $dataizin = DB::table('pengajuan_izin')
            ->orderBy('tgl_izin_dari','desc')
            ->where('nisn', $nisn)
            ->whereRaw('MONTH(tgl_izin_dari)="'.$request->bulan.'"')
            ->whereRaw('YEAR(tgl_izin_dari)="'.$request->tahun.'"')
            ->get();
        } else{
            $dataizin = DB::table('pengajuan_izin')
            ->orderBy('tgl_izin_dari','desc')
            ->where('nisn', $nisn)->limit(7)->orderBy('tgl_izin_dari','desc')
            ->get();
        }
        $namabulan =["","Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('ajuan.izin',compact('namabulan','dataizin'));
    }

    // ADMIN
    public function izinsakit(Request $request)
    {
        $query = Pengajuanizin::query();
        $query ->select('kode_izin','tgl_izin_dari','status','tgl_izin_sampai','pengajuan_izin.nisn','nama_siswa','kode_kelas','status_approved','keterangan','doc_sid','alasan_tolak');
        $query -> join('siswa','pengajuan_izin.nisn','=','siswa.nisn');

        if(!empty($request->dari) && !empty($request->sampai)){
            $query->whereBetween('tgl_izin_dari',[$request -> dari, $request->sampai]);
        }
        if(!empty($request->nisn)){
            $query->where('pengajuan_izin.nisn','like','%'. $request->nisn.'%');
        }
        if(!empty($request->nama_siswa)){
            $query->where('nama_siswa','like','%'. $request->nama_siswa.'%' );
        }
        if($request->status_approved === '0' || $request->status_approved === '1' || $request->status_approved === '2'){
            $query->where('status_approved',$request->status_approved);
        }

        if(!empty($request->kode_kelas)){
            $query->where('siswa.kode_kelas',$request->kode_kelas);
        }


        $query -> orderBy('tgl_izin_dari','desc');
        $izinsakit = $query->paginate(50);
        $izinsakit -> appends($request -> all());

        $lokasi = DB::table('lokasi')->orderBy('kode_lokasi')->get();
        $kelas = DB::table('kelas')->orderBy('kode_kelas')->get();

        return view('ajuan.prosesajuan',compact('izinsakit','kelas'));

    }

    public function approveizinsakit(Request $request)
    {
        $persetujuan = $request->persetujuan;
        $kode_izin = $request->kode_izin_form;
        $alasan_tolak = $request->alasan_tolak;

        $dataizin = DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->first();

        $dari = tgl_indo($dataizin->tgl_izin_dari);
        $sampai = tgl_indo($dataizin->tgl_izin_sampai);
        $keterangan = $dataizin->keterangan;

        $nisn = $dataizin->nisn;
        $status = $dataizin->status;
        $datasiswa = DB::table('siswa')->where('nisn',$nisn)->first();
        $nama = $datasiswa->nama_siswa;
        $tgl = tgl_indo(date('Y-m-d'));
        $no_hp = $datasiswa->no_hp;


        $tgl_dari = $dataizin->tgl_izin_dari;
        $tgl_sampai = $dataizin->tgl_izin_sampai;
        DB::beginTransaction();
        try {
            if($persetujuan == 1){
                while(strtotime($tgl_dari)<= strtotime($tgl_sampai)){
                    DB::table('presensi')->insert([
                        'nisn' => $nisn,
                        'tgl_presensi' => $tgl_dari,
                        'status' => $status,
                        'kode_izin'=>$kode_izin
                    ]);
                    $tgl_dari = date("Y-m-d",strtotime("+1 days", strtotime($tgl_dari)));
                }
            }

            DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->update([
                'status_approved' => $persetujuan,
                'alasan_tolak' => $alasan_tolak
            ]);
            DB::commit();
            if($persetujuan == 1){
                if($dataizin->status == "i"){
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
                        CURLOPT_POSTFIELDS => array('message' => $tgl.", \n".$nama." melakukan pengajuan *IZIN* tidak sekolah, dari tanggal ".$dari." sampai ".$sampai." dengan alasan : \n_".$keterangan."_ \n*(DISETUJUI)*" ,'number' => $no_hp,'file_dikirim'=>''),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    // echo $response;
                }elseif($dataizin->status == "s"){
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
                        CURLOPT_POSTFIELDS => array('message' => $tgl.", \n".$nama." melakukan pengajuan *SAKIT*, dari tanggal ".$dari." sampai ".$sampai." dengan alasan : \n_".$keterangan."_ \n*(DISETUJUI)*" ,'number' => $no_hp,'file_dikirim'=>''),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    // echo $response;
                }elseif($dataizin->status == "d"){
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
                        CURLOPT_POSTFIELDS => array('message' => $tgl.", \n".$nama." melakukan pengajuan *DISPENSASI* sekolah, dari tanggal ".$dari." sampai ".$sampai." dengan alasan : \n_".$keterangan."_ \n*(DISETUJUI)*" ,'number' => $no_hp,'file_dikirim'=>''),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    // echo $response;
                }
            }elseif($persetujuan == 2){
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
                    CURLOPT_POSTFIELDS => array('message' => $tgl.", \n".$nama." ajuan izin/sakit *DITOLAK* dengan alasan : \n_".$alasan_tolak."_ \nuntuk melakukan perbaikan ajuan, delete terlebih dahulu ajuan yang telah ditolak, dan lakukan pengajuan ulang" ,'number' => $no_hp,'file_dikirim'=>''),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                // echo $response;
            }

            return Redirect::back()->with(['success'=>'Data Berhasil di Update']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(['warning'=>'Data Gagal di Update']);
        }

    }

    public function batalkanizinsakit($kode_izin){
        $dataizin = DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->first();

        $dari = tgl_indo($dataizin->tgl_izin_dari);
        $sampai = tgl_indo($dataizin->tgl_izin_sampai);
        $keterangan = $dataizin->keterangan;

        $nisn = $dataizin->nisn;
        $status = $dataizin->status;
        $datasiswa = DB::table('siswa')->where('nisn',$nisn)->first();
        $nama = $datasiswa->nama_siswa;
        $tgl = tgl_indo(date('Y-m-d'));
        $no_hp = $datasiswa->no_hp;
        DB::beginTransaction();
        try {
            DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->update([
                'status_approved' => 0
            ]);
            DB::table('presensi')->where('kode_izin', $kode_izin)->delete();
            DB::commit();
            if($dataizin->status == "i"){
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
                    CURLOPT_POSTFIELDS => array('message' => $tgl.", \n".$nama." *PEMBATALAN* pengajuan *IZIN* tidak sekolah, dari tanggal ".$dari." sampai ".$sampai." dengan alasan : \n_".$keterangan."_" ,'number' => $no_hp,'file_dikirim'=>''),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                // echo $response;
            }elseif($dataizin->status == "s"){
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
                    CURLOPT_POSTFIELDS => array('message' => $tgl.", \n".$nama." *PEMBATALAN* pengajuan *SAKIT*, dari tanggal ".$dari." sampai ".$sampai." dengan alasan : \n_".$keterangan."_" ,'number' => $no_hp,'file_dikirim'=>''),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                // echo $response;
            }elseif($dataizin->status == "d"){
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
                    CURLOPT_POSTFIELDS => array('message' => $tgl.", \n".$nama." *PEMBATALAN* pengajuan *DISPENSASI* sekolah, dari tanggal ".$dari." sampai ".$sampai." dengan alasan : \n_".$keterangan."_" ,'number' => $no_hp,'file_dikirim'=>''),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                // echo $response;
            }
            return Redirect::back()->with(['success'=>'Pengajuan Berhasil Dibatalkan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with(['warning'=>'Pengajuan Gagal Dibatalkan']);
        }
    }
    public function cekpengajuanizin(Request $request){
        $tgl_izin = $request->tgl_izin;
        $nisn = Auth::guard('siswa')->user()->nisn;

        $cek = DB::table('pengajuan_izin')->where('nisn', $nisn)
        ->where('tgl_izin', $tgl_izin)->count();
        return $cek;
    }


    public function create()
    {
        return view('ajuan.izin.create');
    }
    public function store(Request $request)
    {
        $nisn = Auth::guard('siswa')->user()->nisn;
        $sid = $request->sid;
        $tgl_izin_dari = $request->tgl_izin_dari;
        $tgl_izin_sampai = $request->tgl_izin_sampai;
        $status = "i";
        $keterangan = $request->keterangan;
        $request->validate([
            'sid'=> 'image|mimes:png,jpg',
        ]);

        $bulan = date("m",strtotime($tgl_izin_dari));
        $tahun = date("Y",strtotime($tgl_izin_dari));
        $day = date("d",strtotime($tgl_izin_dari));
        $thn = substr($tahun,2,2);


        $lastizin = DB::table('pengajuan_izin')
        ->whereRaw('MONTH(tgl_izin_dari)="'.$bulan.'"')
        ->whereRaw('YEAR(tgl_izin_dari)="'.$tahun.'"')
        ->orderBy('kode_izin','desc')
        ->first();

        $lastkodeizin = $lastizin !== null ? $lastizin->kode_izin : "";
        $format = "I".$nisn.$bulan.$thn.$day;
        $kode_izin = buatkode($lastkodeizin,$format,2);

        if ($request->hasFile('sid')) {
            $sid = $kode_izin . "." . $request->file('sid')->getClientOriginalExtension();
        }else{
            $sid = null;
        }
        $data =[
            'kode_izin' => $kode_izin,
            'nisn' => $nisn,
            'tgl_izin_dari' => $tgl_izin_dari,
            'tgl_izin_sampai' => $tgl_izin_sampai,
            'status' => $status,
            'doc_sid' => $sid,
            'keterangan' => $keterangan
        ];


        $tgl_d = tgl_indo($tgl_izin_dari);
        $tgl_s = tgl_indo($tgl_izin_sampai);

        $cekpresensi = DB::table('presensi')
        ->where('nisn', $nisn)
        ->whereBetween('tgl_presensi',[$tgl_izin_dari,$tgl_izin_sampai])
        ->count();

        $cekpengajuan = DB::table('pengajuan_izin')
        ->where('nisn', $nisn)
        ->whereRaw('"'.$tgl_izin_dari.'" BETWEEN tgl_izin_dari AND tgl_izin_sampai')
        ->count();

        if($cekpengajuan > 0){
            if($tgl_izin_dari == $tgl_izin_sampai){
                return redirect('/ajuan/izin')->with(['error'=>'Pengajuan izin GAGAL, karena pada tanggal '.$tgl_d .' sudah terdapat data pengajuan izin lainnya.']);
            }else{
                return redirect('/ajuan/izin')->with(['error'=>'Pengajuan izin GAGAL, karena pada tanggal '.$tgl_d .' s/d '. $tgl_s.' sudah terdapat data pengajuan izin lainnya.']);
            }
        } else if($cekpresensi > 0)
        {
            if($tgl_izin_dari == $tgl_izin_sampai){
                return redirect('/ajuan/izin')->with(['error'=>'Pengajuan izin GAGAL, karena pada tanggal '.$tgl_d.' sudah terdapat data absen atau pengajuan izin lainnya telah disetujui.']);
            }else{
                return redirect('/ajuan/izin')->with(['error'=>'Pengajuan izin GAGAL, karena pada tanggal '.$tgl_d .' s/d '. $tgl_s.' sudah terdapat data absen atau pengajuan izin lainnya telah disetujui.']);
            }
        }

        $simpan = DB::table('pengajuan_izin')->insert($data);

        if($simpan){
            if ($request->hasFile('sid')) {
                $sid = $kode_izin . "." . $request->file('sid')->getClientOriginalExtension();
                $folderPath = "public/uploads/sid/";
                $request->file('sid')->storeAs($folderPath, $sid);
              }
            return redirect('/ajuan/izin')->with(['success'=>'Data Berhasil disimpan']);
        }else{
            return redirect('/ajuan/izin')->with(['error'=>'Data Gagal disimpan']);
        }

    }
    public function edit($kode_izin)
    {
        $dataizin = DB::table('pengajuan_izin')
        ->where('kode_izin', $kode_izin)->first();
        return view('ajuan.izin.edit', compact('dataizin'));
    }

    public function update($kode_izin, Request $request)
    {

        $sid = $request->sid;
        $tgl_izin_dari = $request->tgl_izin_dari;
        $tgl_izin_sampai = $request->tgl_izin_sampai;
        $keterangan = $request->keterangan;
        $docsid = DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->first();
        if ($request->hasFile('sid')) {
            $sid = $kode_izin . "." . $request->file('sid')->getClientOriginalExtension();
        }else{
            $sid = $docsid->doc_sid;
        }
        $data =[
            'tgl_izin_dari' => $tgl_izin_dari,
            'tgl_izin_sampai' => $tgl_izin_sampai,
            'doc_sid' => $sid,
            'keterangan' => $keterangan
        ];
        try {
            DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->update($data);
                if ($request->hasFile('sid')) {
                    $sid = $kode_izin . "." . $request->file('sid')->getClientOriginalExtension();
                    $folderPath = "public/uploads/sid/";
                    $request->file('sid')->storeAs($folderPath, $sid);
                  }
            return redirect('/ajuan/izin')->with(['success'=>'Data Berhasil di Update']);
        } catch (\Exception $e) {
            return redirect('/ajuan/izin')->with(['error'=>'Data Gagal di Update']);
        }
    }

    public function deleteizin($kode_izin){

        $cekdataizin = DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->first();
        $doc_sid = $cekdataizin->doc_sid;
        try {
            DB::table('pengajuan_izin')->where('kode_izin', $kode_izin)->delete();
            if($doc_sid !== null){
                Storage::delete('public/uploads/sid/'.$doc_sid);
            }
            return Redirect::back()->with(['success'=>'Data Berhasil di Hapus']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['error'=>'Data Gagal di Hapus']);
        }
    }

    public function berkasajuan(Request $request){
        $kode_izin = $request->kode_izin2;
        $berkas = DB::table('pengajuan_izin')
        ->join('siswa','siswa.nisn','=','pengajuan_izin.nisn')
        ->where('kode_izin',$kode_izin)->first();

        return view('ajuan.lihatberkas', compact('berkas'));
    }

    public function deleteadmin($kode_izin){
        $delete = DB::table('pengajuan_izin')->where('kode_izin',$kode_izin)->delete();
        $dlete = DB::table('presensi')->where('kode_izin',$kode_izin)->delete();
        if($delete || $dlete){
            return Redirect::back()->with(['success'=>'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['error'=>'Data Gagal Dihapus']);
        }
    }
}
