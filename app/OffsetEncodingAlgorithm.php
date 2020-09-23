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

    private function checkIsAlphabeticCharacter(string $character): bool
    {
        return preg_match("/[a-zA-Z]$/", $character);
    }

    private function getNewPosition(string $character): int
    {
        $position = strpos(self::CHARACTERS, $character);
        $positionNewCharacter = $position + $this->offset;

        //we want to return to the begin (index 0) when we are at the end of the haystack
        $positionNewCharacter %= strlen(self::CHARACTERS);

        return $positionNewCharacter;
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
    public function encode(string $text): string
    {
        $textEncoded = '';

        $characters = str_split($text, 1);

        foreach ($characters as $character)
        {
            if ($character === ''){
                continue;
            }
            if ($this->checkIsAlphabeticCharacter($character)){
                $positionNewCharacter = $this->getNewPosition($character);
                $newCharacter = substr(self::CHARACTERS, $positionNewCharacter, 1);
            } else {
                $newCharacter = $character;
            }

            $textEncoded .= $newCharacter;
        }

        return $textEncoded;
    }
}