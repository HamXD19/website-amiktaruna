<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Kategori;
use App\Http\Controllers\KategoriController;
use App\Services\ImageOptimizer;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DosenController extends Controller
{
    private function getJabatanList()
    {
        KategoriController::seedJabatanDefaults();

        $fromDb = Kategori::where('modul', 'jabatan')
            ->where('is_active', true)
            ->orderBy('urutan')
            ->pluck('nama')
            ->toArray();

        // Also harvest any existing jabatan assigned to dosens
        $fromDosens = [];
        foreach (Dosen::whereNotNull('jabatan')->pluck('jabatan') as $jString) {
            foreach (explode('|', $jString) as $item) {
                $item = trim($item);
                if (!empty($item)) {
                    $fromDosens[] = $item;
                }
            }
        }

        return array_values(array_unique(array_merge($fromDb, $fromDosens)));
    }

    private function syncNewJabatan(array $jabatanArray)
    {
        foreach ($jabatanArray as $jName) {
            $jName = trim($jName);
            if (!empty($jName)) {
                $exists = Kategori::where('nama', $jName)->where('modul', 'jabatan')->exists();
                if (!$exists) {
                    $maxUrutan = Kategori::where('modul', 'jabatan')->max('urutan') ?? 20;
                    Kategori::create([
                        'nama' => $jName,
                        'slug' => Str::slug($jName) ?: 'jabatan-' . time(),
                        'modul' => 'jabatan',
                        'warna' => 'primary',
                        'ikon' => '👔',
                        'keterangan' => 'Jabatan Dosen & Sivitas Akademika',
                        'urutan' => $maxUrutan + 1,
                        'is_active' => true,
                    ]);
                }
            }
        }
    }

    private function getOrganigramLevels()
    {
        Kategori::seedOrganigramDefaults();
        return Kategori::where('modul', 'organigram')
            ->where('is_active', true)
            ->orderBy('level_organigram')
            ->orderBy('urutan')
            ->get();
    }

    public function index()
    {
        $dosen = Dosen::orderBy('level_organigram')->orderBy('nama')->get();
        $jabatanList = $this->getJabatanList();
        $organigramLevels = $this->getOrganigramLevels();

        return view('admin.dosen.index', compact('dosen', 'jabatanList', 'organigramLevels'));
    }

    /*
    |------------------------------------------
    | STORE
    |------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'nama'             => 'required|string|max:255',
            'jabatan'          => 'required|array',
            'level_organigram' => 'nullable|integer|min:1|max:99',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120'
        ]);

        $this->syncNewJabatan($request->jabatan);

        $foto = null;

        // =========================
        // UPLOAD & AUTO COMPRESS FOTO
        // =========================
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $namaFile = time().'_'.$file->getClientOriginalName();
            $destPath = public_path('uploads/' . $namaFile);

            $file->move(public_path('uploads'), $namaFile);
            ImageOptimizer::optimize($destPath, null, 800, 1000, 82);

            $foto = $namaFile;
        }

        Dosen::create([
            'nama'             => $request->nama,
            'jabatan'          => implode('|', $request->jabatan),
            'level_organigram' => $request->level_organigram ?? 6,
            'foto'             => $foto
        ]);

        ActivityLogger::log('CREATE', 'Dosen', "Menambahkan data dosen baru: {$request->nama}");

        return back()->with(
            'success',
            'Data dosen berhasil ditambahkan'
        );
    }

    /*
    |------------------------------------------
    | EDIT
    |------------------------------------------
    */
    public function edit($id)
    {
        $dosen = Dosen::findOrFail($id);
        $jabatanList = $this->getJabatanList();
        $organigramLevels = $this->getOrganigramLevels();

        return view('admin.dosen_edit', compact('dosen', 'jabatanList', 'organigramLevels'));
    }

    /*
    |------------------------------------------
    | UPDATE
    |------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'             => 'required|string|max:255',
            'jabatan'          => 'required|array',
            'level_organigram' => 'nullable|integer|min:1|max:99',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120'
        ]);

        $this->syncNewJabatan($request->jabatan);

        $dosen = Dosen::findOrFail($id);

        $dosen->nama = $request->nama;
        $dosen->jabatan = implode('|', $request->jabatan);
        if ($request->has('level_organigram')) {
            $dosen->level_organigram = $request->level_organigram;
        }

        // =========================
        // UPDATE & AUTO COMPRESS FOTO
        // =========================
        if ($request->hasFile('foto')) {

            // hapus file lama
            if (
                $dosen->foto &&
                file_exists(public_path('uploads/'.$dosen->foto))
            ) {
                unlink(public_path('uploads/'.$dosen->foto));
            }

            $file = $request->file('foto');
            $namaFile = time().'_'.$file->getClientOriginalName();
            $destPath = public_path('uploads/' . $namaFile);

            $file->move(public_path('uploads'), $namaFile);
            ImageOptimizer::optimize($destPath, null, 800, 1000, 82);

            $dosen->foto = $namaFile;
        }

        $dosen->save();

        ActivityLogger::log('UPDATE', 'Dosen', "Memperbarui data dosen: {$dosen->nama}");

        return redirect('/admin/dosen')
            ->with('success', 'Berhasil update data dosen');
    }

    /*
    |------------------------------------------
    | DELETE
    |------------------------------------------
    */
    public function destroy(Dosen $dosen)
    {
        $namaDosen = $dosen->nama;

        if (
            $dosen->foto &&
            file_exists(public_path('uploads/'.$dosen->foto))
        ) {
            unlink(public_path('uploads/'.$dosen->foto));
        }

        $dosen->delete();

        ActivityLogger::log('DELETE', 'Dosen', "Menghapus data dosen: {$namaDosen}");

        return back()->with(
            'success',
            'Data dosen berhasil dihapus'
        );
    }

    public function show($id)
{
    $dosen = Dosen::findOrFail($id);

    return view('dosen.show', compact('dosen'));
}

public function profilIndex()
{
    $dosen = Dosen::all();

    return view('admin.dosen.profil-index', compact('dosen'));
}

public function profilEdit($id)
{
    $dosen = Dosen::findOrFail($id);

    return view('admin.dosen.profil-edit', compact('dosen'));
}

public function profilUpdate(Request $request,$id)
{
    $dosen = Dosen::findOrFail($id);

    $request->validate([
        'bio'=>'nullable',
        'nidn'=>'nullable',
        'email'=>'nullable',
        'pendidikan'=>'nullable',
        'bidang_keahlian'=>'nullable',
        'linkedin'=>'nullable'
    ]);

    $dosen->update([

        'bio'=>$request->bio,
        'nidn'=>$request->nidn,
        'email'=>$request->email,
        'pendidikan'=>$request->pendidikan,
        'bidang_keahlian'=>$request->bidang_keahlian,
        'linkedin'=>$request->linkedin,

    ]);

    return redirect()
        ->route('admin.profil.dosen')
        ->with('success','Profil dosen berhasil diupdate.');
}
}