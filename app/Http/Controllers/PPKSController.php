<?php

namespace App\Http\Controllers;

use App\Models\PPKSLaporan;
use App\Models\Berita;
use App\Models\Setting;
use App\Models\Kategori;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PPKSController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FRONTEND PUBLIC
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $setting = Setting::first();

        // Ambil berita & edukasi terkait PPKS (kategori 'ppks')
        $beritasPPKS = Berita::where('kategori', 'ppks')
            ->where('publish_at', '<=', now())
            ->latest('publish_at')
            ->get();

        // Jika belum ada warta PPKS, ambil berita pengumuman atau edukasi umum
        if ($beritasPPKS->isEmpty()) {
            $beritasPPKS = Berita::where('publish_at', '<=', now())
                ->where(function ($q) {
                    $q->where('judul', 'like', '%ppks%')
                      ->orWhere('judul', 'like', '%kekerasan%')
                      ->orWhere('kategori', 'pengumuman');
                })
                ->latest('publish_at')
                ->take(4)
                ->get();
        }

        return view('ppks.index', compact('setting', 'beritasPPKS'));
    }

    public function storeLaporan(Request $request)
    {
        $request->validate([
            'status_pelapor'     => 'required|string',
            'is_anonim'          => 'nullable',
            'nama_pelapor'       => 'nullable|string|max:255',
            'no_telp'            => 'required|string|max:50',
            'email'              => 'nullable|email|max:100',
            'kategori_kekerasan' => 'required|string|max:100',
            'tanggal_kejadian'   => 'nullable|date',
            'lokasi_kejadian'    => 'nullable|string|max:255',
            'nama_terlapor'      => 'nullable|string|max:255',
            'kronologi'          => 'required|string|min:20',
            // VALIDASI DOKUMEN & BUKTI: WAJIB PDF, DOC, DOCX (atau foto jpg/png)
            'dokumen_bukti'      => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:30720',
            'kebutuhan_pendampingan' => 'nullable|array',
        ], [
            'status_pelapor.required'     => 'Silakan pilih status pelapor (Mahasiswa, Dosen, dll).',
            'no_telp.required'            => 'Nomor telepon / WhatsApp wajib diisi untuk kontak rahasia.',
            'kategori_kekerasan.required' => 'Pilih kategori kekerasan / pelecehan yang dilaporkan.',
            'kronologi.required'          => 'Uraikan kronologi kejadian secara jelas.',
            'kronologi.min'               => 'Uraian kronologi minimal 20 karakter.',
            'dokumen_bukti.mimes'         => 'Format dokumen lampiran wajib berupa file PDF, DOC, DOCX, atau JPG/PNG.',
            'dokumen_bukti.max'           => 'Ukuran file dokumen bukti maksimal 30 MB.',
        ]);

        $isAnonim = $request->boolean('is_anonim');
        $namaPelapor = $isAnonim ? null : $request->nama_pelapor;

        $dokumenBukti = null;
        if ($request->hasFile('dokumen_bukti')) {
            $file = $request->file('dokumen_bukti');
            $ext = $file->getClientOriginalExtension();
            $cleanName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $namaFile = 'ppks_' . time() . '_' . substr($cleanName, 0, 30) . '.' . $ext;
            
            $file->move(public_path('uploads/ppks'), $namaFile);
            $dokumenBukti = $namaFile;
        }

        $pendampingan = $request->has('kebutuhan_pendampingan') 
            ? implode(', ', $request->kebutuhan_pendampingan) 
            : null;

        // Generate nomor tiket acak unik
        $kodeTiket = 'PPKS-' . date('Y') . '-' . strtoupper(Str::random(5));

        $laporan = PPKSLaporan::create([
            'kode_tiket'             => $kodeTiket,
            'is_anonim'              => $isAnonim,
            'nama_pelapor'           => $namaPelapor,
            'status_pelapor'         => $request->status_pelapor,
            'no_telp'                => $request->no_telp,
            'email'                  => $request->email,
            'kategori_kekerasan'     => $request->kategori_kekerasan,
            'tanggal_kejadian'       => $request->tanggal_kejadian,
            'lokasi_kejadian'        => $request->lokasi_kejadian,
            'nama_terlapor'          => $request->nama_terlapor,
            'kronologi'              => $request->kronologi,
            'dokumen_bukti'          => $dokumenBukti,
            'kebutuhan_pendampingan' => $pendampingan,
            'status'                 => 'baru',
        ]);

        return redirect()->route('ppks.index')
            ->with('laporan_sukses', true)
            ->with('kode_tiket', $kodeTiket)
            ->with('success', 'Laporan Anda telah berhasil terkirim secara aman dan rahasia ke Satgas PPKS.');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN MANAGEMENT
    |--------------------------------------------------------------------------
    */

    public function adminIndex(Request $request)
    {
        $status = $request->status;
        $search = $request->search;

        $query = PPKSLaporan::latest();

        if ($status && in_array($status, ['baru', 'ditinjau', 'investigasi', 'selesai'])) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode_tiket', 'like', "%{$search}%")
                  ->orWhere('nama_pelapor', 'like', "%{$search}%")
                  ->orWhere('kategori_kekerasan', 'like', "%{$search}%")
                  ->orWhere('kronologi', 'like', "%{$search}%");
            });
        }

        $laporans = $query->paginate(15);

        $counts = [
            'total'       => PPKSLaporan::count(),
            'baru'        => PPKSLaporan::where('status', 'baru')->count(),
            'ditinjau'    => PPKSLaporan::where('status', 'ditinjau')->count(),
            'investigasi' => PPKSLaporan::where('status', 'investigasi')->count(),
            'selesai'     => PPKSLaporan::where('status', 'selesai')->count(),
        ];

        return view('admin.ppks.index', compact('laporans', 'counts', 'status', 'search'));
    }

    public function adminShow($id)
    {
        $laporan = PPKSLaporan::findOrFail($id);
        return view('admin.ppks.show', compact('laporan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status'          => 'required|in:baru,ditinjau,investigasi,selesai',
            'catatan_petugas' => 'nullable|string',
        ]);

        $laporan = PPKSLaporan::findOrFail($id);
        $laporan->update([
            'status'          => $request->status,
            'catatan_petugas' => $request->catatan_petugas,
        ]);

        ActivityLogger::log('UPDATE', 'Layanan PPKS', "Memperbarui status laporan #{$laporan->kode_tiket} menjadi '{$request->status}'");

        return redirect()->route('admin.ppks.show', $laporan->id)
            ->with('success', 'Status laporan ' . $laporan->kode_tiket . ' berhasil diperbarui.');
    }

    public function adminDestroy($id)
    {
        $laporan = PPKSLaporan::findOrFail($id);
        $kodeTiket = $laporan->kode_tiket;
        $laporan->delete();

        ActivityLogger::log('DELETE', 'Layanan PPKS', "Menghapus data laporan #{$kodeTiket}");

        return redirect()->route('admin.ppks.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
