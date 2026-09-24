<?php

namespace App\Console\Commands;

use App\Models\Dosen;
use App\Services\ImageOptimizer;
use Illuminate\Console\Command;

class OptimizeDosenPhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dosen:optimize-photos {--threshold=150 : Only optimize images larger than this size in KB}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compress and optimize existing dosen profile photos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $threshold = (int) $this->option('threshold');
        $dosens = Dosen::whereNotNull('foto')->get();

        $this->info("Memeriksa foto dari {$dosens->count()} dosen (Ambang batas: > {$threshold} KB)...");

        $optimizedCount = 0;
        $totalSavedBytes = 0;

        foreach ($dosens as $dosen) {
            $filePath = public_path('uploads/' . $dosen->foto);

            if (!file_exists($filePath)) {
                continue;
            }

            clearstatcache(true, $filePath);
            $sizeKb = round(filesize($filePath) / 1024, 2);

            if ($sizeKb > $threshold) {
                $beforeBytes = filesize($filePath);
                $success = ImageOptimizer::optimize($filePath, null, 800, 1000, 82);
                clearstatcache(true, $filePath);
                $afterBytes = filesize($filePath);

                if ($success && $afterBytes < $beforeBytes) {
                    $savedBytes = $beforeBytes - $afterBytes;
                    $totalSavedBytes += $savedBytes;
                    $optimizedCount++;

                    $beforeKb = round($beforeBytes / 1024, 2);
                    $afterKb = round($afterBytes / 1024, 2);
                    $percent = round(($savedBytes / $beforeBytes) * 100, 1);

                    $this->line("<fg=green>✓</> <fg=yellow>{$dosen->nama}</>: {$beforeKb} KB -> <fg=cyan>{$afterKb} KB</> (Hemat {$percent}%)");
                }
            }
        }

        $totalSavedMb = round($totalSavedBytes / 1024 / 1024, 2);
        $this->newLine();
        $this->info("Selesai! {$optimizedCount} foto berhasil dikompres. Total penghematan bandwidth: {$totalSavedMb} MB.");

        return Command::SUCCESS;
    }
}
