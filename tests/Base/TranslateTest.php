<?php

namespace Base;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Translate;

/**
 * Class TranslateTest
 */
class TranslateTest extends TestCase
{
    private $translate;

    /**
     * TranslateTest constructor.
     * @param null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        $this->translate = new Translate();
        parent::__construct($name, $data, $dataName);
    }

    /**
     * @dataProvider getIsSupported
     * @param string $sourceLanguage
     * @param string $targetLanguage
     * @param bool $expected
     */
    public function testIsSupported(string $sourceLanguage, string $targetLanguage, bool $expected)
    {
        $this->assertEquals($this->translate->isSupported($sourceLanguage, $targetLanguage), $expected);
    }

    /**
     * @dataProvider getToTranslate
     * @param string $sentence
     * @param string $sourceLanguage
     * @param string $targetLanguage
     * @param array $expected
     * @param array $glossary
     */
    public function testTranslate(string $sentence, string $sourceLanguage, string $targetLanguage, array $expected, array $glossary)
    {
        $translated = $this->translate->translate($sentence, $sourceLanguage, $targetLanguage, $glossary);
        $this->assertContains($translated, $expected);
    }

    /**
     * @dataProvider getToMultiTranslate
     * @param array $sentences
     * @param string $sourceLanguage
     * @param string $targetLanguage
     * @param array $expected
     * @param array $glossary
     */
    public function testMultiTranslate(array $sentences, string $sourceLanguage, string $targetLanguage, array $expected, array $glossary)
    {
        $translated = $this->translate->multiTranslate($sentences, $sourceLanguage, $targetLanguage, $glossary);
        $this->assertIsArray($translated);
        $this->assertSameSize($sentences, $translated);
        foreach ($translated as $key => $item) {
            $this->assertContains($item, $expected[$key]);
        }

    }

    public function testTranslateWithBadParams()
    {
        $this->expectExceptionMessage('This language pair is not supported.');
        $this->translate->translate('Hello', 'en', 'zz');

    }

    /**
     * @return array
     */
    public function getIsSupported()
    {
        return [
            ['en', 'fr', true],
            ['en', 'en', true],
            ['aa', 'ht', false],
            ['zz', 'fr', false],
            ['en', 'zz', false]
        ];
    }

    /**
     * @return array
     */
    public function getToTranslate()
    {
        return [
            ['Hello', 'en', 'fr', ['Salut', 'Bonjour'], []],
            ['Hello Thomas', 'en', 'fr', ['Salut Thomas', 'Bonjour Thomas'], []],
            ['Hello', 'en', 'it', ['Ciao'], []],
            ['<strong class="cl">Hello</strong>', 'en', 'it', ['<strong class="cl">Ciao</strong>'], []],
            ['Hello', 'en', 'it', ['Hello'], [['Hello' => 'Hello']]],
            ['Hello Thomas', 'en', 'fr', ['Bonjour Thomas'], [['Hello' => 'Bonjour']]],
            ['Ceci est mon nom de marque dans une phrase.', 'fr', 'en', ['This is my nom de marque in a sentence.'], [['nom de marque' => 'nom de marque']]],
            ['Ceci est mon nom de marque dans une phrase.', 'fr', 'en', ['This is my nom de marque in a sentence.'], [['nom de marque' => 'nom de marque'], ['marque' => 'marque']]]
        ];
    }

    /**
     * @return array
     */
    public function getToMultiTranslate()
    {
        return [
            [['Hello', 'Hello'], 'en', 'fr', [['Salut', 'Bonjour'], ['Salut', 'Bonjour']], []],
            [['Hello', 'Home'], 'en', 'fr', [['Salut', 'Bonjour'], ['Maison', 'Accueil']], []],
            [['Hello Thomas'], 'en', 'fr', [['Bonjour Thomas']], [['Hello' => 'Bonjour']]],
            [['Ceci est mon nom de marque dans une phrase.'], 'fr', 'en', [['This is my nom de marque in a sentence.']], [['nom de marque' => 'nom de marque']]]
        ];
    }
}
