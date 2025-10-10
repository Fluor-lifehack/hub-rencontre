<?php

namespace App\Observers;

use App\Models\Subscription;
use Illuminate\Support\Str;

class SubscriptionObserver
{
    /**
     * Handle the Subscription "creating" event.
     */
    public function creating(Subscription $subscription): void
    {
        if (empty($subscription->uuid)) {
            $subscription->uuid = Str::uuid();
        }
    }

    /**
     * Handle the Subscription "created" event.
     */
    public function created(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "updating" event.
     */
    public function updating(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "updated" event.
     */
    public function updated(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "deleting" event.
     */
    public function deleting(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "deleted" event.
     */
    public function deleted(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "restored" event.
     */
    public function restored(Subscription $subscription): void
    {
        //
    }

    /**
     * Handle the Subscription "force deleted" event.
     */
    public function forceDeleted(Subscription $subscription): void
    {
        //
    }
}
