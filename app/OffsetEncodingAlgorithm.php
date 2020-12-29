<?php

/**
 * Class OffsetEncodingAlgorithm
 */
class OffsetEncodingAlgorithm
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
    public function encode(string $text)
    {   
        $off = $this->offset;
        // if text is empty, no need to encode
        if($off===0 || strlen($text)===0){
            return $text;
        }
        $ch= self::CHARACTERS;
        $chTable=str_split($ch);
        $table=str_split($text);
        // we get the position and we replace the character by the other with the offset parameter (modulo to not go over the string)
        for($i=0;$i<count($table);$i++){
            if(in_array($table[$i], $chTable)){
                $pos = strpos($ch, $table[$i]);
                $table[$i]=$ch[($pos+$off)%52];
            }
        }
        $newtext="";
        for($i=0;$i<count($table);$i++){
            $newtext=$newtext.$table[$i];
        }
        return $newtext;
    }
}
