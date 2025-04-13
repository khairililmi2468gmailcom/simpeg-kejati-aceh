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
use App\Exports\PegawaiExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TemplatePegawaiExport;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\MengikutiDiklatController;
use App\Http\Controllers\ProvinsiController;
use App\Models\MengikutiDiklat;
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
Route::post('/admin/pegawai/bulk-delete', [PegawaiController::class, 'bulkDelete'])->name('admin.pegawai.bulkDelete');
Route::get('/data/provinsi', function () {
    return response()->json(\App\Models\Provinsi::select('id', 'nama_provinsi')->get());
});
Route::prefix('data')->group(function () {
    Route::view('/provinsi', 'referensi.provinsi')->name('referensi.provinsi');
    Route::view('/kabupaten', 'referensi.kabupaten')->name('referensi.kabupaten');
    Route::view('/kecamatan', 'referensi.kecamatan')->name('referensi.kecamatan');
    Route::view('/golongan', 'referensi.golongan')->name('referensi.golongan');
    Route::view('/jabatan', 'referensi.jabatan')->name('referensi.jabatan');
    Route::view('/unit-kerja', 'referensi.unitkerja')->name('referensi.unitkerja');
});

Route::get('/get-kabupaten/{id_provinsi}', [App\Http\Controllers\WilayahController::class, 'getKabupaten']);
Route::get('/get-kecamatan/{id_kabupaten}', [App\Http\Controllers\WilayahController::class, 'getKecamatan']);

Route::prefix('admin/pegawai')->name('admin.pegawai.')->group(function () {
    Route::get('export/pdf', [PegawaiController::class, 'exportPdf'])->name('export.pdf');
    Route::get('export/excel', [PegawaiController::class, 'exportExcel'])->name('export.excel');
    Route::post('import/excel', [PegawaiController::class, 'importExcel'])->name('import.excel');
});

Route::get('/pegawai/template/excel', function () {
    return Excel::download(new TemplatePegawaiExport, 'template_pegawai.xlsx');
});


Route::get('admin/cuti', [CutiController::class, 'index'])->name('admin.cuti');


Route::get('admin/mutasi', [MutasiController::class, 'index'])->name('admin.mutasi');

Route::get('admin/kepangkatan', [KepangkatanController::class, 'index'])->name('admin.kepangkatan');

Route::get('admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan');

Route::get('admin/profile', [ProfileController::class, 'index'])->name('admin.profile');

Route::get('admin/account-settting', [AccountSettingsController::class, 'index'])->name('admin.account-setting');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::prefix('diklat')->name('diklat.')->group(function () {
        // Master Diklat Routes
        Route::prefix('master')->name('master.')->group(function () {
            Route::get('/', [DiklatController::class, 'index'])->name('index'); // Akses dengan 'admin.diklat.master.index'
            Route::get('/create', [DiklatController::class, 'create'])->name('create');
            Route::post('/store', [DiklatController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [DiklatController::class, 'edit'])->name('edit');
            Route::put('/{id}', [DiklatController::class, 'update'])->name('update');
            Route::delete('/{id}', [DiklatController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-delete', [DiklatController::class, 'bulkDelete'])->name('bulkDelete');
        });

        // Riwayat Diklat Routes
        Route::prefix('riwayat')->name('riwayat.')->group(function () {
            Route::get('/', [MengikutiDiklatController::class, 'index'])->name('index');
            Route::get('/create', [MengikutiDiklatController::class, 'create'])->name('create');
            Route::post('/store', [MengikutiDiklatController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [MengikutiDiklatController::class, 'edit'])->name('edit');
            Route::put('/{id}', [MengikutiDiklatController::class, 'update'])->name('update');
            Route::delete('/{id}', [MengikutiDiklatController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-delete', [MengikutiDiklatController::class, 'bulkDelete'])->name('bulkDelete');
        });
    });

    // Provinsi Routes
    Route::prefix('provinsi')->name('provinsi.')->group(function () {
        Route::get('/', [ProvinsiController::class, 'index'])->name('index');
        Route::get('/create', [ProvinsiController::class, 'create'])->name('create');
        Route::post('/store', [ProvinsiController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProvinsiController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProvinsiController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProvinsiController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [ProvinsiController::class, 'bulkDelete'])->name('bulkDelete');
        Route::post('/import', [ProvinsiController::class, 'import'])->name('import');
        Route::get('/template', [ProvinsiController::class, 'downloadTemplate'])->name('download-template');
    });

    // Kabupaten Routes
    Route::prefix('kabupaten')->name('kabupaten.')->group(function () {
        Route::get('/', [KabupatenController::class, 'index'])->name('index');
        Route::get('/create', [KabupatenController::class, 'create'])->name('create');
        Route::post('/store', [KabupatenController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [KabupatenController::class, 'edit'])->name('edit');
        Route::put('/{id}', [KabupatenController::class, 'update'])->name('update');
        Route::delete('/{id}', [KabupatenController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [KabupatenController::class, 'bulkDelete'])->name('bulkDelete');
        Route::post('/import', [KabupatenController::class, 'import'])->name('import');
        Route::get('/template', [KabupatenController::class, 'downloadTemplate'])->name('download-template');
    });

    // Kecamatan Routes
    Route::prefix('kecamatan')->name('kecamatan.')->group(function () {
        Route::get('/', [KecamatanController::class, 'index'])->name('index');
        Route::get('/create', [KecamatanController::class, 'create'])->name('create');
        Route::post('/store', [KecamatanController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [KecamatanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [KecamatanController::class, 'update'])->name('update');
        Route::delete('/{id}', [KecamatanController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [KecamatanController::class, 'bulkDelete'])->name('bulkDelete');
        Route::post('/import', [KecamatanController::class, 'import'])->name('import');
        Route::get('/template', [KecamatanController::class, 'downloadTemplate'])->name('download-template');
    });
});
