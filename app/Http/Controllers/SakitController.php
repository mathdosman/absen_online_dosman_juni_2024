<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SakitController extends Controller
{
    public function create(){
        return view('ajuan.sakit.create');
    }
    public function store(Request $request)
    {
        $nisn = Auth::guard('siswa')->user()->nisn;
        $sid = $request->sid;
        $tgl_izin_dari = $request->tgl_izin_dari;
        $tgl_izin_sampai = $request->tgl_izin_sampai;
        $status = "s";
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
        $format = "S".$nisn.$day.$bulan.$thn;
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
        return view('ajuan.sakit.edit', compact('dataizin'));
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
}
