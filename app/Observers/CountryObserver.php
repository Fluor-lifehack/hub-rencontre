<?php

namespace App\Observers;

use App\Models\Country;
use Illuminate\Support\Str;

class CountryObserver
{
    /**
     * Handle the Country "creating" event.
     */
    public function creating(Country $country): void
    {
        if (empty($country->uuid)) {
            $country->uuid = Str::uuid();
        }

        // Convertir le code en majuscules
        if (!empty($country->code)) {
            $country->code = strtoupper($country->code);
        }
    }

    /**
     * Handle the Country "created" event.
     */
    public function created(Country $country): void
    {
        //
    }

    /**
     * Handle the Country "updating" event.
     */
    public function updating(Country $country): void
    {
        // Convertir le code en majuscules lors de la mise à jour
        if (!empty($country->code)) {
            $country->code = strtoupper($country->code);
        }
    }

    /**
     * Handle the Country "updated" event.
     */
    public function updated(Country $country): void
    {
        //
    }

    /**
     * Handle the Country "deleting" event.
     */
    public function deleting(Country $country): void
    {
        //
    }

    /**
     * Handle the Country "deleted" event.
     */
    public function deleted(Country $country): void
    {
        //
    }

    /**
     * Handle the Country "restored" event.
     */
    public function restored(Country $country): void
    {
        //
    }

    /**
     * Handle the Country "force deleted" event.
     */
    public function forceDeleted(Country $country): void
    {
        //
    }
}
