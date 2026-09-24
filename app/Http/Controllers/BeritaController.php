<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\VisiMisi;
use App\Models\Dosen;
use App\Models\Kategori;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class BeritaController extends Controller
{
    /*
    |------------------------------------------
    | ADMIN LIST
    |------------------------------------------
    */
    public function index()
    {
    $beritas = Berita::latest()->get();

    return view('admin.berita.index', compact('beritas'));
    }

    /*
    |------------------------------------------
    | CREATE FORM
    |------------------------------------------
    */
    public function create()
    {
        $kategoris = Kategori::forModul('berita')->active()->orderBy('urutan')->get();
        return view('admin.berita.create', compact('kategoris'));
    }

    /*
    |------------------------------------------
    | STORE BERITA
    |------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required',
            'penulis'  => 'required',
            'editor' => 'nullable|string|max:255',
            'kategori' => 'required',
            'isi'      => 'required',

            // IMAGE
            'gambar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            // VIDEO (YOUTUBE / TIKTOK LINK)
            'video'    => 'nullable|string|max:500',

            'file_pdf' => 'nullable|file|mimes:pdf,doc,docx|max:30720'
        ]);

        $gambar = null;
        $video  = $request->filled('video') ? trim($request->video) : null;
        $file_pdf = null;
        /*
        |------------------------------------------
        | UPLOAD GAMBAR
        |------------------------------------------
        */
        if ($request->hasFile('gambar')) {

            $file = $request->file('gambar');

            $namaFile = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('uploads/berita/gambar'), $namaFile);

            $gambar = $namaFile;
        }
        /*
        |------------------------------------------
        | UPLOAD PDF
        |------------------------------------------
        */
