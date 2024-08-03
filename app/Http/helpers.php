<?php

use Illuminate\Support\Facades\DB;
function hitungjamterlambat($jadwal_jam_masuk, $jam_presensi)
{
    $j1 = strtotime($jadwal_jam_masuk);
    $j2 = strtotime($jam_presensi);
    $diffterlambat = $j2 - $j1;

    $jamterlambat = floor($diffterlambat / (60 * 60));
    $menitterlambat = floor(($diffterlambat-($jamterlambat * (60 * 60)))/60);

    $jterlambat = $jamterlambat <= 9 ? "0".$jamterlambat : $jamterlambat;
    $mterlambat = $menitterlambat <= 9 ? "0".$menitterlambat : $menitterlambat;

    $terlambat = $jterlambat . ":".$mterlambat;
    return $terlambat;
}

function hitungjamterlambatdesimal($jam_masuk, $jam_presensi)
{
    $j1 = strtotime($jam_masuk);
    $j2 = strtotime($jam_presensi);
    $diffterlambat = $j2 - $j1;

    $jamterlambat = floor($diffterlambat / (60 * 60));
    $menitterlambat = floor(($diffterlambat-($jamterlambat * (60 * 60)))/60);

    $jterlambat = $jamterlambat <= 9 ? "0".$jamterlambat : $jamterlambat;
    $mterlambat = $menitterlambat <= 9 ? "0".$menitterlambat : $menitterlambat;

    $desimalterlambat = ROUND(($menitterlambat/60),2);
    return $desimalterlambat;
}

function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);

	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun

	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function hitunghari($tanggal_mulai, $tanggal_akhir){
    //Menghitung Hari
    $tanggal_1 = date_create($tanggal_mulai);
    $tanggal_2 = date_create($tanggal_akhir); // waktu sekarang
    $diff = date_diff( $tanggal_1, $tanggal_2 );

    return $diff->days+1;
}

function buatkode($nomor_terakhir, $kunci, $jumlah_karakter = 0)
{
    /* mencari nomor baru dengan memecah nomor terakhir dan menambahkan 1
    string nomor baru dibawah ini harus dengan format XXX000000
    untuk penggunaan dalam format lain anda harus menyesuaikan sendiri */
    $nomor_baru = intval(substr($nomor_terakhir, strlen($kunci))) + 1;
    //    menambahkan nol didepan nomor baru sesuai panjang jumlah karakter
    $nomor_baru_plus_nol = str_pad($nomor_baru, $jumlah_karakter, "0", STR_PAD_LEFT);
    //    menyusun kunci dan nomor baru
    $kode = $kunci . $nomor_baru_plus_nol;
    return $kode;
}

function hitungjamsekolah($jam_masuk, $jam_pulang)
    {
        $j_masuk = strtotime($jam_masuk);
        $j_pulang = strtotime($jam_pulang);
        $diff = $j_pulang - $j_masuk;
        if (empty($j_pulang)) {
            $jam = 0;
            $menit = 0;
        } else {
            $jam = floor($diff / (60 * 60));
            $m = $diff - $jam * (60 * 60);
            $menit = floor($m / 60);
        }

        return $jam;
    }

    function getlibur($dari, $sampai)
    {
        $datalibur = DB::table('hari_libur')
        ->whereBetween('tgl_libur',[$dari,$sampai])
        ->get();

        $siswalibur = [];
        foreach($datalibur as $d){
            $siswalibur []= [
                'tgl_libur' => $d->tgl_libur,
            ];
        }
        return $siswalibur;
    }

    function cekharilibur($array, $search_list)
    {
        // Create the result array
        $result = array();
        // Iterate over each array element
        foreach ($array as $key => $value) {

            // Iterate over each search condition
            foreach ($search_list as $k => $v) {
            // If the array element does not meet
            // the search condition then continue
            // to the next element
            if (!isset($value[$k]) || $value[$k] != $v) {
            // Skip two loops
            continue 2;
                }
             }
    // Append array element's key to the
    //result array
    $result[] = $value;
    }
    // Return result
    return $result;
    }

