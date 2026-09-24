<?php

namespace App\Http\Controllers;

use App\Models\Akreditasi;
use Illuminate\Http\Request;

class AkreditasiController extends Controller
{
    /*
    |------------------------------------------
    | INDEX ADMIN
    |------------------------------------------
    */
    public function index()
    {
        $data = Akreditasi::latest()->get();
        return view('admin.akreditasi.index', compact('data'));
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
            'tahun'      => 'required',
            'peringkat'  => 'required',
            'deskripsi'  => 'nullable',
            'gambar'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active'  => 'required'
        ]);

        $data = [
            'judul'      => $request->judul,
            'tahun'      => $request->tahun,
            'peringkat'  => $request->peringkat,
            'deskripsi'  => $request->deskripsi,
            'is_active'  => $request->is_active,
        ];

        // =========================
        // UPLOAD (FINAL HOSTING SAFE)
        // =========================
        if ($request->hasFile('gambar')) {

            $file = $request->file('gambar');

            $namaFile = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('uploads'), $namaFile);

            $data['gambar'] = $namaFile;
        }

        Akreditasi::create($data);

        return back()->with('success', 'Data akreditasi berhasil ditambahkan');
    }

    /*
    |------------------------------------------
    | EDIT
    |------------------------------------------
    */
    public function edit($id)
    {
        $edit = Akreditasi::findOrFail($id);
        return view('admin.akreditasi.edit', compact('edit'));
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
            'tahun'      => 'required',
            'peringkat'  => 'required',
            'deskripsi'  => 'nullable',
            'gambar'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_active'  => 'required'
        ]);

        $akreditasi = Akreditasi::findOrFail($id);

        $data = [
            'judul'      => $request->judul,
            'tahun'      => $request->tahun,
            'peringkat'  => $request->peringkat,
            'deskripsi'  => $request->deskripsi,
            'is_active'  => $request->is_active,
        ];

        // =========================
        // UPDATE GAMBAR (HOSTING SAFE)
        // =========================
        if ($request->hasFile('gambar')) {

            // hapus file lama
            if ($akreditasi->gambar && file_exists(public_path('uploads/'.$akreditasi->gambar))) {
                unlink(public_path('uploads/'.$akreditasi->gambar));
            }

            $file = $request->file('gambar');

            $namaFile = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('uploads'), $namaFile);

            $data['gambar'] = $namaFile;

        } else {

            $data['gambar'] = $akreditasi->gambar;
        }

        $akreditasi->update($data);

        return redirect('/admin/akreditasi')
            ->with('success', 'Data akreditasi berhasil diupdate');
    }

    /*
    |------------------------------------------
    | DELETE
    |------------------------------------------
    */
    public function destroy($id)
    {
        $akreditasi = Akreditasi::findOrFail($id);

        // hapus file gambar
        if ($akreditasi->gambar && file_exists(public_path('uploads/'.$akreditasi->gambar))) {
            unlink(public_path('uploads/'.$akreditasi->gambar));
        }

        $akreditasi->delete();

        return back()->with('success', 'Data akreditasi berhasil dihapus');
    }
}