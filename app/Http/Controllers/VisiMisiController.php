<?php

namespace App\Http\Controllers;

use App\Models\VisiMisi;
use Illuminate\Http\Request;

class VisiMisiController extends Controller
{
    public function index()
    {
        $data = VisiMisi::first();
        return view('admin.visimisi', compact('data'));
    }

    public function store(Request $request)
    {
        VisiMisi::updateOrCreate(
            ['id' => 1],
            [
                'visi' => $request->visi,
                'misi' => $request->misi,
                'deskripsi' => $request->deskripsi
            ]
        );

        return back()->with('success', 'Berhasil disimpan');
    }

    public function edit()
    {
        $data = VisiMisi::first();
        return view('admin.visimisi_edit', compact('data'));
    }

    public function update(Request $request)
    {
        VisiMisi::updateOrCreate(
            ['id' => 1],
            [
                'visi' => $request->visi,
                'misi' => $request->misi,
                'deskripsi' => $request->deskripsi
            ]
        );

        return redirect('/admin/visimisi/edit')->with('success', 'Berhasil diupdate');
    }
}