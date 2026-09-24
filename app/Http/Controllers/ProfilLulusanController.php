<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramStudi;
use App\Models\ProfilLulusan;

class ProfilLulusanController extends Controller
{
    public function index($id = null)
    {
        if ($id) {
            $program = ProgramStudi::with('profilLulusans')->findOrFail($id);
            return view('admin.profil.index', compact('program'));
        }

        $programs = ProgramStudi::all();
        $profils = ProfilLulusan::with('programStudi')->latest()->get();

        return view('admin.profil_lulusan.index', compact('programs', 'profils'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_studi_id' => 'required|exists:program_studis,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        ProfilLulusan::create([
            'program_studi_id' => $request->program_studi_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', 'Profil lulusan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $profil = ProfilLulusan::with('programStudi')->findOrFail($id);
        $programs = ProgramStudi::all();

        return view('admin.profil_lulusan.edit', compact('profil', 'programs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'program_studi_id' => 'nullable|exists:program_studis,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $profil = ProfilLulusan::findOrFail($id);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->filled('program_studi_id')) {
            $data['program_studi_id'] = $request->program_studi_id;
        }

        $profil->update($data);

        return redirect()->route('profil-lulusan.index')->with('success', 'Profil lulusan berhasil diupdate.');
    }

    public function destroy($id)
    {
        ProfilLulusan::findOrFail($id)->delete();

        return back()->with('success', 'Profil lulusan berhasil dihapus.');
    }
}
