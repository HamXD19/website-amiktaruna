<?php

namespace App\Http\Controllers;

use App\Models\PPKSLaporan;
use App\Models\Berita;
use App\Models\Setting;
use App\Models\Kategori;
use App\Services\ActivityLogger;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            $ext = strtolower($file->getClientOriginalExtension());
            $allowedExts = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
            if (!in_array($ext, $allowedExts, true)) {
                $ext = $file->extension() ?: 'bin';
            }
            $cleanName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $cleanName = substr($cleanName, 0, 30) ?: 'bukti';
            // Simpan dengan token acak 12 karakter agar tidak dapat ditebak
            $namaFile = 'ppks_' . time() . '_' . Str::random(12) . '_' . $cleanName . '.' . $ext;
            
            // Simpan di private storage (storage/app/private/ppks)
            $file->storeAs('ppks', $namaFile, 'local');
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

        if ($laporan->dokumen_bukti) {
            $filename = basename($laporan->dokumen_bukti);
            if (Storage::disk('local')->exists('ppks/' . $filename)) {
                Storage::disk('local')->delete('ppks/' . $filename);
            }
            $legacyPath = public_path('uploads/ppks/' . $filename);
            if (file_exists($legacyPath) && is_file($legacyPath)) {
                @unlink($legacyPath);
            }
        }

        $laporan->delete();

        ActivityLogger::log('DELETE', 'Layanan PPKS', "Menghapus data laporan #{$kodeTiket}");

        return redirect()->route('admin.ppks.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    /**
     * Unduh atau tampilkan berkas bukti PPKS secara aman untuk Satgas / Admin
     */
    public function adminDownloadBukti(Request $request, $id)
    {
        $laporan = PPKSLaporan::findOrFail($id);

        if (!$laporan->dokumen_bukti) {
            abort(404, 'Berkas bukti tidak ditemukan pada laporan ini.');
        }

        $filename = basename($laporan->dokumen_bukti);

        // 1. Cek di private storage (penyimpanan standar baru yang aman)
        if (Storage::disk('local')->exists('ppks/' . $filename)) {
            ActivityLogger::log('VIEW', 'Layanan PPKS', "Mengakses berkas bukti laporan #{$laporan->kode_tiket}");

            if ($request->query('view') === '1') {
                return Storage::disk('local')->response('ppks/' . $filename);
            }
            return Storage::disk('local')->download('ppks/' . $filename);
        }

        // 2. Fallback jika berkas lama tersimpan di public/uploads/ppks
        $legacyPath = public_path('uploads/ppks/' . $filename);
        if (file_exists($legacyPath) && is_file($legacyPath)) {
            ActivityLogger::log('VIEW', 'Layanan PPKS', "Mengakses berkas bukti lama laporan #{$laporan->kode_tiket}");

            if ($request->query('view') === '1') {
                return response()->file($legacyPath);
            }
            return response()->download($legacyPath);
        }

        abort(404, 'File berkas bukti tidak ditemukan di server.');
    }

    /**
     * Ekspor Laporan Rekapitulasi PPKS ke format PDF
     */
    public function exportRekapPdf(Request $request)
    {
        $status = $request->status;
        $search = $request->search;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

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

        $periodeText = 'Semua Data';
        if ($startDate && $endDate) {
            $query->whereDate('created_at', '>=', $startDate)
                  ->whereDate('created_at', '<=', $endDate);
            $periodeText = Carbon::parse($startDate)->format('d/m/Y') . ' s/d ' . Carbon::parse($endDate)->format('d/m/Y');
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
            $periodeText = 'Mulai ' . Carbon::parse($startDate)->format('d/m/Y');
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
            $periodeText = 'Hingga ' . Carbon::parse($endDate)->format('d/m/Y');
        }

        $items = $query->get();
        $setting = Setting::first();
        $logoBase64 = $this->getLogoBase64();
        $statusFilter = $status;

        ActivityLogger::log('EXPORT', 'Layanan PPKS', "Mengekspor laporan rekapitulasi PPKS ke PDF ({$items->count()} data)");

        $pdf = Pdf::loadView('admin.ppks.pdf_rekap', compact(
            'items', 'setting', 'logoBase64', 'periodeText', 'statusFilter'
        ))->setPaper('a4', 'landscape')
          ->setOptions([
              'isHtml5ParserEnabled' => true,
              'isRemoteEnabled' => true,
              'defaultFont' => 'sans-serif',
          ]);

        $filename = 'Rekap_Laporan_PPKS_' . date('Ymd_His') . '.pdf';

        if ($request->query('download') === '1') {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }

    /**
     * Ekspor Lembar Berita Acara / Laporan Kasus Individual PPKS ke format PDF
     */
    public function exportDetailPdf($id)
    {
        $laporan = PPKSLaporan::findOrFail($id);
        $setting = Setting::first();
        $logoBase64 = $this->getLogoBase64();

        ActivityLogger::log('EXPORT', 'Layanan PPKS', "Mengekspor berita acara laporan PPKS #{$laporan->kode_tiket} ke PDF");

        $pdf = Pdf::loadView('admin.ppks.pdf_detail', compact(
            'laporan', 'setting', 'logoBase64'
        ))->setPaper('a4', 'portrait')
          ->setOptions([
              'isHtml5ParserEnabled' => true,
              'isRemoteEnabled' => true,
              'defaultFont' => 'sans-serif',
          ]);

        $filename = 'Berita_Acara_PPKS_' . $laporan->kode_tiket . '.pdf';

        if (request()->query('download') === '1') {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }

    /**
     * Konversi logo resmi institusi ke base64 agar aman dan cepat dimuat di DomPDF
     */
    private function getLogoBase64(): ?string
    {
        $setting = Setting::first();
        if ($setting && $setting->logo) {
            $possiblePaths = [
                public_path('uploads/' . $setting->logo),
                public_path($setting->logo),
            ];
            foreach ($possiblePaths as $path) {
                if (file_exists($path) && is_file($path)) {
                    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                    $mime = match ($ext) {
                        'jpg', 'jpeg' => 'image/jpeg',
                        'png' => 'image/png',
                        'webp' => 'image/webp',
                        'gif' => 'image/gif',
                        'svg' => 'image/svg+xml',
                        default => 'image/jpeg',
                    };
                    $data = file_get_contents($path);
                    return 'data:' . $mime . ';base64,' . base64_encode($data);
                }
            }
        }

        if (file_exists(public_path('logo.png'))) {
            $data = file_get_contents(public_path('logo.png'));
            return 'data:image/png;base64,' . base64_encode($data);
        }

        return null;
    }
}
