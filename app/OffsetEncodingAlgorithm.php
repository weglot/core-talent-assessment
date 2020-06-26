<?php

/**
 * Class OffsetEncodingAlgorithm
 */
class OffsetEncodingAlgorithm implements EncodingAlgorithm
{
    /**
     * Lookup string
     */
    const CHARACTERS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @var int
     */
    private $offset;

    /**
     * @param int $offset
     */
    public function __construct($offset = 13)
    {
        $this->offset = $offset;
    }

    /**
     * Encodes text by shifting each character (existing in the lookup string) by an offset (provided in the constructor)
     * Examples:
     *      offset = 1, input = "a", output = "b"
     *      offset = 2, input = "z", output = "B"
     *      offset = 1, input = "Z", output = "a"
     *
     * @param string $text
     * @return string
     */
    public function encode($text)
    {
        /**
         * @TODO: Implement it
         */
        $newArray = array();
        $stringToArray = $this->stringToArray($text);
        $stringToArrayCharacters = $this->stringToArray(self::CHARACTERS);
        foreach ($stringToArray as $string ){
            $positionCaracter = strpos(self::CHARACTERS,$string);

            if ( $positionCaracter === false){
                array_push($newArray, $string);
            } else {
                $firstPart = array_slice($stringToArrayCharacters, $positionCaracter);
                $secondPart = array_slice($stringToArrayCharacters, 0, $positionCaracter);
                $arrayMerged = array_merge($firstPart, $secondPart);
                array_push($newArray, $arrayMerged[$this->offset]);
            }
        }
        $textEncoded = implode($newArray);

        return $textEncoded;
    }

    public function stringToArray($s)
    {
        $r = array();
        for($i=0; $i<strlen($s); $i++)
            $r[$i] = $s[$i];
        return $r;
    }
}