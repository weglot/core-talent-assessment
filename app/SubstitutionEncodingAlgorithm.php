<?php

/**
 * Class SubstitutionEncodingAlgorithm
 *  http://www.writephponline.com/
 */
class SubstitutionEncodingAlgorithm implements EncodingAlgorithm
{
    /**
     * @var array
     */
    private $substitutions;

    /**
     * SubstitutionEncodingAlgorithm constructor.
     * @param $substitutions
     */
    public function __construct(array $substitutions)
    {
        $this->substitutions = $substitutions;
    }

    /**
     * Encodes text by substituting character with another one provided in the pair.
     * For example pair "ab" defines all "a" chars will be replaced with "b" and all "b" chars will be replaced with "a"
     * Examples:
     *      substitutions = ["ab"], input = "aabbcc", output = "bbaacc"
     *      substitutions = ["ab", "cd"], input = "adam", output = "bcbm"
     *
     * @param string $text
     * @return string
     */
    public function encode($text)
    {
        /**
         * @TODO: Implement it
         */

        $trans = [];

        foreach($this->substitutions as $value){
            $trans[$value[0]] = $value[1];
            $trans[$value[1]] = $value[0];

            $trans[strtoupper($value[0])] = strtoupper($value[1]);
            $trans[strtoupper($value[1])] = strtoupper($value[0]);
        }

        return strtr($text, $trans);
    }
}