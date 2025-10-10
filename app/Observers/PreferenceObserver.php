<?php

namespace App\Observers;

use App\Models\Preference;
use Illuminate\Support\Str;

class PreferenceObserver
{
    /**
     * Handle the Preference "creating" event.
     */
    public function creating(Preference $preference): void
    {
        if (empty($preference->uuid)) {
            $preference->uuid = Str::uuid();
        }
    }

    /**
     * Handle the Preference "created" event.
     */
    public function created(Preference $preference): void
    {
        //
    }

    /**
     * Handle the Preference "updating" event.
     */
    public function updating(Preference $preference): void
    {
        //
    }

    /**
     * Handle the Preference "updated" event.
     */
    public function updated(Preference $preference): void
    {
        //
    }

    /**
     * Handle the Preference "deleting" event.
     */
    public function deleting(Preference $preference): void
    {
        //
    }

    /**
     * Handle the Preference "deleted" event.
     */
    public function deleted(Preference $preference): void
    {
        //
    }

    /**
     * Handle the Preference "restored" event.
     */
    public function restored(Preference $preference): void
    {
        //
    }

    /**
     * Handle the Preference "force deleted" event.
     */
    public function forceDeleted(Preference $preference): void
    {
        //
    }
}
