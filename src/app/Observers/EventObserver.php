<?php

namespace App\Observers;

use App\Orm\Event;
use Illuminate\Support\Facades\Log;

class EventObserver
{

    use OrmDefaultTranslationTrait;

    /**
     * Handle the app orm event "created" event.
     *
     * @param Event $event
     * @return void
     */
    public function created(Event $event)
    {

        if ($this->shouldTranslate()) {
            $this->addDefaultTranslation($event);
        }

        Log::info('Created a new Event', [
            'id' => $event->id
        ]);
    }


    /**
     * Handle the event "creating" event.
     *
     * @param \App\Orm\Event $event
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
     * @param \App\Orm\Event $event
     * @return void
     */
    public function updated(Event $event)
    {
        Log::info('Updated details of an Event', [
            'id' => $event->id
        ]);
    }

    /**
     * Handle the event "deleted" event.
     *
     * @param \App\Orm\Event $event
     * @return void
     */
    public function deleted(Event $event)
    {
        Log::info('Marked an Event as deleted', [
            'id' => $event->id
        ]);
    }

    /**
     * Handle the event "restored" event.
     *
     * @param \App\Orm\Event $event
     * @return void
     */
    public function restored(Event $event)
    {
        //
    }

    /**
     * Handle the event "force deleted" event.
     *
     * @param \App\Orm\Event $event
     * @return void
     */
    public function forceDeleted(Event $event)
    {
        //
    }
}
