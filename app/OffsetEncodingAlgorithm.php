<?php

class OffsetEncodingAlgorithm
{
    private const CHARACTERS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * @var int
     */
    private $offset;

    public function __construct(int $offset = 13)
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
    public function encode(string $text): string
    {
        $input = str_split($text);
        $output = '';
        $lookupLength = strlen(self::CHARACTERS);

        foreach ($input as $char) {
            if ($char === '') {
                continue;
            }
            
            if (($index = strpos(self::CHARACTERS, $char)) === false) {
                $output .= $char;
                continue;
            }

            $output .= self::CHARACTERS[($index + $this->offset) % $lookupLength];
        }

        return $output;
    }
}
