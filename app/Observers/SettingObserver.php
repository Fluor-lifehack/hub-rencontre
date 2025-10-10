<?php

namespace App\Observers;

use App\Models\Setting;
use Illuminate\Support\Str;

class SettingObserver
{
    /**
     * Handle the Setting "creating" event.
     */
    public function creating(Setting $setting): void
    {
        if (empty($setting->uuid)) {
            $setting->uuid = Str::uuid();
        }
    }

    /**
     * Handle the Setting "created" event.
     */
    public function created(Setting $setting): void
    {
        //
    }

    /**
     * Handle the Setting "updating" event.
     */
    public function updating(Setting $setting): void
    {
        //
    }

    /**
     * Handle the Setting "updated" event.
     */
    public function updated(Setting $setting): void
    {
        //
    }

    /**
     * Handle the Setting "deleting" event.
     */
    public function deleting(Setting $setting): void
    {
        //
    }

    /**
     * Handle the Setting "deleted" event.
     */
    public function deleted(Setting $setting): void
    {
        //
    }

    /**
     * Handle the Setting "restored" event.
     */
    public function restored(Setting $setting): void
    {
        //
    }

    /**
     * Handle the Setting "force deleted" event.
     */
    public function forceDeleted(Setting $setting): void
    {
        //
    }
}
