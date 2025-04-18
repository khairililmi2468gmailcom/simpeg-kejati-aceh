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
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KabupatenController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\MenerimaCutiController;
use App\Http\Controllers\MengikutiDiklatController;
use App\Http\Controllers\ProvinsiController;
use App\Http\Controllers\WilayahController;
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


Route::get('/home', function () {
    return redirect()->route('home');
});


// Template Excel Pegawai (download)
Route::get('/pegawai/template/excel', function () {
    return Excel::download(new TemplatePegawaiExport, 'template_pegawai.xlsx');
})->name('pegawai.template.excel');

// API Wilayah (untuk dropdown dinamis)
Route::get('/get-kabupaten/{id_provinsi}', [WilayahController::class, 'getKabupaten']);
Route::get('/get-kecamatan/{id_kabupaten}', [WilayahController::class, 'getKecamatan']);

// Referensi Views (bisa diakses di modal atau helper)
Route::prefix('data')->name('referensi.')->group(function () {
    Route::view('/provinsi', 'referensi.provinsi')->name('provinsi');
    Route::view('/kabupaten', 'referensi.kabupaten')->name('kabupaten');
    Route::view('/kecamatan', 'referensi.kecamatan')->name('kecamatan');
    Route::view('/golongan', 'referensi.golongan')->name('golongan');
    Route::view('/jabatan', 'referensi.jabatan')->name('jabatan');
    Route::view('/unit-kerja', 'referensi.unitkerja')->name('unitkerja');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/home', [PegawaiBarchartController::class, 'index'])->name('home');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::get('cuti', [CutiController::class, 'index'])->name('cuti');

    Route::get('mutasi', [MutasiController::class, 'index'])->name('mutasi');

    Route::get('kepangkatan', [KepangkatanController::class, 'index'])->name('kepangkatan');

    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan');

    Route::get('profile', [ProfileController::class, 'index'])->name('profile');

    Route::get('account-settting', [AccountSettingsController::class, 'index'])->name('account-setting');


    Route::prefix('pegawai')->name('pegawai.')->group(function () {
        Route::get('/', [PegawaiController::class, 'index'])->name('index');
        Route::get('/create', [PegawaiController::class, 'create'])->name('create');
        Route::post('/store', [PegawaiController::class, 'store'])->name('store');
        Route::get('/{nip}', [PegawaiController::class, 'show'])->name('show');
        Route::get('/{nip}/edit', [PegawaiController::class, 'edit'])->name('edit');
        Route::put('/{nip}', [PegawaiController::class, 'update'])->name('update');
        Route::delete('/{nip}', [PegawaiController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [PegawaiController::class, 'bulkDelete'])->name('bulkDelete');

        // Ekspor & Impor
        Route::get('export/pdf', [PegawaiController::class, 'exportPdf'])->name('export.pdf');
        Route::get('export/excel', [PegawaiController::class, 'exportExcel'])->name('export.excel');
        Route::post('import/excel', [PegawaiController::class, 'importExcel'])->name('import.excel');
    });

    Route::prefix('cuti')->name('cuti.')->group(function () {
        // Master Cuti Routes
        Route::prefix('jeniscuti')->name('jeniscuti.')->group(function () {
            Route::get('/', [CutiController::class, 'index'])->name('index'); // Akses dengan 'admin.diklat.master.index'
            Route::get('/create', [CutiController::class, 'create'])->name('create');
            Route::post('/store', [CutiController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CutiController::class, 'edit'])->name('edit');
            Route::put('/{id}', [CutiController::class, 'update'])->name('update');
            Route::delete('/{id}', [CutiController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-delete', [CutiController::class, 'bulkDelete'])->name('bulkDelete');
        });

        // Riwayat Cuti Routes
        Route::prefix('riwayatcuti')->name('riwayatcuti.')->group(function () {
            Route::get('/', [MenerimaCutiController::class, 'index'])->name('index');
            Route::get('/create', [MenerimaCutiController::class, 'create'])->name('create');
            Route::post('/store', [MenerimaCutiController::class, 'store'])->name('store');
            Route::get('/{id}', [MenerimaCutiController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [MenerimaCutiController::class, 'edit'])->name('edit');
            Route::put('/{id}', [MenerimaCutiController::class, 'update'])->name('update');
            Route::delete('/{id}', [MenerimaCutiController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-delete', [MenerimaCutiController::class, 'bulkDelete'])->name('bulkDelete');
        });
    });

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
            Route::get('/{id}', [MengikutiDiklatController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [MengikutiDiklatController::class, 'edit'])->name('edit');
            Route::put('/{id}', [MengikutiDiklatController::class, 'update'])->name('update');
            Route::delete('/{id}', [MengikutiDiklatController::class, 'destroy'])->name('destroy');
            Route::post('/bulk-delete', [MengikutiDiklatController::class, 'bulkDelete'])->name('bulkDelete');
        });
    });

    Route::prefix('mutasi')->name('mutasi.')->group(function () {
        Route::get('/', [MutasiController::class, 'index'])->name('index');
        Route::get('/create', [MutasiController::class, 'create'])->name('create');
        Route::post('/store', [MutasiController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [MutasiController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MutasiController::class, 'update'])->name('update');
        Route::get('/{id}', [MutasiController::class, 'show'])->name('show');
        Route::delete('/{id}', [MutasiController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [MutasiController::class, 'bulkDelete'])->name('bulkDelete');
    });
    
    Route::prefix('kepangkatan')->name('kepangkatan.')->group(function () {
        Route::get('/', [KepangkatanController::class, 'index'])->name('index');
        Route::get('/create', [KepangkatanController::class, 'create'])->name('create');
        Route::post('/store', [KepangkatanController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [KepangkatanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [KepangkatanController::class, 'update'])->name('update');
        Route::get('/{id}', [KepangkatanController::class, 'show'])->name('show');
        Route::delete('/{id}', [KepangkatanController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-delete', [KepangkatanController::class, 'bulkDelete'])->name('bulkDelete');
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

    Route::prefix('settings')->name('settings.')->group(
        function () {

            Route::get('/', [SettingsController::class, 'index'])->name('index');

            Route::prefix('admin')->name('admin.')->group(function () {
                Route::get('/', [SettingsController::class, 'index'])->name('index');
                Route::get('/create', [SettingsController::class, 'createAdmin'])->name('create');
                Route::post('/store', [SettingsController::class, 'storeAdmin'])->name('store');
                Route::get('/{id}/edit', [SettingsController::class, 'editAdmin'])->name('edit');
                Route::put('/{id}', [SettingsController::class, 'updateAdmin'])->name('update');
                Route::delete('/{id}', [SettingsController::class, 'destroyAdmin'])->name('destroy');
                Route::post('/bulk-delete', [SettingsController::class, 'bulkDeleteAdmin'])->name('bulkDelete');
            });

            Route::prefix('jabatan')->name('jabatan.')->group(function () {
                Route::get('/', [SettingsController::class, 'indexJabatan'])->name('index');
                Route::get('/create', [SettingsController::class, 'createJabatan'])->name('create');
                Route::post('/store', [SettingsController::class, 'storeJabatan'])->name('store');
                Route::get('/{id}', [SettingsController::class, 'showJabatan'])->name('show');
                Route::get('/{id}/edit', [SettingsController::class, 'editJabatan'])->name('edit');
                Route::put('/{id}', [SettingsController::class, 'updateJabatan'])->name('update');
                Route::delete('/{id}', [SettingsController::class, 'destroyJabatan'])->name('destroy');
                Route::post('/bulk-delete', [SettingsController::class, 'bulkDeleteJabatan'])->name('bulkDelete');
            });
            Route::prefix('golongan')->name('golongan.')->group(function () {
                Route::get('/', [SettingsController::class, 'index'])->name('index');
                Route::get('/create', [SettingsController::class, 'createGolongan'])->name('create');
                Route::post('/store', [SettingsController::class, 'storeGolongan'])->name('store');
                Route::get('/{id}', [SettingsController::class, 'showGolongan'])->name('show');
                Route::get('/{id}/edit', [SettingsController::class, 'editGolongan'])->name('edit');
                Route::put('/{id}', [SettingsController::class, 'updateGolongan'])->name('update');
                Route::delete('/{id}', [SettingsController::class, 'destroyGolongan'])->name('destroy');
                Route::post('/bulk-delete', [SettingsController::class, 'bulkDeleteGolongan'])->name('bulkDelete');
            });

            Route::prefix('unitkerja')->name('unitkerja.')->group(function () {
                Route::get('/', [SettingsController::class, 'index'])->name('index');
                Route::get('/create', [SettingsController::class, 'createUnitKerja'])->name('create');
                Route::post('/store', [SettingsController::class, 'storeUnitKerja'])->name('store');
                Route::get('/{id}', [SettingsController::class, 'showUnitKerja'])->name('show');
                Route::get('/{id}/edit', [SettingsController::class, 'editUnitKerja'])->name('edit');
                Route::put('/{id}', [SettingsController::class, 'updateUnitKerja'])->name('update');
                Route::delete('/{id}', [SettingsController::class, 'destroyUnitKerja'])->name('destroy');
                Route::post('/bulk-delete', [SettingsController::class, 'bulkDeleteUnitKerja'])->name('bulkDelete');
            });
        }
    );
});
