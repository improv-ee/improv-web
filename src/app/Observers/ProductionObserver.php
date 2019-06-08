<?php

namespace App\Observers;

use App\Orm\Production;

class ProductionObserver
{
    /**
     * Handle the app orm production "created" event.
     *
     * @param  \App\Orm\Production  $appOrmProduction
     * @return void
     */
    public function created(Production $appOrmProduction)
    {
        //
    }

    /**
     * Handle the app orm production "creating" event.
     *
     * @param  \App\Orm\Production $appOrmProduction
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
     * @param  \App\Orm\Production  $appOrmProduction
     * @return void
     */
    public function updated(Production $appOrmProduction)
    {
        //
    }

    /**
     * Handle the app orm production "deleted" event.
     *
     * @param  \App\Orm\Production  $appOrmProduction
     * @return void
     */
    public function deleted(Production $appOrmProduction)
    {
        //
    }

    /**
     * Handle the app orm production "restored" event.
     *
     * @param  \App\Orm\Production  $appOrmProduction
     * @return void
     */
    public function restored(Production $appOrmProduction)
    {
        //
    }

    /**
     * Handle the app orm production "force deleted" event.
     *
     * @param  \App\Orm\Production  $appOrmProduction
     * @return void
     */
    public function forceDeleted(Production $appOrmProduction)
    {
        //
    }
}
