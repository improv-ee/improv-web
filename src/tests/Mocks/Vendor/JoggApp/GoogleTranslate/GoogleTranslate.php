<?php

namespace Tests\Mocks\Vendor\JoggApp\GoogleTranslate;

/**
 * Mocked version of the vendor class for unit tests
 *
 * Does not actually make any calls to external API
 *
 * @package Tests\Mocks\Vendor\JoggApp\GoogleTranslate
 */
class GoogleTranslate extends \JoggApp\GoogleTranslate\GoogleTranslate
{

    public function detectLanguage($input): array
    {
        if (is_array($input)) {
            return $this->detectLanguageBatch($input);
        }

        return [
            'text' => $input,
            'language_code' => 'en',
            'confidence' => 1
        ];
    }

    public function detectLanguageBatch(array $input): array
    {
       $translations=[];
        foreach ($input as $row) {
            $translations[] = $this->detectLanguage($row);
        }

        return $translations;
    }

    public function translate($input, $to = null): array
    {
        $translateTo = $to ?? config('googletranslate.default_target_translation');

        $translateTo = $this->sanitizeLanguageCode($translateTo);

        if (is_array($input)) {
            return $this->translateBatch($input, $translateTo);
        }


        return [
            'source_text' => $input,
            'source_language_code' => 'en',
            'translated_text' => 'mock-translated-'.$input,
            'translated_language_code' => $translateTo
        ];
    }

    public function justTranslate(string $input, $to = null): string
    {
        return 'mock-translated-'.$input;
    }

    public function translateBatch(array $input, string $translateTo): array
    {

        foreach ($input as $response) {
            $translations[] = [
                'source_text' => $response['input'],
                'source_language_code' => $response['source'],
                'translated_text' => $response['text'],
                'translated_language_code' => $translateTo
            ];
        }

        return $translations;
    }

    public function getAvaliableTranslationsFor(string $languageCode): array
    {
        return [];
    }

    public function unlessLanguageIs(string $languageCode, string $input, $to = null)
    {
        $translateTo = $to ?? config('googletranslate.default_target_translation');

        $translateTo = $this->sanitizeLanguageCode($translateTo);

        $languageCode = $this->sanitizeLanguageCode($languageCode);

        $languageMisMatch = $languageCode != $this->detectLanguage($input)['language_code'];

        if ($languageMisMatch) {
            return $this->translate($input, $translateTo);
        }

        return $input;
    }


}