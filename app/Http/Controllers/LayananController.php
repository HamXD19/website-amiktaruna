<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    // =========================
    // INDEX
    // =========================
    public function index()
    {
        $data = Layanan::latest()->get();
        return view('admin.layanan.index', compact('data'));
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'link' => 'required',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:5120'
        ]);

        $logo = null;

        // =========================
        // UPLOAD LOGO (HOSTING SAFE)
        // =========================
        if ($request->hasFile('logo')) {

            $file = $request->file('logo');

            $namaFile = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('uploads'), $namaFile);

            $logo = $namaFile;
        }

        Layanan::create([
            'nama' => $request->nama,
            'link' => $request->link,
            'logo' => $logo,
            'warna' => $request->warna,
            'deskripsi' => $request->deskripsi
        ]);

        return back()->with('success', 'Berhasil ditambahkan');
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $layanan = Layanan::findOrFail($id);
        return view('admin.layanan.edit', compact('layanan'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'link' => 'required',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:5120'
        ]);

        $layanan = Layanan::findOrFail($id);

        // =========================
        // UPDATE LOGO (HOSTING SAFE)
        // =========================
        if ($request->hasFile('logo')) {

            // hapus file lama
            if ($layanan->logo && file_exists(public_path('uploads/'.$layanan->logo))) {
                unlink(public_path('uploads/'.$layanan->logo));
            }

            $file = $request->file('logo');

            $namaFile = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('uploads'), $namaFile);

            $layanan->logo = $namaFile;
        }

        // update field lain
        $layanan->nama = $request->nama;
        $layanan->link = $request->link;
        $layanan->warna = $request->warna;
        $layanan->deskripsi = $request->deskripsi;

        $layanan->save();

        return redirect('/admin/layanan')
            ->with('success', 'Berhasil diupdate');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy(Layanan $layanan)
    {
        if ($layanan->logo && file_exists(public_path('uploads/'.$layanan->logo))) {
            unlink(public_path('uploads/'.$layanan->logo));
        }

        $layanan->delete();

        return back()->with('success', 'Berhasil dihapus');
    }
}