<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\DokumenKampus;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DokumenKampusController extends Controller
{
    private function autoSeedDokumen()
    {
        // Pastikan kategori default dokumen kampus ada di Master Kategori
        $defaultCategories = [
            [
                'nama' => 'Statuta & Renstra Kampus',
                'slug' => 'statuta-renstra',
                'modul' => 'dokumen_kampus',
                'warna' => 'primary',
                'ikon' => '📜',
                'keterangan' => 'Statuta institusi, rencana strategis, dan rencana operasional kampus',
                'urutan' => 1,
            ],
            [
                'nama' => 'SK & Kebijakan Direktur',
                'slug' => 'sk-direktur',
                'modul' => 'dokumen_kampus',
                'warna' => 'danger',
                'ikon' => '⚖️',
                'keterangan' => 'Surat keputusan direktur dan ketetapan pimpinan perguruan tinggi',
                'urutan' => 2,
            ],
            [
                'nama' => 'Pedoman & Standar Pelayanan',
                'slug' => 'pedoman-standar',
                'modul' => 'dokumen_kampus',
                'warna' => 'warning',
                'ikon' => '📋',
                'keterangan' => 'Buku pedoman tata pamong, kode etik, dan standar pelayanan umum',
                'urutan' => 3,
            ],
            [
                'nama' => 'Laporan Tahunan & Kinerja',
                'slug' => 'laporan-tahunan',
                'modul' => 'dokumen_kampus',
                'warna' => 'success',
                'ikon' => '📊',
                'keterangan' => 'Laporan akuntabilitas tahunan dan capaian kinerja institusi',
                'urutan' => 4,
            ],
        ];

        foreach ($defaultCategories as $dc) {
            if (!Kategori::where('slug', $dc['slug'])->exists()) {
                Kategori::create(array_merge($dc, ['is_active' => true]));
            }
        }
    }

    public function index(Request $request)
    {
        $this->autoSeedDokumen();

        $kategoris = Kategori::forModul('dokumen_kampus')->active()->orderBy('urutan')->get();

        // Ambil semua dokumen aktif untuk filter client-side tanpa reload dan tanpa loncat scroll (persis PPM)
        $dokumens = DokumenKampus::with('kategoriModel')
            ->where('is_active', true)
            ->orderBy('urutan', 'asc')
            ->latest()
            ->get();

        $setting = Setting::first();

        return view('dokumen_kampus.index', compact('kategoris', 'dokumens', 'setting'));
    }

    public function admin()
    {
        $this->autoSeedDokumen();

        $kategoris = Kategori::forModul('dokumen_kampus')->active()->orderBy('urutan')->get();
        $dokumens  = DokumenKampus::with('kategoriModel')->orderBy('urutan', 'asc')->latest()->get();

        return view('admin.dokumen_kampus.index', compact('kategoris', 'dokumens'));
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
        $docFile->move(public_path('uploads/dokumen_kampus'), $fileName);

        DokumenKampus::create([
            'nama_dokumen' => $request->nama_dokumen,
            'kategori'     => $request->kategori,
            'file_pdf'     => $fileName,
            'deskripsi'    => $request->deskripsi,
            'tahun'        => $request->tahun,
            'urutan'       => $request->urutan ?: 0,
            'is_active'    => true,
        ]);

        return back()->with('success', "Dokumen kampus '{$request->nama_dokumen}' berhasil ditambahkan!");
    }

    public function updateDokumen(Request $request, $id)
    {
        $dokumen = DokumenKampus::findOrFail($id);

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
                $oldPath = public_path('uploads/dokumen_kampus/' . $dokumen->file_pdf);
                if (file_exists($oldPath) && is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $docFile = $request->file('file_pdf');
            $originalName = pathinfo($docFile->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $docFile->getClientOriginalExtension();
            $safeName = Str::slug($originalName);
            $fileName = time() . '_' . ($safeName ?: 'dokumen') . '.' . $extension;
            $docFile->move(public_path('uploads/dokumen_kampus'), $fileName);
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

        return back()->with('success', "Dokumen kampus '{$dokumen->nama_dokumen}' berhasil diperbarui!");
    }

    public function destroyDokumen($id)
    {
        $dokumen = DokumenKampus::findOrFail($id);
        $nama = $dokumen->nama_dokumen;
        $fileName = $dokumen->file_pdf;

        if ($fileName) {
            $filePath = public_path('uploads/dokumen_kampus/' . $fileName);
            if (file_exists($filePath) && is_file($filePath)) {
                @unlink($filePath);
            }
        }

        $dokumen->delete();

        return back()->with('success', "Dokumen '{$nama}' berhasil dihapus.");
    }
}