if ($request->hasFile('file_pdf')) {

    $pdf = $request->file('file_pdf');

    $namaPdf = time().'_'.$pdf->getClientOriginalName();

    $pdf->move(
        public_path('uploads/berita/pdf'),
        $namaPdf
    );

    $file_pdf = $namaPdf;
}
        /*
        |------------------------------------------
        | SIMPAN DB
        |------------------------------------------
        */
    $berita = Berita::create([
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

    ActivityLogger::log('CREATE', 'Berita', "Mempublikasikan berita baru: \"{$berita->judul}\"");

    return redirect('/admin/berita')
        ->with('success', 'Berita berhasil ditambahkan');
    }

    /*
    |------------------------------------------
    | DETAIL
    |------------------------------------------
    */
    public function show(Berita $berita)
    {
        return view('berita.show', compact('berita'));
    }

    /*
    |------------------------------------------
    | EDIT
    |------------------------------------------
    */
    public function edit(Berita $berita)
    {
        $kategoris = Kategori::forModul('berita')->active()->orderBy('urutan')->get();
        return view('admin.berita.edit', compact('berita', 'kategoris'));
    }

    /*
    |------------------------------------------
    | UPDATE BERITA
    |------------------------------------------
    */
    public function update(Request $request, Berita $berita)
    {
        $request->validate([
    'judul'    => 'required',
    'penulis'  => 'required',
    'editor' => 'required',
    'kategori' => 'required',
    'isi'      => 'required',
    'gambar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    'video'    => 'nullable|string|max:500',
    'file_pdf' => 'nullable|file|mimes:pdf,doc,docx|max:30720'
]);

        $gambar = $berita->gambar;
        $video  = $berita->video;
        $file_pdf = $berita->file_pdf;

        /*
        |------------------------------------------
        | UPDATE GAMBAR
        |------------------------------------------
        */
        if ($request->hasFile('gambar')) {

            // hapus gambar lama
            if (
                $berita->gambar &&
                file_exists(public_path('uploads/berita/gambar/'.$berita->gambar))
            ) {

                unlink(
                    public_path('uploads/berita/gambar/'.$berita->gambar)
                );
            }

            $file = $request->file('gambar');

            $namaFile = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('uploads/berita/gambar'), $namaFile);

            $gambar = $namaFile;
        }

        /*
        |------------------------------------------
        | UPDATE VIDEO (LINK YOUTUBE / TIKTOK)
        |------------------------------------------
        */
        if ($request->filled('video')) {
            if (
                $berita->video &&
                !Str::startsWith($berita->video, ['http://', 'https://']) &&
                file_exists(public_path('uploads/berita/video/'.$berita->video))
            ) {
                unlink(public_path('uploads/berita/video/'.$berita->video));
            }
            $video = trim($request->video);
        } else {
            $video = $request->has('video') ? null : $berita->video;
        }


        if ($request->hasFile('file_pdf')) {

    if (
        $berita->file_pdf &&
        file_exists(
            public_path(
                'uploads/berita/pdf/'.$berita->file_pdf
            )
        )
    ) {

        unlink(
            public_path(
                'uploads/berita/pdf/'.$berita->file_pdf
            )
        );
    }

    $pdf = $request->file('file_pdf');

    $namaPdf = time().'_'.$pdf->getClientOriginalName();

    $pdf->move(
        public_path('uploads/berita/pdf'),
        $namaPdf
    );

    $file_pdf = $namaPdf;
}
        /*
        |------------------------------------------
        | UPDATE DB
        |------------------------------------------
        */
        $berita->update([
            'judul'    => $request->judul,
            'slug'     => Str::slug($request->judul),
            'penulis'  => $request->penulis,
            'editor'   => $request->editor,
            'kategori' => $request->kategori,
            'isi'      => $request->isi,
            'gambar'   => $gambar,
            'video'    => $video,
            'file_pdf' => $file_pdf,
            'publish_at' => $request->publish_at ?: now()
        ]);

        ActivityLogger::log('UPDATE', 'Berita', "Memperbarui berita: \"{$berita->judul}\"");

        return redirect('/admin/berita')
            ->with('success', 'Berita berhasil diupdate');
    }

    /*
    |------------------------------------------
    | DELETE
    |------------------------------------------
    */
    public function destroy(Berita $berita)
    {
        $judulBerita = $berita->judul;

        /*
        |------------------------------------------
        | HAPUS GAMBAR
        |------------------------------------------
        */
        if (
            $berita->gambar &&
            file_exists(public_path('uploads/berita/gambar/'.$berita->gambar))
        ) {

            unlink(
                public_path('uploads/berita/gambar/'.$berita->gambar)
            );
        }

        /*
        |------------------------------------------
        | HAPUS VIDEO
        |------------------------------------------
        */
        if (
            $berita->video &&
            !\Illuminate\Support\Str::startsWith($berita->video, ['http://', 'https://']) &&
            file_exists(public_path('uploads/berita/video/'.$berita->video))
        ) {

            unlink(
                public_path('uploads/berita/video/'.$berita->video)
            );
        }
        if (
    $berita->file_pdf &&
    file_exists(
        public_path(
            'uploads/berita/pdf/'.$berita->file_pdf
        )
    )
) {

    unlink(
        public_path(
            'uploads/berita/pdf/'.$berita->file_pdf
        )
    );
}
        $berita->delete();

        ActivityLogger::log('DELETE', 'Berita', "Menghapus berita: \"{$judulBerita}\"");

        return redirect('/admin/berita')
            ->with('success', 'Berita berhasil dihapus');
    }

    /*
    |------------------------------------------
    | HOME PAGE
    |------------------------------------------
    */
    public function home()
    {
$beritas = Berita::where('publish_at', '<=', now())
    ->latest('publish_at')
    ->get();  

$pengumuman = Berita::where('kategori', 'pengumuman')
    ->where('publish_at', '<=', now())
    ->latest()
    ->get();

$pengabdian = Berita::where('kategori', 'pengabdian')
    ->where('publish_at', '<=', now())
    ->latest()
    ->get();

$penelitian = Berita::where('kategori', 'penelitian')
    ->where('publish_at', '<=', now())
    ->latest()
    ->get();

$kegiatan = Berita::where('kategori', 'kegiatan_kampus')
    ->where('publish_at', '<=', now())
    ->latest()
    ->get();

        $visimisi = VisiMisi::first();

        $dosen = Dosen::all();

        return view('home', compact(
            'beritas',
            'pengumuman',
            'pengabdian',
            'penelitian',
            'kegiatan',
            'visimisi',
            'dosen'
        ));
    }

    /*
    |------------------------------------------
    | PUBLIC LIST + SEARCH
    |------------------------------------------
    */
    public function indexPublic(Request $request)
    {
        $search = $request->search;

        $kategoris = Kategori::forModul('berita')
            ->active()
            ->orderBy('urutan', 'asc')
            ->get();

        $kategoriData = [];
        foreach ($kategoris as $kat) {
            $query = Berita::where('kategori', $kat->slug)
                ->where('publish_at', '<=', now())
                ->latest();

            if (!empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                      ->orWhere('isi', 'like', "%{$search}%")
                      ->orWhere('penulis', 'like', "%{$search}%");
                });
            }

            $kategoriData[$kat->slug] = [
                'model' => $kat,
                'data'  => $query->get(),
                'label' => $kat->nama,
                'sub'   => $kat->keterangan ?: 'Informasi dan berita seputar ' . $kat->nama,
                'icon'  => $kat->ikon ?: '📌',
                'color' => $kat->warna ?: 'success',
            ];
        }

        // Seluruh berita terkini untuk tab "Semua Warta"
        $latestAllQuery = Berita::where('publish_at', '<=', now())->latest('publish_at');
        if (!empty($search)) {
            $latestAllQuery->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('isi', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%");
            });
        }
        $allBerita = $latestAllQuery->get();

        return view('berita.index', compact(
            'kategoris',
            'kategoriData',
            'allBerita',
            'search'
        ));
    }

    /*
    |------------------------------------------
    | PUBLIC DETAIL
    |------------------------------------------
    */
    public function showPublic($slug)
    {
        $berita = Berita::where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        return view('berita.show', compact('berita'));
    }
}
 