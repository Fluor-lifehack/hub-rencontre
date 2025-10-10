<?php

namespace App\Observers;

use App\Models\Conversation;
use Illuminate\Support\Str;

class ConversationObserver
{
    /**
     * Handle the Conversation "creating" event.
     */
    public function creating(Conversation $conversation): void
    {
        if (empty($conversation->uuid)) {
            $conversation->uuid = Str::uuid();
        }
    }

    /**
     * Handle the Conversation "created" event.
     */
    public function created(Conversation $conversation): void
    {
        //
    }

    /**
     * Handle the Conversation "updating" event.
     */
    public function updating(Conversation $conversation): void
    {
        //
    }

    /**
     * Handle the Conversation "updated" event.
     */
    public function updated(Conversation $conversation): void
    {
        //
    }

    /**
     * Handle the Conversation "deleting" event.
     */
    public function deleting(Conversation $conversation): void
    {
        //
    }

    /**
     * Handle the Conversation "deleted" event.
     */
    public function deleted(Conversation $conversation): void
    {
        //
    }

    /**
     * Handle the Conversation "restored" event.
     */
    public function restored(Conversation $conversation): void
    {
        //
    }

    /**
     * Handle the Conversation "force deleted" event.
     */
    public function forceDeleted(Conversation $conversation): void
    {
        //
    }
}
