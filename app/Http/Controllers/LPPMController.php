<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\LPPM;
use App\Models\LPPMPortal;
use App\Models\LPPMDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LPPMController extends Controller
{
    private function autoSeedPortals($lppm)
    {
        if (LPPMPortal::count() === 0) {
            LPPMPortal::create([
                'nama' => 'JESICA',
                'link' => $lppm?->jesica_link ?: 'https://jessica.amiktaruna.ac.id/',
                'logo' => $lppm?->jesica_image ?: null,
                'warna' => 'success',
                'deskripsi' => 'Jurnal Elektronik Sistem Informasi dan Komputer Terapan AMIK Taruna Probolinggo.',
                'urutan' => 1,
            ]);

            LPPMPortal::create([
                'nama' => 'Pengajuan Proposal PPM',
                'link' => $lppm?->penelitian_link ?: 'https://pengajuanproposalppm.amiktaruna.ac.id/',
                'logo' => $lppm?->penelitian_image ?: null,
                'warna' => 'primary',
                'deskripsi' => 'Sistem Informasi Pengajuan Proposal Penelitian dan Pengabdian kepada Masyarakat.',
                'urutan' => 2,
            ]);
        }
    }

    private function autoSeedDokumen()
    {
        if (Kategori::where('modul', 'lppm_dokumen')->count() === 0) {
            $lppmDefaults = [
                ['nama' => 'Panduan Penelitian', 'slug' => 'panduan-penelitian', 'modul' => 'lppm_dokumen', 'warna' => 'primary', 'ikon' => '🔬', 'keterangan' => 'Buku panduan hibah riset dan penelitian dosen/mahasiswa', 'urutan' => 1, 'is_active' => true],
                ['nama' => 'Pedoman Pengabdian', 'slug' => 'pedoman-pengabdian', 'modul' => 'lppm_dokumen', 'warna' => 'success', 'ikon' => '🤝', 'keterangan' => 'Pedoman pelaksanaan program pengabdian kepada masyarakat (PkM)', 'urutan' => 2, 'is_active' => true],
                ['nama' => 'Template Proposal & Laporan', 'slug' => 'template-lppm', 'modul' => 'lppm_dokumen', 'warna' => 'warning', 'ikon' => '📋', 'keterangan' => 'Format template proposal dan laporan kemajuan/akhir riset', 'urutan' => 3, 'is_active' => true],
                ['nama' => 'Publikasi & Jurnal Ilmiah', 'slug' => 'jurnal-lppm', 'modul' => 'lppm_dokumen', 'warna' => 'info', 'ikon' => '📚', 'keterangan' => 'Panduan penulisan jurnal, prosiding, dan luaran publikasi', 'urutan' => 4, 'is_active' => true],
            ];
            foreach ($lppmDefaults as $ld) {
                if (!Kategori::where('slug', $ld['slug'])->exists()) {
                    Kategori::create($ld);
                }
            }
        }
    }

    public function index()
    {
        $lppm = LPPM::first();
        $this->autoSeedPortals($lppm);
        $this->autoSeedDokumen();

        $portals   = LPPMPortal::orderBy('urutan', 'asc')->latest()->get();
        $kategoris = Kategori::forModul('lppm_dokumen')->active()->orderBy('urutan')->get();
        $dokumens  = LPPMDokumen::with('kategoriModel')->where('is_active', true)->orderBy('urutan', 'asc')->latest()->get();

        return view('lppm.index', compact('lppm', 'portals', 'kategoris', 'dokumens'));
    }

    public function admin()
    {
        $lppm = LPPM::first();
        $this->autoSeedPortals($lppm);
        $this->autoSeedDokumen();

        $portals   = LPPMPortal::orderBy('urutan', 'asc')->latest()->get();
        $kategoris = Kategori::forModul('lppm_dokumen')->active()->orderBy('urutan')->get();
        $dokumens  = LPPMDokumen::with('kategoriModel')->orderBy('urutan', 'asc')->latest()->get();

        return view('admin.lppm.index', compact('lppm', 'portals', 'kategoris', 'dokumens'));
    }

    public function store(Request $request)
    {
        $lppm = LPPM::first() ?? new LPPM();

        $lppm->deskripsi = $request->deskripsi;
        $lppm->jesica_link = $request->jesica_link;
        $lppm->penelitian_link = $request->penelitian_link;

        if ($request->hasFile('jesica_image')) {
            $file = $request->file('jesica_image');
            $name = time().'_jesica.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/lppm'), $name);
            $lppm->jesica_image = $name;
        }

        if ($request->hasFile('penelitian_image')) {
            $file = $request->file('penelitian_image');
            $name = time().'_penelitian.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/lppm'), $name);
            $lppm->penelitian_image = $name;
        }

        $lppm->save();

        return back()->with('success', 'Deskripsi LPPM berhasil disimpan');
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
            $namaFile = time().'_portal_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/lppm'), $namaFile);
            $logo = $namaFile;
        }

        LPPMPortal::create([
            'nama' => $request->nama,
            'link' => $request->link,
            'logo' => $logo,
            'warna' => $request->warna ?? 'success',
            'deskripsi' => $request->deskripsi,
            'urutan' => $request->urutan ?? 0,
        ]);

        return back()->with('success', 'Portal LPPM berhasil ditambahkan');
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

        $portal = LPPMPortal::findOrFail($id);

        if ($request->hasFile('logo')) {
            if ($portal->logo && file_exists(public_path('uploads/lppm/'.$portal->logo))) {
                @unlink(public_path('uploads/lppm/'.$portal->logo));
            }
            $file = $request->file('logo');
            $namaFile = time().'_portal_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/lppm'), $namaFile);
            $portal->logo = $namaFile;
        }

        $portal->nama = $request->nama;
        $portal->link = $request->link;
        $portal->warna = $request->warna ?? 'success';
        $portal->deskripsi = $request->deskripsi;
        $portal->urutan = $request->urutan ?? 0;
        $portal->save();

        return back()->with('success', 'Portal LPPM berhasil diperbarui');
    }

    public function destroyPortal($id)
    {
        $portal = LPPMPortal::findOrFail($id);

        if ($portal->logo && file_exists(public_path('uploads/lppm/'.$portal->logo))) {
            @unlink(public_path('uploads/lppm/'.$portal->logo));
        }

        $portal->delete();

        return back()->with('success', 'Portal LPPM berhasil dihapus');
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

        $uploadDir = public_path('uploads/lppm/dokumen');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $docFile = $request->file('file_pdf');
        $originalName = pathinfo($docFile->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $docFile->getClientOriginalExtension();
        $safeName = Str::slug($originalName);
        $fileName = time() . '_' . ($safeName ?: 'dokumen') . '.' . $extension;
        $docFile->move($uploadDir, $fileName);

        LPPMDokumen::create([
            'nama_dokumen' => $request->nama_dokumen,
            'kategori'     => $request->kategori,
            'file_pdf'     => $fileName,
            'deskripsi'    => $request->deskripsi,
            'tahun'        => $request->tahun,
            'urutan'       => $request->urutan ?: 0,
            'is_active'    => true,
        ]);

        return redirect()->route('admin.lppm', ['tab' => 'dokumen'])
            ->with('success', "Dokumen '{$request->nama_dokumen}' berhasil ditambahkan ke daftar dokumen riset & pengabdian!");
    }

    public function updateDokumen(Request $request, $id)
    {
        $dokumen = LPPMDokumen::findOrFail($id);

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

        $uploadDir = public_path('uploads/lppm/dokumen');
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if ($request->hasFile('file_pdf')) {
            if ($dokumen->file_pdf) {
                $oldPath = $uploadDir . '/' . $dokumen->file_pdf;
                if (file_exists($oldPath) && is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $docFile = $request->file('file_pdf');
            $originalName = pathinfo($docFile->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $docFile->getClientOriginalExtension();
            $safeName = Str::slug($originalName);
            $fileName = time() . '_' . ($safeName ?: 'dokumen') . '.' . $extension;
            $docFile->move($uploadDir, $fileName);
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

        return redirect()->route('admin.lppm', ['tab' => 'dokumen'])
            ->with('success', "Dokumen '{$dokumen->nama_dokumen}' berhasil diperbarui!");
    }

    public function destroyDokumen($id)
    {
        $dokumen = LPPMDokumen::findOrFail($id);
        $nama = $dokumen->nama_dokumen;
        $fileName = $dokumen->file_pdf;

        if ($fileName) {
            $filePath = public_path('uploads/lppm/dokumen/' . $fileName);
            if (file_exists($filePath) && is_file($filePath)) {
                @unlink($filePath);
            }
        }

        $dokumen->delete();

        return redirect()->route('admin.lppm', ['tab' => 'dokumen'])
            ->with('success', "Dokumen '{$nama}' dan file di server berhasil dihapus.");
    }
}