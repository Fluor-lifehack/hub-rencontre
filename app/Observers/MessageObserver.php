<?php

namespace App\Observers;

use App\Models\Message;
use Illuminate\Support\Str;

class MessageObserver
{
    /**
     * Handle the Message "creating" event.
     */
    public function creating(Message $message): void
    {
        if (empty($message->uuid)) {
            $message->uuid = Str::uuid();
        }
    }

    /**
     * Handle the Message "created" event.
     */
    public function created(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "updating" event.
     */
    public function updating(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "updated" event.
     */
    public function updated(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "deleting" event.
     */
    public function deleting(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "deleted" event.
     */
    public function deleted(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "restored" event.
     */
    public function restored(Message $message): void
    {
        //
    }

    /**
     * Handle the Message "force deleted" event.
     */
    public function forceDeleted(Message $message): void
    {
        //
    }
}
