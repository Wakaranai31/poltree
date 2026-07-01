<?php

namespace App\Console\Commands;

use App\Models\Link;
use App\Services\LinkStatusChecker;
use Illuminate\Console\Command;

class CheckLinkStatusesCommand extends Command
{
    protected $signature = 'links:check-status
        {--id=* : Periksa hanya id_link tertentu}';

    protected $description = 'Periksa otomatis apakah website pada t_link sedang aktif atau bermasalah.';

    public function handle(\App\Services\LinkStatusChecker $checker): int
    {
        $query = Link::query()->orderBy('id_link');
        $selectedIds = collect((array) $this->option('id'))
            ->filter(fn($value) => $value !== null && $value !== '')
            ->map(fn($value) => (int) $value)
            ->values();

        if ($selectedIds->isNotEmpty()) {
            $query->whereIn('id_link', $selectedIds);
        }

        $links = $query->get();

        if ($links->isEmpty()) {
            $this->warn('Tidak ada link yang bisa diperiksa.');

            return self::SUCCESS;
        }

        foreach ($links as $link) {
            \App\Jobs\CheckLinkStatus::dispatch($link->id_link);
        }

        $this->info('Pemeriksaan ' . $links->count() . ' link telah dimasukkan ke dalam antrean (Queue).');

        return self::SUCCESS;
    }
}
