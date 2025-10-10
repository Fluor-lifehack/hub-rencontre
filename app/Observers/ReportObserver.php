<?php

namespace App\Observers;

use App\Models\Report;
use Illuminate\Support\Str;

class ReportObserver
{
    /**
     * Handle the Report "creating" event.
     */
    public function creating(Report $report): void
    {
        if (empty($report->uuid)) {
            $report->uuid = Str::uuid();
        }
    }

    /**
     * Handle the Report "created" event.
     */
    public function created(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "updating" event.
     */
    public function updating(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "updated" event.
     */
    public function updated(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "deleting" event.
     */
    public function deleting(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "deleted" event.
     */
    public function deleted(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "restored" event.
     */
    public function restored(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "force deleted" event.
     */
    public function forceDeleted(Report $report): void
    {
        //
    }
}
