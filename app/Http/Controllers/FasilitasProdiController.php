<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramStudi;
use App\Models\FasilitasProdi;

class FasilitasProdiController extends Controller
{
    public function index($id)
    {
        $program = ProgramStudi::with(
            'fasilitas'
        )->findOrFail($id);

        return view(
            'admin.fasilitas.index',
            compact('program')
        );
    }

    public function store(Request $request)
    {
        FasilitasProdi::create([

            'program_studi_id'=>$request->program_studi_id,

            'nama'=>$request->nama,

            'deskripsi'=>$request->deskripsi,

            'icon'=>$request->icon

        ]);

        return back()
        ->with(
            'success',
            'Fasilitas berhasil ditambahkan.'
        );
    }

    public function update(
        Request $request,
        $id
    )
    {
        FasilitasProdi::findOrFail($id)
        ->update([

            'nama'=>$request->nama,

            'deskripsi'=>$request->deskripsi,

            'icon'=>$request->icon

        ]);

        return back()
        ->with(
            'success',
            'Fasilitas berhasil diupdate.'
        );
    }

    public function destroy($id)
    {
        FasilitasProdi::findOrFail($id)
        ->delete();

        return back()
        ->with(
            'success',
            'Fasilitas berhasil dihapus.'
        );
    }
}

