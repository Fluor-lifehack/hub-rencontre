<?php

namespace App\Observers;

use App\Models\Notification;
use Illuminate\Support\Str;

class NotificationObserver
{
    /**
     * Handle the Notification "creating" event.
     */
    public function creating(Notification $notification): void
    {
        if (empty($notification->uuid)) {
            $notification->uuid = Str::uuid();
        }
    }

    /**
     * Handle the Notification "created" event.
     */
    public function created(Notification $notification): void
    {
        //
    }

    /**
     * Handle the Notification "updating" event.
     */
    public function updating(Notification $notification): void
    {
        //
    }

    /**
     * Handle the Notification "updated" event.
     */
    public function updated(Notification $notification): void
    {
        //
    }

    /**
     * Handle the Notification "deleting" event.
     */
    public function deleting(Notification $notification): void
    {
        //
    }

    /**
     * Handle the Notification "deleted" event.
     */
    public function deleted(Notification $notification): void
    {
        //
    }

    /**
     * Handle the Notification "restored" event.
     */
    public function restored(Notification $notification): void
    {
        //
    }

    /**
     * Handle the Notification "force deleted" event.
     */
    public function forceDeleted(Notification $notification): void
    {
        //
    }
}
