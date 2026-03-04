<?php

namespace App\Console\Commands;

use App\Models\SongRequest;
use Illuminate\Console\Command;

class PruneApprovedSongRequests extends Command
{
    protected $signature = 'song-requests:prune-approved {--days=30 : Delete approved records older than this many days}';

    protected $description = 'Delete approved song requests older than the specified number of days';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $cutoff = now()->subDays($days);

        $count = SongRequest::where('status', 'approved')
            ->where('approved_at', '<', $cutoff)
            ->delete();

        $this->info("Deleted {$count} approved song request(s) older than {$days} days.");

        return self::SUCCESS;
    }
}
