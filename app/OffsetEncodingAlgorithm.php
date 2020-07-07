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

        $newText = '';
        $characters = OffsetEncodingAlgorithm::CHARACTERS;
        if (strlen($text)) {
            foreach (str_split($text) as $value) {
                $pos = strpos($characters, $value);
                
                if ($pos !== false) {
                    $newPos = $this->offset + $pos;
                    
                    if ($newPos < strlen($characters)) {
                        $newText .= $characters[$newPos];
                    } else {
                        $posAfterLoop = $newPos - (strlen($characters) - 1);
                    
                        $newText .= $characters[$posAfterLoop - 1];
                    }
                } else {
                    $newText .= $value;
                }
            }
        }

        return $newText;
    }

}