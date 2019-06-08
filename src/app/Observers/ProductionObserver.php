<?php

namespace App\Observers;

use App\Orm\Production;
use App\Orm\ProductionTranslation;
use Illuminate\Support\Facades\App;
use JoggApp\GoogleTranslate\GoogleTranslate;

class ProductionObserver
{
    /**
     * @var GoogleTranslate
     */
    private $translator;

    /**
     * ProductionObserver constructor.
     * @param GoogleTranslate $translator
     */
    public function __construct(GoogleTranslate $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Handle the app orm production "created" event.
     *
     * @param  Production $production
     * @return void
     */
    public function created(Production $production)
    {

        // If locale is not the fallback (en), add a default en translation
        if (!App::isLocale(config('app.fallback_locale'))) {
            $this->addDefaultTranslation($production);
        }
    }

    /**
     * Create a new Translation for the fallback_locale
     *
     * @param Production $production
     */
    private function addDefaultTranslation(Production $production)
    {
        $defaultLocale = config('app.fallback_locale');

        $translation = $production->getNewTranslation($defaultLocale);
        $translation->production_id = $production->id;
        $translation->title = $this->translator->justTranslate($production->title, $defaultLocale);
        $translation->description = $this->translator->justTranslate($production->description, $defaultLocale);
        $translation->excerpt = $this->translator->justTranslate($production->excerpt, $defaultLocale);
        $translation->auto_translated = 1;

        $translation->save();
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
     * @param  Production $appOrmProduction
     * @return void
     */
    public function updated(Production $appOrmProduction)
    {
        //
    }

    /**
     * Handle the app orm production "deleted" event.
     *
     * @param  Production $appOrmProduction
     * @return void
     */
    public function deleted(Production $appOrmProduction)
    {
        //
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
