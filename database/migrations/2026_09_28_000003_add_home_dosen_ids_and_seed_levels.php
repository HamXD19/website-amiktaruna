<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('settings', 'home_dosen_ids')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->json('home_dosen_ids')->nullable()->after('mobile_banners')->comment('ID 4 pimpinan (Direktur & 3 Wadir) untuk beranda');
            });
        }

        // Auto-seed level organigram based on jabatan so production server matches
        DB::table('dosens')
            ->where(function($q) {
                $q->where('jabatan', 'LIKE', '%Direktur AMIK%')
                  ->orWhere(function($sub) {
                      $sub->where('jabatan', 'LIKE', '%Direktur%')
                          ->where('jabatan', 'NOT LIKE', '%Wakil%');
                  });
            })->update(['level_organigram' => 1]);

        DB::table('dosens')
            ->where('jabatan', 'LIKE', '%Wakil Direktur%')
            ->update(['level_organigram' => 2]);

        DB::table('dosens')
            ->where(function($q) {
                $q->where('jabatan', 'LIKE', '%Ketua%')
                  ->orWhere('jabatan', 'LIKE', '%Kaprodi%');
            })
            ->where('level_organigram', '>', 2)
            ->update(['level_organigram' => 3]);

        DB::table('dosens')
            ->where(function($q) {
                $q->where('jabatan', 'LIKE', '%Kepala Bagian%')
                  ->orWhere('jabatan', 'LIKE', '%Kabag%');
            })
            ->where('level_organigram', '>', 3)
            ->update(['level_organigram' => 4]);

        DB::table('dosens')
            ->where(function($q) {
                $q->where('jabatan', 'LIKE', '%Staf%')
                  ->orWhere('jabatan', 'LIKE', '%Staff%');
            })
            ->where('level_organigram', '>', 4)
            ->update(['level_organigram' => 5]);

        // Find Direktur & 3 Wadir IDs
        $direkturId = DB::table('dosens')->where('level_organigram', 1)->value('id');
        $wadir1Id = DB::table('dosens')->where('level_organigram', 2)->where(function($q) {
            $q->where('jabatan', 'LIKE', '%I %')->orWhere('jabatan', 'LIKE', '%Akademik%');
        })->value('id');
        $wadir2Id = DB::table('dosens')->where('level_organigram', 2)->where(function($q) {
            $q->where('jabatan', 'LIKE', '%II %')->orWhere('jabatan', 'LIKE', '%Keuangan%')->orWhere('jabatan', 'LIKE', '%Administrasi%');
        })->value('id');
        $wadir3Id = DB::table('dosens')->where('level_organigram', 2)->where(function($q) {
            $q->where('jabatan', 'LIKE', '%III %')->orWhere('jabatan', 'LIKE', '%Kemahasiswaan%')->orWhere('jabatan', 'LIKE', '%Alumni%');
        })->value('id');

        $leaderIds = array_values(array_filter([$direkturId, $wadir1Id, $wadir2Id, $wadir3Id]));
        if (count($leaderIds) < 4) {
            $fallbackIds = DB::table('dosens')->whereIn('level_organigram', [1, 2])->orderBy('level_organigram')->pluck('id')->toArray();
            $leaderIds = array_slice($fallbackIds, 0, 4);
        }

        if (!empty($leaderIds)) {
            DB::table('settings')->update(['home_dosen_ids' => json_encode($leaderIds)]);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('settings', 'home_dosen_ids')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('home_dosen_ids');
            });
        }
    }
};
