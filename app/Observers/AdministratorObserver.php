<?php

namespace App\Observers;

use App\Models\Administrator;
use Illuminate\Support\Str;

class AdministratorObserver
{
    /**
     * Handle the Administrator "creating" event.
     */
    public function creating(Administrator $administrator): void
    {
        if (empty($administrator->uuid)) {
            $administrator->uuid = Str::uuid();
        }
    }

    /**
     * Handle the Administrator "created" event.
     */
    public function created(Administrator $administrator): void
    {
        //
    }

    /**
     * Handle the Administrator "updating" event.
     */
    public function updating(Administrator $administrator): void
    {
        //
    }

    /**
     * Handle the Administrator "updated" event.
     */
    public function updated(Administrator $administrator): void
    {
        //
    }

    /**
     * Handle the Administrator "deleting" event.
     */
    public function deleting(Administrator $administrator): void
    {
        //
    }

    /**
     * Handle the Administrator "deleted" event.
     */
    public function deleted(Administrator $administrator): void
    {
        //
    }

    /**
     * Handle the Administrator "restored" event.
     */
    public function restored(Administrator $administrator): void
    {
        //
    }

    /**
     * Handle the Administrator "force deleted" event.
     */
    public function forceDeleted(Administrator $administrator): void
    {
        //
    }
}
