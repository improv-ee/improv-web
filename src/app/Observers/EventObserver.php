<?php

namespace App\Observers;

use App\Orm\Event;

class EventObserver
{
    /**
     * Handle the event "creating" event.
     *
     * @param  \App\Orm\Event $event
     * @return void
     * @throws \Exception
     */
    public function creating(Event $event)
    {
        $event->setToken();
    }

    /**
     * Handle the event "updated" event.
     *
     * @param  \App\Orm\Event  $event
     * @return void
     */
    public function updated(Event $event)
    {
        //
    }

    /**
     * Handle the event "deleted" event.
     *
     * @param  \App\Orm\Event  $event
     * @return void
     */
    public function deleted(Event $event)
    {
        //
    }

    /**
     * Handle the event "restored" event.
     *
     * @param  \App\Orm\Event  $event
     * @return void
     */
    public function restored(Event $event)
    {
        //
    }

    /**
     * Handle the event "force deleted" event.
     *
     * @param  \App\Orm\Event  $event
     * @return void
     */
    public function forceDeleted(Event $event)
    {
        //
    }
}