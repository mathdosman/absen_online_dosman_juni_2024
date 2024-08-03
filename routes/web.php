<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SakitController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\DispenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HariLiburController;
use App\Http\Controllers\IzinabsenController;
use App\Http\Controllers\IzinsakitController;
use App\Http\Controllers\IzindispenController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\KonfigurasiController;
use App\Models\Siswa;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest:siswa'])->group(function(){
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/proseslogin',[AuthController::class,'proseslogin']);
});

Route::middleware(['guest:user'])->group(function(){
    Route::get('/dosman', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');
    Route::post('/prosesloginadmin',[AuthController::class,'prosesloginadmin']);
});


Route::middleware(['auth:siswa'])->group(function(){
    Route::get('/dashboard',[DashboardController::class,'index']);
    Route::get('/proseslogout',[AuthController::class,'proseslogout']);

    // presensi
    Route::get('/createpresensi',[PresensiController::class,'createpresensi']);
    Route::post('/presensi/store',[PresensiController::class,'store']);

    // Profile
    Route::get('/editprofile',[ProfileController::class,'editprofile']);
    Route::post('/profile/{nisn}/updateprofile',[ProfileController::class,'updateprofile']);
    // Histori
    Route::get('/profile/histori',[ProfileController::class,'histori']);
    Route::post('/gethistori', [ProfileController::class,'gethistori']);

     //Izizn Absen
     Route::get('/ajuan/izin', [IzinabsenController::class,'rekapizin']);
     Route::get('/izinabsen', [IzinabsenController::class,'create']);


     Route::get('/izinsakit',[SakitController::class,'create']);
     Route::post('/izinsakit/store',[SakitController::class, 'store']);
     Route::get('/izinsakit/{kode_izin}/edit', [SakitController::class,'edit']);
     Route::post('/izinsakit/{kode_izin}/update', [SakitController::class,'update']);

     //Izizn Absen
    Route::get('/izinabsen', [IzinabsenController::class,'create']);
    Route::post('/izinabsen/store', [IzinabsenController::class,'store']);
    Route::get('/izinabsen/{kode_izin}/edit', [IzinabsenController::class,'edit']);
    Route::post('/izinabsen/{kode_izin}/update', [IzinabsenController::class,'update']);

    //Izin Dispen
    Route::get('/izindispen', [DispenController::class,'create']);
    Route::post('/izindispen/store', [DispenController::class,'store']);
    Route::get('/izindispen/{kode_izin}/edit', [DispenController::class,'edit']);
    Route::post('/izindispen/{kode_izin}/update', [DispenController::class,'update']);

    Route::get('/izin/{kode_izin}/showact', [IzinabsenController::class,'showact']);
    Route::get('/izin/{kode_izin}/delete', [IzinabsenController::class,'deleteizin']);


});

Route::middleware(['auth:user'])->group(function(){
    Route::get('/dosman/dashboardadmin',[DashboardController::class,'dashboardadmin']);
    Route::get('/dosman/proseslogoutadmin', [AuthController::class, 'proseslogoutadmin']);

    // SISWA
    Route::get('/siswa', [SiswaController::class, 'index']);

    Route::post('/siswa/store', [SiswaController::class, 'store']);
    Route::post('/siswa/edit', [SiswaController::class, 'edit']);
    Route::post('/siswa/fotox', [SiswaController::class, 'foto']);
    Route::post('/siswa/{nisn}/update', [SiswaController::class, 'update']);
    Route::post('/siswa/{nisn}/delete', [SiswaController::class, 'delete']);
    Route::get('/siswa/{nisn}/resetpassword',[SiswaController::class, 'resetpassword']);

    // Kelas
    Route::get('/kelas',[KelasController::class,'index']);
     Route::post('/kelas/store', [KelasController::class, 'store']);
     Route::post('/kelas/edit', [KelasController::class, 'edit']);
     Route::post('/kelas/{kode_kelas}/update', [KelasController::class, 'update']);
     Route::post('/kelas/{kode_kelas}/delete', [KelasController::class, 'delete']);


     //presensiMonitoring
    Route:: get('/cetak/monitoring',[MonitoringController::class, 'monitoring']);
    Route:: post('/getpresensi',[MonitoringController::class, 'getpresensi']);
    Route:: post('/cetak/foto_in',[MonitoringController::class, 'foto_in']);
    Route:: post('/cetak/foto_out',[MonitoringController::class, 'foto_out']);

    Route::get('/cetak/laporansiswa',[MonitoringController::class, 'laporansiswa']);
    Route::get('/cetak/{nisn}/rekapsiswa',[MonitoringController::class, 'rekap_siswa']);
    Route::get('/cetak/laporankelas',[MonitoringController::class, 'laporankelas']);
    Route::post('/cetak/rekapkelas', [MonitoringController::class, 'rekapkelas']);
    Route::post('/getlaporansiswa',[MonitoringController::class, 'getlaporansiswa']);

    // Konfigurasi
    Route::get('/konfigurasi/lokasi',[KonfigurasiController::class, 'lokasi']);
    Route::post('/lokasi/store',[KonfigurasiController::class, 'store']);
    Route::post('/lokasi/edit',[KonfigurasiController::class, 'edit']);
    Route::post('/lokasi/{kode_kelas}/update',[KonfigurasiController::class, 'update']);
    Route::post('/lokasi/{kode_kelas}/delete',[KonfigurasiController::class, 'delete']);

    // JAM SETTING
    Route:: get('/konfigurasi/jamsekolah',[KonfigurasiController::class, 'jamsekolah']);
    Route:: post('/konfigurasi/storejamsekolah',[KonfigurasiController::class, 'storejamsekolah']);
    Route:: post('/konfigurasi/editjamsekolah',[KonfigurasiController::class, 'editjamsekolah']);
    Route:: post('/konfigurasi/updatejs',[KonfigurasiController::class, 'updatejs']);
    Route:: post('/konfigurasi/{kode_jam}/delete',[KonfigurasiController::class, 'deletejamsekolah']);
    Route:: get('/konfigurasi/{nisn}/setjamsekolah',[KonfigurasiController::class, 'setjamsekolah']);
    Route:: post('/konfigurasi/storesetjamsekolah',[KonfigurasiController::class, 'storesetjamsekolah']);
    Route:: post('/konfigurasi/updatesetjamsekolah',[KonfigurasiController::class, 'updatesetjamsekolah']);

    // JAM KELAS
    Route::get('/konfigurasi/jamkelas', [KonfigurasiController::class, 'jamkelas']);
    Route::get('/konfigurasi/jamkelas/create', [KonfigurasiController::class, 'createjamkelas']);
    Route::post('/konfigurasi/jamkelas/store', [KonfigurasiController::class, 'storejamkelas']);
    Route::get('/konfigurasi/jamkelas/{kode_js_kelas}/edit', [KonfigurasiController::class, 'editjamkelas']);
    Route::post('/konfigurasi/jamkelas/{kode_js_kelas}/update', [KonfigurasiController::class, 'updatejamkelas']);
    Route::get('/konfigurasi/jamkelas/{kode_js_kelas}/delete',[KonfigurasiController::class, 'deletejamkelas']);




    // Ajuan
    Route::get('/presensi/izinsakit', [IzinabsenController::class, 'izinsakit']);
    Route::post('/presensi/approveizinsakit', [IzinabsenController::class, 'approveizinsakit']);
    Route::get('/presensi/{kode_izin}/batalkanizinsakit', [IzinabsenController::class, 'batalkanizinsakit']);
    Route::post('/ajuan/surat', [IzinabsenController::class, 'berkasajuan']);
    Route::get('/ajuan/{kode_izin}/delete', [IzinabsenController::class,'deleteadmin']);


    // HARI LIBUR
    Route::get('/konfigurasi/harilibur', [HariLiburController::class,'index']);
    Route::post('/konfigurasi/storelibur', [HariLiburController::class,'storelibur']);
    Route::post('/konfigurasi/libur/{kode_libur}/delete',[HariLiburController::class, 'deletelibur']);





});
