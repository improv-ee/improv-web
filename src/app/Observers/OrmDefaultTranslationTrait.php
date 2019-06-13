<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use JoggApp\GoogleTranslate\GoogleTranslate;

trait OrmDefaultTranslationTrait
{

    /**
     * @return GoogleTranslate
     */
    public function getTranslatorInstance(): GoogleTranslate
    {
        return resolve(GoogleTranslate::class);
    }

    /**
     * We should create a default translation, if the ORM object we're saving is using
     * a custom locale (not app.fallback_locale) - then, translate the foreign language
     * into the default (English)
     *
     * @return bool
     */
    public function shouldTranslate(): bool
    {
        // If locale is not the fallback (en), add a default en translation
        return !App::isLocale(config('app.fallback_locale'));
    }


    /**
     * Create a new app.fallback_locale Translation of the Translatable ORM model
     *
     * @param Model $orm
     */
    public function addDefaultTranslation(Model $orm): void
    {
        $defaultLocale = config('app.fallback_locale');

        $translator = $this->getTranslatorInstance();
        $translation = $orm->getNewTranslation($defaultLocale);

        foreach ($orm->translatedAttributes as $attribute) {
            if (!$orm->{$attribute}) {
                continue;
            }
            $translation->{$attribute} = $translator->justTranslate($orm->{$attribute}, $defaultLocale);
        }

        $translation->auto_translated = 1;
        $orm->translations()->save($translation);
    }
}