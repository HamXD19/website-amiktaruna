<?php

namespace App\Http\Controllers;

use App\Models\AlumniSection;
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

        return view('alumni', compact('data'));
    }

    /*
    |------------------------------------------
    | ADMIN INDEX
    |------------------------------------------
    */
    public function index()
    {
        $data = AlumniSection::latest()->get();

        return view('admin.alumni_section.index', compact('data'));
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
}