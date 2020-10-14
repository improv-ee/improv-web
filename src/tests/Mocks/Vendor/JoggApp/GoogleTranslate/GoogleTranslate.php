<?php

namespace Tests\Mocks\Vendor\JoggApp\GoogleTranslate;

use JoggApp\GoogleTranslate\GoogleTranslateClient;

/**
 * Mocked version of the vendor class for unit tests
 *
 * Does not actually make any calls to external API
 *
 * @package Tests\Mocks\Vendor\JoggApp\GoogleTranslate
 */
class GoogleTranslate extends \JoggApp\GoogleTranslate\GoogleTranslate
{
    public function __construct(GoogleTranslateClient $client = null)
    {

    }

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
        $translations = [];
        foreach ($input as $row) {
            $translations[] = $this->detectLanguage($row);
        }

        return $translations;
    }
    public function translate($input, $to = null, $format = 'text'): array
    {

        if (is_array($input)) {
            return $this->translateBatch($input);
        }


        return [
            'source_text' => $input,
            'source_language_code' => 'en',
            'translated_text' => 'mock-translated-' . $input,
            'translated_language_code' => 'et'
        ];
    }

    public function justTranslate(string $input, $to = null): string
    {
        return 'mock-translated-' . $input;
    }

    public function translateBatch(array $input, string $translateTo, $format = 'text'): array
    {
        $translations = [];

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
        return $input;
    }


}
