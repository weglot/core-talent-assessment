<?php

use Google\Cloud\Translate\V2\TranslateClient;

class Translate
{
    /** @var TranslateClient */
    private $client;

    public function __construct()
    {
        $this->client = new TranslateClient([
            'key' => 'AIzaSyDpjkvttfk-lZtZgoq_7KhrC6VIQAbiVdQ'
        ]);
    }

    /**
     * Return bool to know if language pair is supported.
     */
    public function isSupported(string $sourceLanguage, string $targetLanguage): bool
    {
        $supported = $this->client->languages();

        if (!in_array($sourceLanguage, $supported)) {
            return false;
        }

        $localized = $this->client->localizedLanguages([
            'target' => $sourceLanguage,
        ]);

        foreach ($localized as $language) {
            if ($language['code'] === $targetLanguage) {
                return true;
            }
        }

        return false;
    }

    /**
     * Translate a sentence in a source language to a target language.
     * A glossary can be used to ignore a word or translate by a defined word.
     * Examples:
     *      glossary: [['Hello' => 'Hello']] input: 'Hello Thomas' output: 'Hello Thomas'
     *      glossary: [['Hello' => 'Bye Bye']] input: 'Hello Thomas' output: 'Bye Bye Thomas'
     */
    public function translate(string $sentence, string $sourceLanguage, string $targetLanguage, ?array $glossary = null): string
    {
        if (!$this->isSupported($sourceLanguage, $targetLanguage)) {
            throw new InvalidArgumentException(sprintf('This language pair is not supported.'));
        }
        
        $options = [
            'source' => $sourceLanguage,
            'target' => $targetLanguage,
        ];

        if ($glossary !== null) {
            foreach ($glossary as $item) {
                $word = array_keys($item)[0];
                $replacement = array_values($item)[0];

                // Mark glossay replaced words as no translate
                $sentence = preg_replace("/\b$word\b/", sprintf('<span class="notranslate">%s</span>', $replacement), $sentence);
            }
        }
        
        $output = $this->client->translate($sentence, $options)['text'] ?? $sentence;

        // Remove all founded no translate spans from the output
        $countNoTranslatesToRemove = substr_count($output, 'notranslate');
        for ($i = 0; $i < $countNoTranslatesToRemove; $i++) {
            $output = preg_replace('/\<span class=\"notranslate\"\>(.*)\<\/span\>/', '$1', $output);
        }

        return $output;
    }

    /**
     * Translate sentences in a source language to a target language.
     * A glossary can be used to ignore a word or translate by a defined word.
     */
    public function multiTranslate(array $sentences, string $sourceLanguage, string $targetLanguage, ?array $glossary = null): array
    {
        $results = [];
        foreach ($sentences as $sentence) {
            $results[] = $this->translate($sentence, $sourceLanguage, $targetLanguage, $glossary);
        }

        return $results;
    }
}