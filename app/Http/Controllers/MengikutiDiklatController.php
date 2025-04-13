<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MengikutiDiklat;
use App\Models\Pegawai;
use App\Models\Diklat;
use Illuminate\Support\Facades\DB;

class MengikutiDiklatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->per_page ?? 5;

        $data = MengikutiDiklat::with(['pegawai', 'diklat'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('pegawai', function ($q) use ($search) {
                    $q->where('nama', 'like', "%$search%")
                        ->orWhere('nip', 'like', "%$search%");
                })->orWhereHas('diklat', function ($q) use ($search) {
                    $q->where('nama_diklat', 'like', "%$search%")
                        ->orWhere('jenis_diklat', 'like', "%$search%");
                });
            })
            ->orderBy('tanggal_mulai', 'desc')
            ->paginate($perPage);

        return view('admin.diklat.riwayat.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = Pegawai::orderBy('nama')->get();
        $diklat = Diklat::orderBy('nama_diklat')->get();

        return view('admin.diklat.riwayat.create', [
            'pegawaiList' => $pegawai,
            'diklatList' => $diklat
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|exists:pegawai,nip',
            'diklat_id' => 'required|exists:diklat,id',
            'tempat_diklat' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'angkatan' => 'nullable|string|max:50',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jumlah_jam' => 'required|numeric|min:1|max:999999',
            'tanggal_sttpp' => 'required|date',
        ]);

        // Jalankan dalam transaksi agar aman dari race condition
        DB::beginTransaction();

        try {
            $maxAttempts = 5;
            $attempt = 0;

            do {
                $timestamp = now()->format('YmdHisv'); // YmdHis + microseconds
                $noSttpp = 'STTPP-' . $timestamp;

                $exists = MengikutiDiklat::where('no_sttpp', $noSttpp)->exists();

                if (!$exists) break;

                usleep(1000); // delay 1ms sebelum coba lagi
                $attempt++;
            } while ($attempt < $maxAttempts);

            if ($attempt === $maxAttempts) {
                throw new \Exception('Gagal menghasilkan nomor STTPP unik. Silakan coba lagi.');
            }

            $data = $request->all();
            $data['no_sttpp'] = $noSttpp;

            MengikutiDiklat::create($data);

            DB::commit();

            return redirect()->route('admin.diklat.riwayat.index')->with('success', 'Data riwayat diklat berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $no_sttpp)
    {
        $data = MengikutiDiklat::with(['pegawai', 'diklat'])->findOrFail($no_sttpp);
        return view('admin.diklat.riwayat.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $no_sttpp)
    {
        $data = MengikutiDiklat::findOrFail($no_sttpp);
        $pegawai = Pegawai::orderBy('nama')->get();
        $diklat = Diklat::orderBy('nama_diklat')->get();

        return view('admin.diklat.riwayat.edit', [
            'data' => $data,
            'pegawaiList' => $pegawai,
            'diklatList' => $diklat
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $no_sttpp)
    {
        $request->validate([
            'nip' => 'required|exists:pegawai,nip',
            'diklat_id' => 'required|exists:diklat,id',
            'tempat_diklat' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'angkatan' => 'nullable|string|max:50',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jumlah_jam' => 'required|numeric|min:1|max:2147483647',
            'tanggal_sttpp' => 'required|date',
        ]);

        $data = MengikutiDiklat::findOrFail($no_sttpp);
        $data->update($request->all());

        return redirect()->route('admin.diklat.riwayat.index')->with('success', 'Data riwayat diklat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $no_sttpp)
    {
        $data = MengikutiDiklat::findOrFail($no_sttpp);
        $data->delete();

        return redirect()->route('admin.diklat.riwayat.index')->with('success', 'Data riwayat diklat berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|array',
            'id.*' => 'string|exists:mengikuti_diklat,no_sttpp',
        ]);

        MengikutiDiklat::whereIn('no_sttpp', $request->id)->delete();

        return redirect()->route('admin.diklat.riwayat.index')->with('success', count($request->id) . ' data riwayat diklat berhasil dihapus.');
    }
}
