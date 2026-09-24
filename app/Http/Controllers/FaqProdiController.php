<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramStudi;
use App\Models\FaqProdi;

class FaqProdiController extends Controller
{
    public function index($id)
    {
        $program = ProgramStudi::with(
            'faqs'
        )->findOrFail($id);

        return view(
            'admin.faq.index',
            compact('program')
        );
    }

    public function store(Request $request)
    {
        FaqProdi::create([

            'program_studi_id'=>$request->program_studi_id,

            'pertanyaan'=>$request->pertanyaan,

            'jawaban'=>$request->jawaban

        ]);

        return back()
        ->with(
            'success',
            'FAQ berhasil ditambahkan.'
        );
    }

    public function update(
        Request $request,
        $id
    )
    {
        FaqProdi::findOrFail($id)
        ->update([

            'pertanyaan'=>$request->pertanyaan,

            'jawaban'=>$request->jawaban

        ]);

        return back()
        ->with(
            'success',
            'FAQ berhasil diupdate.'
        );
    }

    public function destroy($id)
    {
        FaqProdi::findOrFail($id)
        ->delete();

        return back()
        ->with(
            'success',
            'FAQ berhasil dihapus.'
        );
    }
}

