<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\PPM;
use App\Models\PPMDokumen;
use App\Models\PPMPortal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PPMController extends Controller
{
    private function autoSeedPortals($ppm)
    {
        if (PPMPortal::count() === 0) {
            PPMPortal::create([
                'nama' => $ppm?->nama_portal ?: 'Portal SPMI Kemdikbud',
                'link' => $ppm?->link_portal ?: 'https://spmi.kemdikbud.go.id/',
                'logo' => $ppm?->gambar ?: null,
                'warna' => 'success',
                'deskripsi' => 'Portal resmi pelaporan dan evaluasi standar Sistem Penjaminan Mutu Internal perguruan tinggi.',
                'urutan' => 1,
            ]);

            PPMPortal::create([
                'nama' => 'Pangkalan Data PDDIKTI',
                'link' => 'https://pddikti.kemdiktisaintek.go.id/',
                'logo' => null,
                'warna' => 'primary',
                'deskripsi' => 'Layanan pemantauan integritas data akademik dan kepatuhan pelaporan institusi secara nasional.',
                'urutan' => 2,
            ]);
        }
    }

    private function autoSeedDokumen($ppm)
    {
        // 1. Pastikan kategori default dokumen SPMI ada di Master Kategori
        $defaultCategories = [
            [
                'nama' => 'Standar Mutu SPMI',
                'slug' => 'spmi-mutu',
                'modul' => 'dokumen',
                'warna' => 'primary',
                'ikon' => '📜',
                'keterangan' => 'Dokumen standar mutu dan audit internal perguruan tinggi',
                'urutan' => 1,
            ],
            [
                'nama' => 'Kebijakan & SK Mutu',
                'slug' => 'kebijakan-sk',
                'modul' => 'dokumen',
                'warna' => 'danger',
                'ikon' => '⚖️',
                'keterangan' => 'SK Direktur, ketetapan, dan kebijakan penjaminan mutu',
                'urutan' => 2,
            ],
            [
                'nama' => 'Manual & SOP Mutu',
                'slug' => 'manual-sop',
                'modul' => 'dokumen',
                'warna' => 'warning',
                'ikon' => '📋',
                'keterangan' => 'Manual prosedur operasional standar SPMI',
                'urutan' => 3,
            ],
            [
                'nama' => 'Laporan AMI & Evaluasi',
                'slug' => 'laporan-ami',
                'modul' => 'dokumen',
                'warna' => 'success',
                'ikon' => '📊',
                'keterangan' => 'Hasil audit mutu internal dan laporan kepatuhan standar',
                'urutan' => 4,
            ],
        ];

        foreach ($defaultCategories as $dc) {
            if (!Kategori::where('slug', $dc['slug'])->exists()) {
                Kategori::create($dc);
            }
        }
    }

    public function index(Request $request)
    {
        $ppm = PPM::first();
        $this->autoSeedDokumen($ppm);
        $this->autoSeedPortals($ppm);

        $kategoris = Kategori::forModul('dokumen')->active()->orderBy('urutan')->get();

        // Ambil semua dokumen aktif untuk filter client-side tanpa reload dan tanpa loncat scroll
        $dokumens = PPMDokumen::with('kategoriModel')
            ->where('is_active', true)
            ->orderBy('urutan', 'asc')
            ->latest()
            ->get();
        $portals = PPMPortal::orderBy('urutan', 'asc')->latest()->get();

        return view('ppm.index', compact('ppm', 'kategoris', 'dokumens', 'portals'));
    }

    public function admin()
    {
        $ppm = PPM::first();
        $this->autoSeedDokumen($ppm);
        $this->autoSeedPortals($ppm);

        $kategoris = Kategori::forModul('dokumen')->active()->orderBy('urutan')->get();
        $dokumens  = PPMDokumen::with('kategoriModel')->orderBy('urutan', 'asc')->latest()->get();
        $portals   = PPMPortal::orderBy('urutan', 'asc')->latest()->get();

        return view('admin.ppm.index', compact('ppm', 'kategoris', 'dokumens', 'portals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'deskripsi'   => 'nullable|string',
            'nama_portal' => 'nullable|string|max:255',
            'link_portal' => 'nullable|string|max:500',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ], [
            'gambar.image' => 'File gambar harus berupa gambar yang valid (JPG, PNG, WEBP).',
            'gambar.max'   => 'Ukuran thumbnail gambar maksimal adalah 4MB.',
        ]);

        $ppm = PPM::first() ?? new PPM();

        $ppm->deskripsi   = $request->deskripsi;
        $ppm->nama_portal = $request->nama_portal;
        $ppm->link_portal = $request->link_portal;

        // Upload Thumbnail Gambar
        if ($request->hasFile('gambar')) {
            if ($ppm->gambar && file_exists(public_path('uploads/ppm/' . $ppm->gambar))) {
                @unlink(public_path('uploads/ppm/' . $ppm->gambar));
            }

            $file = $request->file('gambar');
            $name = time() . '_thumb.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/ppm'), $name);
            $ppm->gambar = $name;
        }

        $ppm->save();

        return back()->with('success', 'Profil dan Portal Penjaminan Mutu berhasil disimpan!');
    }

    public function storeDokumen(Request $request)
    {
        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'kategori'     => 'required|string|max:100',
            'file_pdf'     => 'required|file|mimes:pdf,doc,docx|max:30720',
            'deskripsi'    => 'nullable|string|max:1000',
            'tahun'        => 'nullable|string|max:50',
            'urutan'       => 'nullable|integer',
        ], [
            'nama_dokumen.required' => 'Judul / nama dokumen wajib diisi.',
            'kategori.required'     => 'Pilih kategori dokumen dari Master Kategori.',
            'file_pdf.required'     => 'File dokumen (PDF, DOC, atau DOCX) wajib diunggah.',
            'file_pdf.mimes'        => 'Format dokumen harus berekstensi: PDF, DOC, atau DOCX.',
            'file_pdf.max'          => 'Ukuran file dokumen maksimal 30MB.',
        ]);

        $docFile = $request->file('file_pdf');
        $originalName = pathinfo($docFile->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $docFile->getClientOriginalExtension();
        $safeName = Str::slug($originalName);
        $fileName = time() . '_' . ($safeName ?: 'dokumen') . '.' . $extension;
        $docFile->move(public_path('uploads/ppm'), $fileName);

        PPMDokumen::create([
            'nama_dokumen' => $request->nama_dokumen,
            'kategori'     => $request->kategori,
            'file_pdf'     => $fileName,
            'deskripsi'    => $request->deskripsi,
            'tahun'        => $request->tahun,
            'urutan'       => $request->urutan ?: 0,
            'is_active'    => true,
        ]);

        return back()->with('success', "Dokumen '{$request->nama_dokumen}' berhasil ditambahkan ke daftar dokumen mutu!");
    }

    public function updateDokumen(Request $request, $id)
    {
        $dokumen = PPMDokumen::findOrFail($id);

        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'kategori'     => 'required|string|max:100',
            'file_pdf'     => 'nullable|file|mimes:pdf,doc,docx|max:30720',
            'deskripsi'    => 'nullable|string|max:1000',
            'tahun'        => 'nullable|string|max:50',
            'urutan'       => 'nullable|integer',
        ], [
            'nama_dokumen.required' => 'Judul / nama dokumen wajib diisi.',
            'kategori.required'     => 'Pilih kategori dokumen dari Master Kategori.',
            'file_pdf.mimes'        => 'Format dokumen harus berekstensi: PDF, DOC, atau DOCX.',
            'file_pdf.max'          => 'Ukuran file dokumen maksimal 30MB.',
        ]);

        if ($request->hasFile('file_pdf')) {
            // Hapus file lama jika ada
            if ($dokumen->file_pdf) {
                $oldPath = public_path('uploads/ppm/' . $dokumen->file_pdf);
                if (file_exists($oldPath) && is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $docFile = $request->file('file_pdf');
            $originalName = pathinfo($docFile->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $docFile->getClientOriginalExtension();
            $safeName = Str::slug($originalName);
            $fileName = time() . '_' . ($safeName ?: 'dokumen') . '.' . $extension;
            $docFile->move(public_path('uploads/ppm'), $fileName);
            $dokumen->file_pdf = $fileName;
        }

        $dokumen->nama_dokumen = $request->nama_dokumen;
        $dokumen->kategori     = $request->kategori;
        $dokumen->deskripsi    = $request->deskripsi;
        $dokumen->tahun        = $request->tahun;
        $dokumen->urutan       = $request->urutan ?: 0;
        if ($request->has('is_active')) {
            $dokumen->is_active = (bool) $request->is_active;
        }
        $dokumen->save();

        return back()->with('success', "Dokumen '{$dokumen->nama_dokumen}' berhasil diperbarui!");
    }

    public function destroyDokumen($id)
    {
        $dokumen = PPMDokumen::findOrFail($id);
        $nama = $dokumen->nama_dokumen;
        $fileName = $dokumen->file_pdf;

        // 1. Hapus file fisik dari folder public/uploads/ppm
        if ($fileName) {
            $filePath = public_path('uploads/ppm/' . $fileName);
            if (file_exists($filePath) && is_file($filePath)) {
                @unlink($filePath);
            }
        }

        // 2. Jika file ini masih tersimpan di kolom ppm lama, hapus juga agar tidak terduplikasi
        $ppm = PPM::first();
        if ($ppm && $ppm->file_pdf === $fileName) {
            $ppm->file_pdf = null;
            $ppm->nama_dokumen = null;
            $ppm->deskripsi_dokumen = null;
            $ppm->save();
        }

        $dokumen->delete();

        return back()->with('success', "Dokumen '{$nama}' dan file di server berhasil dihapus.");
    }

    public function storePortal(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'link' => 'required',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:5120',
            'deskripsi' => 'nullable|string',
            'warna' => 'nullable|string',
            'urutan' => 'nullable|integer',
        ]);

        $logo = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $namaFile = time().'_portal_ppm_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/ppm'), $namaFile);
            $logo = $namaFile;
        }

        PPMPortal::create([
            'nama' => $request->nama,
            'link' => $request->link,
            'logo' => $logo,
            'warna' => $request->warna ?? 'success',
            'deskripsi' => $request->deskripsi,
            'urutan' => $request->urutan ?? 0,
        ]);

        return redirect()->route('admin.ppm', ['tab' => 'portal'])
            ->with('success', 'Portal Layanan Mutu berhasil ditambahkan');
    }

    public function updatePortal(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'link' => 'required',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:5120',
            'deskripsi' => 'nullable|string',
            'warna' => 'nullable|string',
            'urutan' => 'nullable|integer',
        ]);

        $portal = PPMPortal::findOrFail($id);

        if ($request->hasFile('logo')) {
            if ($portal->logo && file_exists(public_path('uploads/ppm/'.$portal->logo))) {
                @unlink(public_path('uploads/ppm/'.$portal->logo));
            }
            $file = $request->file('logo');
            $namaFile = time().'_portal_ppm_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/ppm'), $namaFile);
            $portal->logo = $namaFile;
        }

        $portal->nama = $request->nama;
        $portal->link = $request->link;
        $portal->warna = $request->warna ?? 'success';
        $portal->deskripsi = $request->deskripsi;
        $portal->urutan = $request->urutan ?? 0;
        $portal->save();

        return redirect()->route('admin.ppm', ['tab' => 'portal'])
            ->with('success', 'Portal Layanan Mutu berhasil diperbarui');
    }

    public function destroyPortal($id)
    {
        $portal = PPMPortal::findOrFail($id);

        if ($portal->logo && file_exists(public_path('uploads/ppm/'.$portal->logo))) {
            @unlink(public_path('uploads/ppm/'.$portal->logo));
        }

        $portal->delete();

        return redirect()->route('admin.ppm', ['tab' => 'portal'])
            ->with('success', 'Portal Layanan Mutu berhasil dihapus');
    }
}