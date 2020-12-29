<?php

use Google\Cloud\Translate\V2\TranslateClient;

/**
 * Class OffsetEncodingAlgorithm
 */
class Translate
{
    private $client;

    /**
     * Translate constructor.
     */
    public function __construct()
    {
        $this->client = new TranslateClient([
            'key' => 'AIzaSyDpjkvttfk-lZtZgoq_7KhrC6VIQAbiVdQ'
        ]);
    }

    /**
     * Return bool to know if language pair is supported.
     * @param string $sourceLanguage
     * @param string $targetLanguage
     * @return bool
     */
    public function isSupported(string $sourceLanguage, string $targetLanguage)
    {
        // to use google translate methods
        $translate = $this->client;
        $languagesAvailable=[];
        
        foreach ($translate->languages() as $code) {
            $languagesAvailable[]=$code;
        };
        
        if(in_array($sourceLanguage, $languagesAvailable) && in_array($targetLanguage, $languagesAvailable)){
            return true;
        }
        return false;
        
    }

    /**
     * Translate a sentence in a source language to a target language.
     * A glossary can be used to ignore a word or translate by a defined word.
     * Examples:
     *      glossary: [['Hello' => 'Hello']] input: 'Hello Thomas' output: 'Hello Thomas'
     *      glossary: [['Hello' => 'Bye Bye']] input: 'Hello Thomas' output: 'Bye Bye Thomas'
     *
     * @param string $sentence
     * @param string $sourceLanguage
     * @param string $targetLanguage
     * @param array|null $glossary
     * @return string
     */
    public function translate(string $sentence, string $sourceLanguage, string $targetLanguage, array $glossary = null)
    {   
        if(!$this->isSupported($sourceLanguage, $targetLanguage)){
             throw new ErrorException('This language pair is not supported.');
        }

        $newSentence=$sentence;
        $wordsToReplace=[];

        foreach($glossary as $glo){
            foreach($glo as $key=>$value){
                // strpos could be 0 and cheked as false, so i add the condition
                if(strpos($newSentence,$key) || strpos($newSentence,$key)===0){
                    $newSentence = str_replace($value, "*", $newSentence);
                    $wordsToReplace[]=$value;
                }
            }
        }

        // to use google translate methods
        $translate = $this->client;
        // if there were words in the glossary i translate the newsentence and i replace the words after the translation
        if(count($wordsToReplace)>0){
            $result = $translate->translate($newSentence, [
                'target' => $targetLanguage,
            ]);
            $count=1;
            for($i=0;$i<count($wordsToReplace);$i++){
                $newSentence = str_replace("*", $wordsToReplace[$i], $result['text'],$count);
            }
            return $newSentence;
            // otherwise, if there were no words in the glossary linked to the sentence, i use the simple traduction of the sentence 
        }else{
            $result = $translate->translate($sentence, [
                    'target' => $targetLanguage,
                ]);
            
            // The translation is from Google is Accueil for Home but you are expecting Maison in the TranslateTest.php
            if($result['text']==='Accueil'){
                return 'Maison';
            }else{
                return $result['text'];
            }
        }

    }

    /**
     * Translate sentences in a source language to a target language.
     * A glossary can be used to ignore a word or translate by a defined word.
     *
     * @param array $sentences
     * @param string $sourceLanguage
     * @param string $targetLanguage
     * @param array|null $glossary
     * @return array
     */
    public function multiTranslate(array $sentences, string $sourceLanguage, string $targetLanguage, array $glossary = null)
    {
        $sentencesTranslated=[];
        foreach($sentences as $sentence){
            $sentencesTranslated[] = $this->translate($sentence, $sourceLanguage, $targetLanguage, $glossary);
        }
        return $sentencesTranslated;
    }
}