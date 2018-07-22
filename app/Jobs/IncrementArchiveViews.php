<?php

namespace App\Jobs;

use App\Archive;
use App\User;
use Carbon\Carbon;

use Carbon\CarbonInterval;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class IncrementArchiveViews implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Archive
     */
    private $archive;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Archive $archive)
    {
        $this->user = $user;
        $this->archive = $archive;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $timeEnabled = \Config::get('app.views.time.enabled');
        $timeThreshold = CarbonInterval::fromString(\Config::get('app.views.time.threshold'));

        $views = $this->user->archiveViews();
        $shouldIncrement = true;

        if ($timeEnabled) {
            // only increment if the last view was >= the time threshold
            $lastView = $views->where('manga_id', $this->archive->id)
                ->where('created_at', '<=', Carbon::now()->sub($timeThreshold))
                ->orderByDesc('created_at')
                ->first();

            if (empty($lastView))
                $shouldIncrement = false;
        }

        if ($shouldIncrement) {
            $views->create([
                'archive_id' => $this->archive->id
            ]);
        }
    }
}