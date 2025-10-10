<?php

namespace App\Observers;

use App\Models\Photo;
use Illuminate\Support\Str;

class PhotoObserver
{
    /**
     * Handle the Photo "creating" event.
     */
    public function creating(Photo $photo): void
    {
        if (empty($photo->uuid)) {
            $photo->uuid = Str::uuid();
        }
    }

    /**
     * Handle the Photo "created" event.
     */
    public function created(Photo $photo): void
    {
        //
    }

    /**
     * Handle the Photo "updating" event.
     */
    public function updating(Photo $photo): void
    {
        //
    }

    /**
     * Handle the Photo "updated" event.
     */
    public function updated(Photo $photo): void
    {
        //
    }

    /**
     * Handle the Photo "deleting" event.
     */
    public function deleting(Photo $photo): void
    {
        //
    }

    /**
     * Handle the Photo "deleted" event.
     */
    public function deleted(Photo $photo): void
    {
        //
    }

    /**
     * Handle the Photo "restored" event.
     */
    public function restored(Photo $photo): void
    {
        //
    }

    /**
     * Handle the Photo "force deleted" event.
     */
    public function forceDeleted(Photo $photo): void
    {
        //
    }
}
