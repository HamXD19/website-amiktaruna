<?php

namespace App\Http\Controllers;

use App\Models\LPPM;
use App\Models\LPPMPortal;
use Illuminate\Http\Request;

class LPPMController extends Controller
{
    private function autoSeedPortals($lppm)
    {
        if (LPPMPortal::count() === 0) {
            LPPMPortal::create([
                'nama' => 'JESICA',
                'link' => $lppm?->jesica_link ?: 'https://jessica.amiktaruna.ac.id/',
                'logo' => $lppm?->jesica_image ?: null,
                'warna' => 'success',
                'deskripsi' => 'Jurnal Elektronik Sistem Informasi dan Komputer Terapan AMIK Taruna Probolinggo.',
                'urutan' => 1,
            ]);

            LPPMPortal::create([
                'nama' => 'Pengajuan Proposal PPM',
                'link' => $lppm?->penelitian_link ?: 'https://pengajuanproposalppm.amiktaruna.ac.id/',
                'logo' => $lppm?->penelitian_image ?: null,
                'warna' => 'primary',
                'deskripsi' => 'Sistem Informasi Pengajuan Proposal Penelitian dan Pengabdian kepada Masyarakat.',
                'urutan' => 2,
            ]);
        }
    }

    public function index()
    {
        $lppm = LPPM::first();
        $this->autoSeedPortals($lppm);
        $portals = LPPMPortal::orderBy('urutan', 'asc')->latest()->get();

        return view('lppm.index', compact('lppm', 'portals'));
    }

    public function admin()
    {
        $lppm = LPPM::first();
        $this->autoSeedPortals($lppm);
        $portals = LPPMPortal::orderBy('urutan', 'asc')->latest()->get();

        return view('admin.lppm.index', compact('lppm', 'portals'));
    }

    public function store(Request $request)
    {
        $lppm = LPPM::first() ?? new LPPM();

        $lppm->deskripsi = $request->deskripsi;
        $lppm->jesica_link = $request->jesica_link;
        $lppm->penelitian_link = $request->penelitian_link;

        if ($request->hasFile('jesica_image')) {
            $file = $request->file('jesica_image');
            $name = time().'_jesica.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/lppm'), $name);
            $lppm->jesica_image = $name;
        }

        if ($request->hasFile('penelitian_image')) {
            $file = $request->file('penelitian_image');
            $name = time().'_penelitian.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/lppm'), $name);
            $lppm->penelitian_image = $name;
        }

        $lppm->save();

        return back()->with('success', 'Deskripsi LPPM berhasil disimpan');
    }

    public function storePortal(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'link' => 'required',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:5120',
            'deskripsi' => 'nullable|string',
            'warna' => 'nullable|string',
            'urutan' => 'nullable|integer',
        ]);

        $logo = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $namaFile = time().'_portal_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/lppm'), $namaFile);
            $logo = $namaFile;
        }

        LPPMPortal::create([
            'nama' => $request->nama,
            'link' => $request->link,
            'logo' => $logo,
            'warna' => $request->warna ?? 'success',
            'deskripsi' => $request->deskripsi,
            'urutan' => $request->urutan ?? 0,
        ]);

        return back()->with('success', 'Portal LPPM berhasil ditambahkan');
    }

    public function updatePortal(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'link' => 'required',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:5120',
            'deskripsi' => 'nullable|string',
            'warna' => 'nullable|string',
            'urutan' => 'nullable|integer',
        ]);

        $portal = LPPMPortal::findOrFail($id);

        if ($request->hasFile('logo')) {
            if ($portal->logo && file_exists(public_path('uploads/lppm/'.$portal->logo))) {
                @unlink(public_path('uploads/lppm/'.$portal->logo));
            }
            $file = $request->file('logo');
            $namaFile = time().'_portal_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/lppm'), $namaFile);
            $portal->logo = $namaFile;
        }

        $portal->nama = $request->nama;
        $portal->link = $request->link;
        $portal->warna = $request->warna ?? 'success';
        $portal->deskripsi = $request->deskripsi;
        $portal->urutan = $request->urutan ?? 0;
        $portal->save();

        return back()->with('success', 'Portal LPPM berhasil diperbarui');
    }

    public function destroyPortal($id)
    {
        $portal = LPPMPortal::findOrFail($id);

        if ($portal->logo && file_exists(public_path('uploads/lppm/'.$portal->logo))) {
            @unlink(public_path('uploads/lppm/'.$portal->logo));
        }

        $portal->delete();

        return back()->with('success', 'Portal LPPM berhasil dihapus');
    }
}