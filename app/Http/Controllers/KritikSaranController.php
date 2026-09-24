<?php

namespace App\Http\Controllers;

use App\Models\KritikSaran;
use Illuminate\Http\Request;

class KritikSaranController extends Controller
{
    public function create()
    {
        return view('kritiksaran.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'judul' => 'required',
            'pesan' => 'required',
        ]);

        KritikSaran::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'judul' => $request->judul,
            'pesan' => $request->pesan,
            'status' => 'baru',
        ]);

    return redirect()->back()->with(
    'success',
    'Pesan berhasil dikirim'
    );

    }

    public function destroy($id)
{
    $data = KritikSaran::findOrFail($id);

    $data->delete();

    return redirect()->back()->with(
        'success',
        'Pesan berhasil dihapus.'
    );
}

    public function index()
    {
        $data = KritikSaran::latest()->get();

        return view(
            'admin.kritiksaran.index',
            compact('data')
        );
    }

    
}