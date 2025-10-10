<?php

namespace App\Observers;

use App\Models\Block;
use Illuminate\Support\Str;

class BlockObserver
{
    /**
     * Handle the Block "creating" event.
     */
    public function creating(Block $block): void
    {
        if (empty($block->uuid)) {
            $block->uuid = Str::uuid();
        }
    }

    /**
     * Handle the Block "created" event.
     */
    public function created(Block $block): void
    {
        //
    }

    /**
     * Handle the Block "updating" event.
     */
    public function updating(Block $block): void
    {
        //
    }

    /**
     * Handle the Block "updated" event.
     */
    public function updated(Block $block): void
    {
        //
    }

    /**
     * Handle the Block "deleting" event.
     */
    public function deleting(Block $block): void
    {
        //
    }

    /**
     * Handle the Block "deleted" event.
     */
    public function deleted(Block $block): void
    {
        //
    }

    /**
     * Handle the Block "restored" event.
     */
    public function restored(Block $block): void
    {
        //
    }

    /**
     * Handle the Block "force deleted" event.
     */
    public function forceDeleted(Block $block): void
    {
        //
    }
}
