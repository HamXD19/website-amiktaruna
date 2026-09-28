<?php

namespace App\Http\Controllers;

use App\Models\AlumniSection;
use App\Models\AlumniTestimoni;
use Illuminate\Http\Request;

class AlumniSectionController extends Controller
{
    /*
    |------------------------------------------
    | FRONTEND USER
    |------------------------------------------
    */
    public function alumni()
    {
        $data = AlumniSection::where('is_active', 1)
            ->latest()
            ->get();

        $testimonis = AlumniTestimoni::active()
            ->orderBy('urutan')
            ->latest()
            ->get();

        return view('alumni', compact('data', 'testimonis'));
    }

    /*
    |------------------------------------------
    | ADMIN INDEX
    |------------------------------------------
    */
    public function index()
    {
        $data = AlumniSection::latest()->get();
        $testimonis = AlumniTestimoni::orderBy('urutan')->latest()->get();

        return view('admin.alumni_section.index', compact('data', 'testimonis'));
    }

    /*
    |------------------------------------------
    | STORE
    |------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'judul'      => 'required',
            'deskripsi'  => 'required',
            'type'       => 'required',
            'layout'     => 'required',
            'link'       => 'nullable',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active'  => 'required'
        ]);

        $data = [
            'judul'      => $request->judul,
            'deskripsi'  => $request->deskripsi,
            'type'       => $request->type,
            'layout'     => $request->layout,
            'link'       => $request->link,
            'is_active'  => $request->is_active,
        ];

        // =========================
        // UPLOAD IMAGE (HOSTING SAFE)
        // =========================
        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $namaFile = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('uploads'), $namaFile);

            $data['image'] = $namaFile;
        }

        AlumniSection::create($data);

        return redirect('/admin/alumni-section')
            ->with('success', 'Data berhasil ditambahkan');
    }

    /*
    |------------------------------------------
    | EDIT
    |------------------------------------------
    */
    public function edit($id)
    {
        $edit = AlumniSection::findOrFail($id);

        return view('admin.alumni_section.edit', compact('edit'));
    }

    /*
    |------------------------------------------
    | UPDATE
    |------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'      => 'required',
            'deskripsi'  => 'required',
            'type'       => 'required',
            'layout'     => 'required',
            'link'       => 'nullable',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active'  => 'required'
        ]);

        $alumni = AlumniSection::findOrFail($id);

        $data = [
            'judul'      => $request->judul,
            'deskripsi'  => $request->deskripsi,
            'type'       => $request->type,
            'layout'     => $request->layout,
            'link'       => $request->link,
            'is_active'  => $request->is_active,
        ];

        // =========================
        // UPDATE IMAGE (HOSTING SAFE)
        // =========================
        if ($request->hasFile('image')) {

            // hapus file lama
            if ($alumni->image && file_exists(public_path('uploads/'.$alumni->image))) {
                unlink(public_path('uploads/'.$alumni->image));
            }

            $file = $request->file('image');

            $namaFile = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('uploads'), $namaFile);

            $data['image'] = $namaFile;

        } else {

            $data['image'] = $alumni->image;
        }

        $alumni->update($data);

        return redirect('/admin/alumni-section')
            ->with('success', 'Data berhasil diupdate');
    }

    /*
    |------------------------------------------
    | DELETE
    |------------------------------------------
    */
    public function destroy($id)
    {
        $alumni = AlumniSection::findOrFail($id);

        // hapus file image
        if ($alumni->image && file_exists(public_path('uploads/'.$alumni->image))) {
            unlink(public_path('uploads/'.$alumni->image));
        }

        $alumni->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }

    /*
    |------------------------------------------
    | STORE TESTIMONI
    |------------------------------------------
    */
    public function storeTestimoni(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'program_studi' => 'nullable|string|max:255',
            'tahun_lulus'   => 'nullable|string|max:20',
            'pekerjaan'     => 'nullable|string|max:255',
            'perusahaan'    => 'nullable|string|max:255',
            'testimoni'     => 'required|string',
            'rating'        => 'nullable|integer|min:1|max:5',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'     => 'required',
            'urutan'        => 'nullable|integer',
        ]);

        $data = [
            'nama'          => $request->nama,
            'program_studi' => $request->program_studi,
            'tahun_lulus'   => $request->tahun_lulus,
            'pekerjaan'     => $request->pekerjaan,
            'perusahaan'    => $request->perusahaan,
            'testimoni'     => $request->testimoni,
            'rating'        => $request->rating ?? 5,
            'is_active'     => (bool) $request->is_active,
            'urutan'        => $request->urutan ?? 0,
        ];

        if ($request->hasFile('foto')) {
            $uploadDir = public_path('uploads/alumni');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $file = $request->file('foto');
            $namaFile = time().'_testimoni_'.$file->getClientOriginalName();
            $file->move($uploadDir, $namaFile);
            $data['foto'] = 'alumni/'.$namaFile;
        }

        AlumniTestimoni::create($data);

        return redirect('/admin/alumni-section?tab=testimoni')
            ->with('success', 'Testimoni alumni berhasil ditambahkan.');
    }

    /*
    |------------------------------------------
    | UPDATE TESTIMONI
    |------------------------------------------
    */
    public function updateTestimoni(Request $request, $id)
    {
        $testimoni = AlumniTestimoni::findOrFail($id);

        $request->validate([
            'nama'          => 'required|string|max:255',
            'program_studi' => 'nullable|string|max:255',
            'tahun_lulus'   => 'nullable|string|max:20',
            'pekerjaan'     => 'nullable|string|max:255',
            'perusahaan'    => 'nullable|string|max:255',
            'testimoni'     => 'required|string',
            'rating'        => 'nullable|integer|min:1|max:5',
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'     => 'required',
            'urutan'        => 'nullable|integer',
        ]);

        $data = [
            'nama'          => $request->nama,
            'program_studi' => $request->program_studi,
            'tahun_lulus'   => $request->tahun_lulus,
            'pekerjaan'     => $request->pekerjaan,
            'perusahaan'    => $request->perusahaan,
            'testimoni'     => $request->testimoni,
            'rating'        => $request->rating ?? 5,
            'is_active'     => (bool) $request->is_active,
            'urutan'        => $request->urutan ?? 0,
        ];

        if ($request->hasFile('foto')) {
            if ($testimoni->foto && file_exists(public_path('uploads/'.$testimoni->foto))) {
                @unlink(public_path('uploads/'.$testimoni->foto));
            }

            $uploadDir = public_path('uploads/alumni');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $file = $request->file('foto');
            $namaFile = time().'_testimoni_'.$file->getClientOriginalName();
            $file->move($uploadDir, $namaFile);
            $data['foto'] = 'alumni/'.$namaFile;
        }

        $testimoni->update($data);

        return redirect('/admin/alumni-section?tab=testimoni')
            ->with('success', 'Testimoni alumni berhasil diperbarui.');
    }

    /*
    |------------------------------------------
    | DESTROY TESTIMONI
    |------------------------------------------
    */
    public function destroyTestimoni($id)
    {
        $testimoni = AlumniTestimoni::findOrFail($id);

        if ($testimoni->foto && file_exists(public_path('uploads/'.$testimoni->foto))) {
            @unlink(public_path('uploads/'.$testimoni->foto));
        }

        $testimoni->delete();

        return redirect('/admin/alumni-section?tab=testimoni')
            ->with('success', 'Testimoni alumni berhasil dihapus.');
    }
}