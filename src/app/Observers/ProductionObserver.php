<?php

namespace App\Observers;

use App\Orm\Production;
use Illuminate\Support\Facades\Log;

class ProductionObserver
{
    use OrmDefaultTranslationTrait;

    /**
     * Handle the app orm production "created" event.
     *
     * @param  Production $production
     * @return void
     */
    public function created(Production $production)
    {

        if ($this->shouldTranslate()) {
            $this->addDefaultTranslation($production);
        }

        Log::info('Created a new Production', [
            'id' => $production->id
        ]);
    }

    /**
     * Handle the app orm production "creating" event.
     *
     * @param  Production $appOrmProduction
     * @return void
     * @throws \Exception
     */
    public function creating(Production $production)
    {
        $production->setToken();
    }

    /**
     * Handle the app orm production "updated" event.
     *
     * @param  Production $production
     * @return void
     */
    public function updated(Production $production)
    {
        Log::info('Updated details of a Production', [
            'id' => $production->id
        ]);
    }

    /**
     * Handle the app orm production "deleted" event.
     *
     * @param  Production $production
     * @return void
     */
    public function deleted(Production $production)
    {
        Log::info('Marked a Production as deleted', [
            'id' => $production->id
        ]);
    }

    /**
     * Handle the app orm production "restored" event.
     *
     * @param  Production $appOrmProduction
     * @return void
     */
    public function restored(Production $appOrmProduction)
    {
        //
    }

    /**
     * Handle the app orm production "force deleted" event.
     *
     * @param  Production $appOrmProduction
     * @return void
     */
    public function forceDeleted(Production $appOrmProduction)
    {
        //
    }
}
