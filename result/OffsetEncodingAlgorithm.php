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
        $output_string = '';
        $characters_length = strlen(self::CHARACTERS);
        $offset = $this->offset;

        for ($i = 0, $length = strlen($text); $i < $length; $i++)
        {
            $position = strpos(self::CHARACTERS, $text[$i]) + $offset;

            if ($position > $characters_length)
            {
                $position = $position - $characters_length;
            }

            $output_string .= self::CHARACTERS[$position];
        }

        return '';
    }
}
