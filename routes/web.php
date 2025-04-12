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
use App\Http\Controllers\ProvinsiController;
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

Route::get('admin/diklat',[DiklatController::class, 'index'])->name('admin.diklat');

Route::get('admin/mutasi', [MutasiController::class, 'index'])->name('admin.mutasi');

Route::get('admin/kepangkatan', [KepangkatanController::class, 'index'])->name('admin.kepangkatan');

Route::get('admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan');

Route::get('admin/profile', [ProfileController::class, 'index'])->name('admin.profile');

Route::get('admin/account-settting', [AccountSettingsController::class, 'index'])->name('admin.account-setting');

Route::get('admin/pronvisi', [ProvinsiController::class, 'index'])->name('admin.provinsi');
Route::get('/admin/provinsi/{id}/edit', [ProvinsiController::class, 'edit'])->name('admin.provinsi.edit');
Route::put('/admin/provinsi/{id}', [ProvinsiController::class, 'update'])->name('admin.provinsi.update');
Route::delete('/admin/provinsi/{id}', [ProvinsiController::class, 'destroy'])->name('admin.provinsi.destroy');
Route::post('/admin/provinsi/bulk-delete', [ProvinsiController::class, 'bulkDelete'])->name('admin.provinsi.bulkDelete');
Route::get('/admin/provinsi/create', [ProvinsiController::class, 'create'])->name('admin.provinsi.create');
Route::post('/admin/provinsi/store', [ProvinsiController::class, 'store'])->name('admin.provinsi.store');
Route::post('/admin/provinsi/import', [ProvinsiController::class, 'import'])->name('admin.provinsi.import');
Route::get('/admin/provinsi/template', [ProvinsiController::class, 'downloadTemplate'])->name('admin.provinsi.download-template');
Route::get('/admin/provinsi/cari', [ProvinsiController::class, 'search'])->name('admin.provinsi.search');


Route::get('admin/kabupaten', [KabupatenController::class, 'index'])->name('admin.kabupaten');
Route::get('admin/kecamatan', [KecamatanController::class, 'index'])->name('admin.kecamatan');