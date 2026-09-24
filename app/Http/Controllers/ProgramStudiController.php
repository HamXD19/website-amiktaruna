<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramStudi;
use Illuminate\Support\Str;

class ProgramStudiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $programs = ProgramStudi::withCount('dokumens')->latest()->get();

        return view(
            'admin.program_studi.index',
            compact('programs')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'nama_prodi'=>'required',
            'thumbnail'=>'nullable|image|max:4096',
            'kalender_akademik'=>'nullable|file|mimes:pdf,doc,docx|max:30720',
            'jadwal_semester'=>'nullable|file|mimes:pdf,doc,docx|max:30720'
        ]);

        $thumbnail = null;
        $kalender = null;
        $jadwal = null;

        if($request->hasFile('thumbnail'))
        {
            $thumbnail = time().'_'.$request
                ->thumbnail
                ->getClientOriginalName();

            $request->thumbnail
                ->move(
                    public_path('uploads/program_studi'),
                    $thumbnail
                );
        }

        if($request->hasFile('kalender_akademik'))
        {
            $kalender = time().'_'.$request
                ->kalender_akademik
                ->getClientOriginalName();

            $request->kalender_akademik
                ->move(
                    public_path('uploads/program_studi'),
                    $kalender
                );
        }

        if($request->hasFile('jadwal_semester'))
        {
            $jadwal = time().'_'.$request
                ->jadwal_semester
                ->getClientOriginalName();

            $request->jadwal_semester
                ->move(
                    public_path('uploads/program_studi'),
                    $jadwal
                );
        }

        ProgramStudi::create([

            'nama_prodi'=>$request->nama_prodi,

            'slug'=>Str::slug(
                $request->nama_prodi
            ),

            'tagline'=>$request->tagline,

            'deskripsi'=>$request->deskripsi,

            'visi'=>$request->visi,

            'misi'=>$request->misi,

            'akreditasi'=>$request->akreditasi,

            'thumbnail'=>$thumbnail,

            'kalender_akademik'=>$kalender,

            'jadwal_semester'=>$jadwal

        ]);

        return back()
            ->with(
                'success',
                'Program studi berhasil ditambahkan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $program = ProgramStudi::findOrFail($id);

        return view(
            'admin.program_studi.edit',
            compact('program')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    )
    {
        $program = ProgramStudi::findOrFail($id);

        $request->validate([
            'nama_prodi'=>'required',
            'thumbnail'=>'nullable|image|max:4096',
            'kalender_akademik'=>'nullable|file|mimes:pdf,doc,docx|max:30720',
            'jadwal_semester'=>'nullable|file|mimes:pdf,doc,docx|max:30720'
        ]);

        $data = $request->all();

        if($request->hasFile('thumbnail'))
        {
            if ($program->thumbnail && file_exists(public_path('uploads/program_studi/' . $program->thumbnail))) {
                @unlink(public_path('uploads/program_studi/' . $program->thumbnail));
            }

            $thumbnail=time().'_'.$request
                ->thumbnail
                ->getClientOriginalName();

            $request->thumbnail
                ->move(
                    public_path(
                        'uploads/program_studi'
                    ),
                    $thumbnail
                );

            $data['thumbnail']=$thumbnail;
        }

        if($request->hasFile('kalender_akademik'))
        {
            if ($program->kalender_akademik && file_exists(public_path('uploads/program_studi/' . $program->kalender_akademik))) {
                @unlink(public_path('uploads/program_studi/' . $program->kalender_akademik));
            }

            $kalender=time().'_'.$request
                ->kalender_akademik
                ->getClientOriginalName();

            $request->kalender_akademik
                ->move(
                    public_path(
                        'uploads/program_studi'
                    ),
                    $kalender
                );

            $data[
                'kalender_akademik'
            ]=$kalender;
        }

        if($request->hasFile('jadwal_semester'))
        {
            if ($program->jadwal_semester && file_exists(public_path('uploads/program_studi/' . $program->jadwal_semester))) {
                @unlink(public_path('uploads/program_studi/' . $program->jadwal_semester));
            }

            $jadwal=time().'_'.$request
                ->jadwal_semester
                ->getClientOriginalName();

            $request->jadwal_semester
                ->move(
                    public_path(
                        'uploads/program_studi'
                    ),
                    $jadwal
                );

            $data[
                'jadwal_semester'
            ]=$jadwal;
        }

        $program->update($data);

        return redirect()
            ->route(
                'program-studi.index'
            )
            ->with(
                'success',
                'Data berhasil diupdate.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $program = ProgramStudi::findOrFail($id);
        $program->delete();

        return back()
            ->with(
                'success',
                'Program studi dan seluruh berkas terkait berhasil dihapus.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | FRONTEND AKADEMIK
    |--------------------------------------------------------------------------
    */

    public function frontend()
    {
        $programs = ProgramStudi::all();

        return view(
            'akademik.index',
            compact('programs')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL FRONTEND
    |--------------------------------------------------------------------------
    */

    public function show($slug)
    {
        $program = ProgramStudi::with([
            'profilLulusans',
            'fasilitas',
            'faqs',
            'dokumens' => function ($q) {
                $q->where('is_active', true)->orderBy('urutan', 'asc')->latest();
            },
            'dokumens.kategoriModel'
        ])
        ->where('slug', $slug)
        ->firstOrFail();

        $kategoriDokumen = \App\Models\Kategori::forModul('prodi_dokumen')
            ->active()
            ->orderBy('urutan', 'asc')
            ->get();

        return view(
            'akademik.show',
            compact('program', 'kategoriDokumen')
        );
    }
}