<?php

namespace App\Http\Controllers;

use App\Models\BeritaPMB;
use Illuminate\Http\Request;
use App\Models\PMB;
use App\Models\Setting;
use App\Models\ProgramStudi;
use App\Services\ActivityLogger;
use Illuminate\Support\Str;

class PMBController extends Controller
{
    public function index()
    {
        $pmb = PMB::firstOrNew(['id' => 1]);

        return view(
            'admin.pmb.index',
            compact('pmb')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'             => 'required|string|max:255',
            'subjudul'          => 'nullable|string|max:255',
            'deskripsi'         => 'required|string',
            'nama_gelombang'    => 'nullable|string|max:100',
            'status_gelombang'  => 'nullable|string|max:100',
            'periode_gelombang' => 'nullable|string|max:100',
            'kuota_info'        => 'nullable|string|max:255',
            'no_whatsapp'       => 'nullable|string|max:50',
            'link_portal'       => 'nullable|string|max:500',
            // VALIDASI DOKUMEN: WAJIB PDF, DOC, DOCX
            'brosur_file'       => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:30720',
        ], [
            'judul.required'     => 'Judul PMB wajib diisi.',
            'deskripsi.required' => 'Deskripsi PMB wajib diisi.',
            'brosur_file.mimes'  => 'File brosur / panduan PMB wajib berupa file PDF, DOC, DOCX, atau JPG/PNG.',
            'brosur_file.max'    => 'Ukuran file brosur maksimal 30 MB.',
        ]);

        $pmb = PMB::firstOrNew(['id' => 1]);

        $pmb->judul             = $request->judul;
        $pmb->subjudul          = $request->subjudul;
        $pmb->deskripsi         = $request->deskripsi;
        $pmb->nama_gelombang    = $request->nama_gelombang;
        $pmb->status_gelombang  = $request->status_gelombang;
        $pmb->periode_gelombang = $request->periode_gelombang;
        $pmb->kuota_info        = $request->kuota_info;
        $pmb->no_whatsapp       = $request->no_whatsapp;
        $pmb->link_portal       = $request->link_portal;

        // Upload brosur jika diunggah
        if ($request->hasFile('brosur_file')) {
            if ($pmb->brosur_file && file_exists(public_path('uploads/pmb/' . $pmb->brosur_file))) {
                @unlink(public_path('uploads/pmb/' . $pmb->brosur_file));
            }
            $file = $request->file('brosur_file');
            $ext = $file->getClientOriginalExtension();
            $cleanName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
            $fileName = 'brosur_pmb_' . time() . '_' . substr($cleanName, 0, 25) . '.' . $ext;
            $file->move(public_path('uploads/pmb'), $fileName);
            $pmb->brosur_file = $fileName;
        }

        // Jalur Pendaftaran
        if ($request->has('jalur')) {
            $jalurs = [];
            foreach ($request->input('jalur', []) as $j) {
                if (!empty($j['nama'])) {
                    $jalurs[] = [
                        'nama'      => trim($j['nama']),
                        'badge'     => trim($j['badge'] ?? ''),
                        'ikon'      => trim($j['ikon'] ?? 'fas fa-graduation-cap'),
                        'deskripsi' => trim($j['deskripsi'] ?? ''),
                        'syarat'    => trim($j['syarat'] ?? ''),
                    ];
                }
            }
            $pmb->jalur_pendaftaran = $jalurs;
        }

        // Alur Pendaftaran
        if ($request->has('alur')) {
            $alurs = [];
            foreach ($request->input('alur', []) as $a) {
                if (!empty($a['judul'])) {
                    $alurs[] = [
                        'langkah'   => trim($a['langkah'] ?? ''),
                        'judul'     => trim($a['judul']),
                        'deskripsi' => trim($a['deskripsi'] ?? ''),
                    ];
                }
            }
            $pmb->alur_pendaftaran = $alurs;
        }

        // Jadwal Gelombang
        if ($request->has('jadwal')) {
            $jadwals = [];
            foreach ($request->input('jadwal', []) as $jd) {
                if (!empty($jd['nama'])) {
                    $jadwals[] = [
                        'nama'       => trim($jd['nama']),
                        'periode'    => trim($jd['periode'] ?? ''),
                        'status'     => trim($jd['status'] ?? ''),
                        'keterangan' => trim($jd['keterangan'] ?? ''),
                    ];
                }
            }
            $pmb->jadwal_gelombang = $jadwals;
        }

        // Persyaratan Berkas
        if ($request->has('syarat_berkas')) {
            $berkasList = [];
            foreach ($request->input('syarat_berkas', []) as $sb) {
                if (!empty($sb['judul'])) {
                    $berkasList[] = [
                        'judul'      => trim($sb['judul']),
                        'keterangan' => trim($sb['keterangan'] ?? ''),
                        'ikon'       => trim($sb['ikon'] ?? 'fas fa-file-alt'),
                    ];
                }
            }
            $pmb->persyaratan_berkas = $berkasList;
        }

        // FAQ
        if ($request->has('faq')) {
            $faqs = [];
            foreach ($request->input('faq', []) as $f) {
                if (!empty($f['tanya'])) {
                    $faqs[] = [
                        'tanya' => trim($f['tanya']),
                        'jawab' => trim($f['jawab'] ?? ''),
                    ];
                }
            }
            $pmb->faq_list = $faqs;
        }

        $pmb->save();

        ActivityLogger::log('UPDATE', 'PMB', 'Memperbarui data dan konfigurasi halaman PMB dinamis');

        return redirect()->route('pmb.index')->with('success', 'Seluruh data halaman PMB berhasil diperbarui secara dinamis.');
    }

    public function frontend()
    {
        $pmb = PMB::firstOrNew(['id' => 1]);
        $setting = Setting::first();
        $programStudis = ProgramStudi::all();

        $beritas = BeritaPMB::whereNotNull('publish_at')
            ->where('publish_at', '<=', now())
            ->latest('publish_at')
            ->get();

        return view(
            'pmb.index',
            compact(
                'pmb',
                'setting',
                'programStudis',
                'beritas'
            )
        );
    }
}
