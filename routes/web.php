<?php

use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\DiklatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KepangkatanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\PegawaiBarchartController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use Symfony\Component\HttpKernel\Profiler\Profile;

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
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

Route::get('/font/{folder}/{filename}', function ($folder, $filename) {
    $path = public_path("font/{$folder}/{$filename}");

    if (!File::exists($path)) {
        abort(404);
    }

    return Response::file($path);
});


Route::get('/', function () {
    return view(view: 'home');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/admin/home', [HomeController::class, 'index'])->name('admin.home');


Route::get('/home', function () {
    return redirect()->route('home');
});
Route::get('/admin/home', [PegawaiBarchartController::class, 'index'])->name('admin.home');

Route::get('/admin/settings', [SettingsController::class, 'index'])->name('admin.settings');

// Route untuk halaman index pegawai
Route::get('/admin/pegawai', [PegawaiController::class, 'index'])->name('admin.pegawai');

// Route untuk menampilkan form tambah pegawai
Route::get('/admin/pegawai/create', [PegawaiController::class, 'create'])->name('admin.pegawai.create');
// Route untuk menyimpan pegawai baru
Route::post('/admin/pegawai/store', [PegawaiController::class, 'store'])->name('admin.pegawai.store');
// Route untuk menampilkan detail pegawai
Route::get('/admin/pegawai/{nip}', [PegawaiController::class, 'show'])->name('admin.pegawai.show');
// Route untuk menampilkan form edit pegawai
Route::get('/admin/pegawai/{nip}/edit', [PegawaiController::class, 'edit'])->name('admin.pegawai.edit');
// Route untuk update data pegawai
Route::put('/admin/pegawai/{nip}', [PegawaiController::class, 'update'])->name('admin.pegawai.update');
// Route untuk menghapus pegawai
Route::delete('/admin/pegawai/{nip}', [PegawaiController::class, 'destroy'])->name('admin.pegawai.destroy');

Route::get('admin/cuti', [CutiController::class, 'index'])->name('admin.cuti');

Route::get('admin/diklat',[DiklatController::class, 'index'])->name('admin.diklat');

Route::get('admin/mutasi', [MutasiController::class, 'index'])->name('admin.mutasi');

Route::get('admin/kepangkatan', [KepangkatanController::class, 'index'])->name('admin.kepangkatan');

Route::get('admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan');

Route::get('admin/profile', [ProfileController::class, 'index'])->name('admin.profile');

Route::get('admin/account-settting', [AccountSettingsController::class, 'index'])->name('admin.account-setting');

