<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\ProgramStudi;
use App\Models\ProdiDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProdiDokumenController extends Controller
{
    public function index(Request $request, $program_studi_id)
    {
        $program = ProgramStudi::findOrFail($program_studi_id);

        $kategoris = Kategori::forModul('prodi_dokumen')->active()->orderBy('urutan', 'asc')->get();

        $query = ProdiDokumen::with('kategoriModel')
            ->where('program_studi_id', $program->id);

        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_dokumen', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('tahun', 'like', "%{$search}%");
            });
        }

        $dokumens = $query->orderBy('urutan', 'asc')->latest()->paginate(15)->withQueryString();

        // Statistik dokumen prodi ini
        $stats = [
            'total' => ProdiDokumen::where('program_studi_id', $program->id)->count(),
            'profil_lulusan' => ProdiDokumen::where('program_studi_id', $program->id)->where('kategori', 'profil-lulusan')->count(),
            'pedoman_akademik' => ProdiDokumen::where('program_studi_id', $program->id)->where('kategori', 'pedoman-akademik')->count(),
            'kurikulum' => ProdiDokumen::where('program_studi_id', $program->id)->where('kategori', 'kurikulum')->count(),
            'rps' => ProdiDokumen::where('program_studi_id', $program->id)->where('kategori', 'rps')->count(),
        ];

        return view('admin.prodi_dokumen.index', compact('program', 'dokumens', 'kategoris', 'stats'));
    }

    public function store(Request $request, $program_studi_id)
    {
        $program = ProgramStudi::findOrFail($program_studi_id);

        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx|max:30720',
            'deskripsi' => 'nullable|string',
            'tahun' => 'nullable|string|max:30',
            'urutan' => 'nullable|integer',
        ], [
            'file_dokumen.required' => 'File dokumen wajib diunggah.',
            'file_dokumen.mimes' => 'Format file wajib berupa PDF, DOC, atau DOCX.',
            'file_dokumen.max' => 'Ukuran file dokumen maksimal 30 MB.',
        ]);

        $fileName = null;
        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $targetDir = public_path('uploads/program_studi/dokumen');
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $cleanName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . $cleanName . '.' . $extension;

            $file->move($targetDir, $fileName);
        }

        ProdiDokumen::create([
            'program_studi_id' => $program->id,
            'nama_dokumen' => $request->nama_dokumen,
            'kategori' => $request->kategori,
            'file_dokumen' => $fileName,
            'deskripsi' => $request->deskripsi,
            'tahun' => $request->tahun,
            'urutan' => $request->urutan ?: 0,
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : true,
        ]);

        return redirect()->route('program-studi.dokumen.index', $program->id)
            ->with('success', "Dokumen akademik '{$request->nama_dokumen}' berhasil diunggah.");
    }

    public function update(Request $request, $id)
    {
        $dokumen = ProdiDokumen::findOrFail($id);

        $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx|max:30720',
            'deskripsi' => 'nullable|string',
            'tahun' => 'nullable|string|max:30',
            'urutan' => 'nullable|integer',
        ], [
            'file_dokumen.mimes' => 'Format file wajib berupa PDF, DOC, atau DOCX.',
            'file_dokumen.max' => 'Ukuran file dokumen maksimal 30 MB.',
        ]);

        $data = [
            'nama_dokumen' => $request->nama_dokumen,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'tahun' => $request->tahun,
            'urutan' => $request->urutan ?: 0,
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : false,
        ];

        if ($request->hasFile('file_dokumen')) {
            $targetDir = public_path('uploads/program_studi/dokumen');
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            // Hapus file lama jika ada
            if ($dokumen->file_dokumen) {
                $oldPath = $targetDir . '/' . $dokumen->file_dokumen;
                if (file_exists($oldPath) && is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $file = $request->file('file_dokumen');
            $cleanName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . $cleanName . '.' . $extension;

            $file->move($targetDir, $fileName);
            $data['file_dokumen'] = $fileName;
        }

        $dokumen->update($data);

        return redirect()->route('program-studi.dokumen.index', $dokumen->program_studi_id)
            ->with('success', "Dokumen '{$dokumen->nama_dokumen}' berhasil diperbarui.");
    }

    public function destroy($id)
    {
        $dokumen = ProdiDokumen::findOrFail($id);
        $program_studi_id = $dokumen->program_studi_id;
        $nama = $dokumen->nama_dokumen;

        // Model deleting hook also unlinks file, but explicit unlink here guarantees removal
        if ($dokumen->file_dokumen) {
            $filePath = public_path('uploads/program_studi/dokumen/' . $dokumen->file_dokumen);
            if (file_exists($filePath) && is_file($filePath)) {
                @unlink($filePath);
            }
        }

        $dokumen->delete();

        return redirect()->route('program-studi.dokumen.index', $program_studi_id)
            ->with('success', "Dokumen '{$nama}' dan file fisiknya berhasil dihapus dari server.");
    }
}
