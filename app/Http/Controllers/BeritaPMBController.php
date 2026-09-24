<?php

namespace App\Http\Controllers;

use App\Models\BeritaPMB;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BeritaPMBController extends Controller
{
    public function index()
    {
        $beritas = BeritaPMB::latest()->get();

        return view('admin.beritapmb.index', compact('beritas'));
    }

    public function create()
    {
        $kategoris = Kategori::forModul('pmb')->active()->orderBy('urutan')->get();

        return view('admin.beritapmb.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required',
            'penulis'  => 'required',
            'editor'   => 'required',
            'kategori' => 'required',
            'isi'      => 'required',
            'gambar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'video'    => 'nullable|string|max:500',
            'file_pdf' => 'nullable|file|mimes:pdf,doc,docx|max:30720'
        ]);

        $gambar = null;
        $video = $request->filled('video') ? trim($request->video) : null;
        $file_pdf = null;

        if ($request->hasFile('gambar')) {

            $file = $request->file('gambar');

            $namaFile = time().'_'.$file->getClientOriginalName();

            $file->move(
                public_path('uploads/beritapmb/gambar'),
                $namaFile
            );

            $gambar = $namaFile;
        }

        if ($request->hasFile('file_pdf')) {

            $pdf = $request->file('file_pdf');

            $namaPdf = time().'_'.$pdf->getClientOriginalName();

            $pdf->move(
                public_path('uploads/beritapmb/pdf'),
                $namaPdf
            );

            $file_pdf = $namaPdf;
        }

        BeritaPMB::create([
            'judul'      => $request->judul,
            'slug'       => Str::slug($request->judul),
            'penulis'    => $request->penulis,
            'editor'     => $request->editor,
            'kategori'   => $request->kategori,
            'isi'        => $request->isi,
            'gambar'     => $gambar,
            'video'      => $video,
            'file_pdf'   => $file_pdf,
            'publish_at' => $request->publish_at ?: now()
        ]);

        return redirect('/admin/beritapmb')
            ->with('success', 'Berita PMB berhasil ditambahkan');
    }

   public function show($slug)
{
    $berita = BeritaPMB::where(
        'slug',
        $slug
    )->firstOrFail();

    return view(
        'pmb.show',
        compact('berita')
    );
}
    public function edit(BeritaPMB $beritapmb)
    {
        $kategoris = Kategori::forModul('pmb')->active()->orderBy('urutan')->get();

        return view(
            'admin.beritapmb.edit',
            compact('beritapmb', 'kategoris')
        );
    }

    public function update(Request $request, BeritaPMB $beritapmb)
    {
        $request->validate([
            'judul'    => 'required',
            'penulis'  => 'required',
            'editor'   => 'required',
            'kategori' => 'required',
            'isi'      => 'required',
            'gambar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'video'    => 'nullable|string|max:500',
            'file_pdf' => 'nullable|file|mimes:pdf,doc,docx|max:30720'
        ]);

        $gambar = $beritapmb->gambar;
        $video = $beritapmb->video;
        $file_pdf = $beritapmb->file_pdf;

        if ($request->hasFile('gambar')) {

            if (
                $beritapmb->gambar &&
                file_exists(
                    public_path(
                        'uploads/beritapmb/gambar/'.$beritapmb->gambar
                    )
                )
            ) {
                unlink(
                    public_path(
                        'uploads/beritapmb/gambar/'.$beritapmb->gambar
                    )
                );
            }

            $file = $request->file('gambar');

            $namaFile = time().'_'.$file->getClientOriginalName();

            $file->move(
                public_path('uploads/beritapmb/gambar'),
                $namaFile
            );

            $gambar = $namaFile;
        }

        if ($request->filled('video')) {
            if (
                $beritapmb->video &&
                !\Illuminate\Support\Str::startsWith($beritapmb->video, ['http://', 'https://']) &&
                file_exists(
                    public_path(
                        'uploads/beritapmb/video/'.$beritapmb->video
                    )
                )
            ) {
                unlink(
                    public_path(
                        'uploads/beritapmb/video/'.$beritapmb->video
                    )
                );
            }
            $video = trim($request->video);
        } else {
            $video = $request->has('video') ? null : $beritapmb->video;
        }

        if ($request->hasFile('file_pdf')) {

            if (
                $beritapmb->file_pdf &&
                file_exists(
                    public_path(
                        'uploads/beritapmb/pdf/'.$beritapmb->file_pdf
                    )
                )
            ) {
                unlink(
                    public_path(
                        'uploads/beritapmb/pdf/'.$beritapmb->file_pdf
                    )
                );
            }

            $pdf = $request->file('file_pdf');

            $namaPdf = time().'_'.$pdf->getClientOriginalName();

            $pdf->move(
                public_path('uploads/beritapmb/pdf'),
                $namaPdf
            );

            $file_pdf = $namaPdf;
        }

        $beritapmb->update([
            'judul'      => $request->judul,
            'slug'       => Str::slug($request->judul),
            'penulis'    => $request->penulis,
            'editor'     => $request->editor,
            'kategori'   => $request->kategori,
            'isi'        => $request->isi,
            'gambar'     => $gambar,
            'video'      => $video,
            'file_pdf'   => $file_pdf,
            'publish_at' => $request->publish_at ?: now()
        ]);

        return redirect('/admin/beritapmb')
            ->with('success', 'Berita PMB berhasil diupdate');
    }

    public function destroy(BeritaPMB $beritapmb)
    {
        if (
            $beritapmb->gambar &&
            file_exists(
                public_path(
                    'uploads/beritapmb/gambar/'.$beritapmb->gambar
                )
            )
        ) {
            unlink(
                public_path(
                    'uploads/beritapmb/gambar/'.$beritapmb->gambar
                )
            );
        }

        if (
            $beritapmb->video &&
            !\Illuminate\Support\Str::startsWith($beritapmb->video, ['http://', 'https://']) &&
            file_exists(
                public_path(
                    'uploads/beritapmb/video/'.$beritapmb->video
                )
            )
        ) {
            unlink(
                public_path(
                    'uploads/beritapmb/video/'.$beritapmb->video
                )
            );
        }

        if (
            $beritapmb->file_pdf &&
            file_exists(
                public_path(
                    'uploads/beritapmb/pdf/'.$beritapmb->file_pdf
                )
            )
        ) {
            unlink(
                public_path(
                    'uploads/beritapmb/pdf/'.$beritapmb->file_pdf
                )
            );
        }

        $beritapmb->delete();

        return redirect('/admin/beritapmb')
            ->with('success', 'Berita PMB berhasil dihapus');
    }
}

