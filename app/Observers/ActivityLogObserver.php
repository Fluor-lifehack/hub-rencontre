<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Support\Str;

class ActivityLogObserver
{
    /**
     * Handle the ActivityLog "creating" event.
     */
    public function creating(ActivityLog $activityLog): void
    {
        if (empty($activityLog->uuid)) {
            $activityLog->uuid = Str::uuid();
        }
    }

    /**
     * Handle the ActivityLog "created" event.
     */
    public function created(ActivityLog $activityLog): void
    {
        //
    }

    /**
     * Handle the ActivityLog "updating" event.
     */
    public function updating(ActivityLog $activityLog): void
    {
        //
    }

    /**
     * Handle the ActivityLog "updated" event.
     */
    public function updated(ActivityLog $activityLog): void
    {
        //
    }

    /**
     * Handle the ActivityLog "deleting" event.
     */
    public function deleting(ActivityLog $activityLog): void
    {
        //
    }

    /**
     * Handle the ActivityLog "deleted" event.
     */
    public function deleted(ActivityLog $activityLog): void
    {
        //
    }

    /**
     * Handle the ActivityLog "restored" event.
     */
    public function restored(ActivityLog $activityLog): void
    {
        //
    }

    /**
     * Handle the ActivityLog "force deleted" event.
     */
    public function forceDeleted(ActivityLog $activityLog): void
    {
        //
    }
}
