<?php

namespace App\Observers;

use App\Models\UserMatch;
use Illuminate\Support\Str;

class UserMatchObserver
{
    /**
     * Handle the UserMatch "creating" event.
     */
    public function creating(UserMatch $userMatch): void
    {
        if (empty($userMatch->uuid)) {
            $userMatch->uuid = Str::uuid();
        }
    }

    /**
     * Handle the UserMatch "created" event.
     */
    public function created(UserMatch $userMatch): void
    {
        //
    }

    /**
     * Handle the UserMatch "updating" event.
     */
    public function updating(UserMatch $userMatch): void
    {
        //
    }

    /**
     * Handle the UserMatch "updated" event.
     */
    public function updated(UserMatch $userMatch): void
    {
        //
    }

    /**
     * Handle the UserMatch "deleting" event.
     */
    public function deleting(UserMatch $userMatch): void
    {
        //
    }

    /**
     * Handle the UserMatch "deleted" event.
     */
    public function deleted(UserMatch $userMatch): void
    {
        //
    }

    /**
     * Handle the UserMatch "restored" event.
     */
    public function restored(UserMatch $userMatch): void
    {
        //
    }

    /**
     * Handle the UserMatch "force deleted" event.
     */
    public function forceDeleted(UserMatch $userMatch): void
    {
        //
    }
}
