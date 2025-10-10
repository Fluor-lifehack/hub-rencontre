<?php

namespace App\Observers;

use App\Models\City;
use Illuminate\Support\Str;

class CityObserver
{
    /**
     * Handle the City "creating" event.
     */
    public function creating(City $city): void
    {
        if (empty($city->uuid)) {
            $city->uuid = Str::uuid();
        }
    }

    /**
     * Handle the City "created" event.
     */
    public function created(City $city): void
    {
        //
    }

    /**
     * Handle the City "updating" event.
     */
    public function updating(City $city): void
    {
        //
    }

    /**
     * Handle the City "updated" event.
     */
    public function updated(City $city): void
    {
        //
    }

    /**
     * Handle the City "deleting" event.
     */
    public function deleting(City $city): void
    {
        //
    }

    /**
     * Handle the City "deleted" event.
     */
    public function deleted(City $city): void
    {
        //
    }

    /**
     * Handle the City "restored" event.
     */
    public function restored(City $city): void
    {
        //
    }

    /**
     * Handle the City "force deleted" event.
     */
    public function forceDeleted(City $city): void
    {
        //
    }
}
