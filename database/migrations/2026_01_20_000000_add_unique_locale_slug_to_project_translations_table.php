<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->dedupeSlugs();

        Schema::table('project_translations', function (Blueprint $table) {
            $table->unique(['locale', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_translations', function (Blueprint $table) {
            $table->dropUnique(['locale', 'slug']);
        });
    }

    private function dedupeSlugs(): void
    {
        if (!Schema::hasTable('project_translations')) {
            return;
        }

        $rows = DB::table('project_translations')
            ->select(['id', 'project_id', 'locale', 'name', 'slug'])
            ->orderBy('locale')
            ->orderBy('slug')
            ->orderBy('id')
            ->get();

        $used = [];

        foreach ($rows as $row) {
            $locale = (string) ($row->locale ?? '');
            $raw = (string) ($row->slug ?: ($row->name ?: 'project'));
            $base = Str::slug($raw);
            if ($base === '') {
                $base = 'project';
            }

            $candidate = $this->nextAvailableSlug($base, $locale, $used);

            if ($candidate !== (string) $row->slug) {
                DB::table('project_translations')
                    ->where('id', $row->id)
                    ->update(['slug' => $candidate]);
            }

            $used[$locale][$candidate] = true;
        }
    }

    private function nextAvailableSlug(string $base, string $locale, array $used): string
    {
        $base = $this->truncateBase($base, 0);

        if (!isset($used[$locale][$base])) {
            return $base;
        }

        $counter = 2;
        while (true) {
            $suffix = '-' . $counter;
            $truncatedBase = $this->truncateBase($base, strlen($suffix));
            $candidate = $truncatedBase . $suffix;

            if (!isset($used[$locale][$candidate])) {
                return $candidate;
            }

            $counter++;
        }
    }

    private function truncateBase(string $base, int $reservedSuffixLength): string
    {
        $max = 255 - $reservedSuffixLength;
        if ($max < 1) {
            return '';
        }

        return strlen($base) > $max ? substr($base, 0, $max) : $base;
    }
};
