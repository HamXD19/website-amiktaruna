<?php

namespace App\Http\Controllers;

use App\Models\KritikSaran;
use App\Models\Setting;
use App\Services\ActivityLogger;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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
        $nama = $data->nama;
        $data->delete();

        ActivityLogger::log('DELETE', 'Kritik & Saran', "Menghapus pesan kritik & saran dari: {$nama}");

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

    /**
     * Ekspor Laporan Rekapitulasi Kritik & Saran ke format PDF
     */
    public function exportPdf(Request $request)
    {
        $query = KritikSaran::latest();

        $statusFilter = $request->input('status');
        if ($statusFilter && in_array($statusFilter, ['baru', 'dibaca'])) {
            $query->where('status', $statusFilter);
        }

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $periodeText = 'Semua Data';
        if ($startDate && $endDate) {
            $query->whereDate('created_at', '>=', $startDate)
                  ->whereDate('created_at', '<=', $endDate);
            $periodeText = Carbon::parse($startDate)->format('d/m/Y') . ' s/d ' . Carbon::parse($endDate)->format('d/m/Y');
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
            $periodeText = 'Mulai ' . Carbon::parse($startDate)->format('d/m/Y');
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
            $periodeText = 'Hingga ' . Carbon::parse($endDate)->format('d/m/Y');
        }

        $items = $query->get();
        $setting = Setting::first();
        $logoBase64 = $this->getLogoBase64();

        ActivityLogger::log('EXPORT', 'Kritik & Saran', "Mengekspor laporan rekapitulasi kritik & saran ke PDF ({$items->count()} data)");

        $pdf = Pdf::loadView('admin.kritiksaran.pdf_rekap', compact(
            'items', 'setting', 'logoBase64', 'periodeText', 'statusFilter'
        ))->setPaper('a4', 'landscape')
          ->setOptions([
              'isHtml5ParserEnabled' => true,
              'isRemoteEnabled' => true,
              'defaultFont' => 'sans-serif',
          ]);

        $filename = 'Laporan_Rekap_Kritik_Saran_' . date('Ymd_His') . '.pdf';

        if ($request->query('download') === '1') {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }

    /**
     * Ekspor Lembar Detail / Disposisi per Kritik & Saran ke format PDF
     */
    public function exportSinglePdf($id)
    {
        $item = KritikSaran::findOrFail($id);
        $setting = Setting::first();
        $logoBase64 = $this->getLogoBase64();

        if ($item->status === 'baru') {
            $item->update(['status' => 'dibaca']);
        }

        ActivityLogger::log('EXPORT', 'Kritik & Saran', "Mengekspor lembar pengaduan kritik & saran #{$item->id} ({$item->nama}) ke PDF");

        $pdf = Pdf::loadView('admin.kritiksaran.pdf_detail', compact(
            'item', 'setting', 'logoBase64'
        ))->setPaper('a4', 'portrait')
          ->setOptions([
              'isHtml5ParserEnabled' => true,
              'isRemoteEnabled' => true,
              'defaultFont' => 'sans-serif',
          ]);

        $filename = 'Lembar_Kritik_Saran_' . $item->id . '_' . date('Ymd') . '.pdf';

        if (request()->query('download') === '1') {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }

    /**
     * Konversi logo resmi institusi ke base64 agar aman dan cepat dimuat di DomPDF
     */
    private function getLogoBase64(): ?string
    {
        $setting = Setting::first();
        if ($setting && $setting->logo) {
            $possiblePaths = [
                public_path('uploads/' . $setting->logo),
                public_path($setting->logo),
            ];
            foreach ($possiblePaths as $path) {
                if (file_exists($path) && is_file($path)) {
                    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                    $mime = match ($ext) {
                        'jpg', 'jpeg' => 'image/jpeg',
                        'png' => 'image/png',
                        'webp' => 'image/webp',
                        'gif' => 'image/gif',
                        'svg' => 'image/svg+xml',
                        default => 'image/jpeg',
                    };
                    $data = file_get_contents($path);
                    return 'data:' . $mime . ';base64,' . base64_encode($data);
                }
            }
        }

        if (file_exists(public_path('logo.png'))) {
            $data = file_get_contents(public_path('logo.png'));
            return 'data:image/png;base64,' . base64_encode($data);
        }

        return null;
    }
}