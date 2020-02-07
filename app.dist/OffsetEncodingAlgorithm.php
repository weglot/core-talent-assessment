<?php

include_once("./EncodingAlgorithm.php");
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

        // return '';

            $offset = 13;
            $result = "";
  
            // calcul la taille de la chaine 
            for ($i = 0; $i < strlen($text); $i++) 
            { 
                  
                //Crypte chaque lettre en majuscule
                if (ctype_upper($text[$i])) { 
                    $result = $result.chr((ord($text[$i]) +  
                                    $offset - 65) % 26 + 65); 
        
                // Crypte chaque lettre en minuscule 
                }else
                $result = $result.chr((ord($text[$i]) +  
                                $offset - 97) % 26 + 97); 
            } 
        
            // Retourne le resultat sous forme de string
            return $result; 


        }
    
}


//$text = "Hell";
//$offset = 5;
//$objet = new OffsetEncodingAlgorithm();
//var_dump($objet->encode($text));