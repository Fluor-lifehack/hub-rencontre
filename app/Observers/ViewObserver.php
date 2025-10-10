<?php

namespace App\Observers;

use App\Models\View;
use Illuminate\Support\Str;

class ViewObserver
{
    /**
     * Handle the View "creating" event.
     */
    public function creating(View $view): void
    {
        if (empty($view->uuid)) {
            $view->uuid = Str::uuid();
        }
    }

    /**
     * Handle the View "created" event.
     */
    public function created(View $view): void
    {
        //
    }

    /**
     * Handle the View "updating" event.
     */
    public function updating(View $view): void
    {
        //
    }

    /**
     * Handle the View "updated" event.
     */
    public function updated(View $view): void
    {
        //
    }

    /**
     * Handle the View "deleting" event.
     */
    public function deleting(View $view): void
    {
        //
    }

    /**
     * Handle the View "deleted" event.
     */
    public function deleted(View $view): void
    {
        //
    }

    /**
     * Handle the View "restored" event.
     */
    public function restored(View $view): void
    {
        //
    }

    /**
     * Handle the View "force deleted" event.
     */
    public function forceDeleted(View $view): void
    {
        //
    }
}
