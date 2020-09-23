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

    private function getSubstitutionFormated(string $substitution, array $substitutionFormated): array
    {
        $substitutionArray = str_split($substitution);

        //First we add cases for lower
        $substitutionFormated[$substitutionArray[0]] = $substitutionArray[1];
        $substitutionFormated[$substitutionArray[1]] = $substitutionArray[0];

        //And Finnaly we add cases for upper
        $substitutionFormated[strtoupper($substitutionArray[0])] = strtoupper($substitutionArray[1]);
        $substitutionFormated[strtoupper($substitutionArray[1])] = strtoupper($substitutionArray[0]);

        return $substitutionFormated;
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
    public function encode(string $text): string
    {
        $substitutionFormated = [];

        foreach ($this->substitutions as $substitution){
            $substitutionFormated = $this->getSubstitutionFormated($substitution, $substitutionFormated);
        }

        return strtr($text, $substitutionFormated);
    }
}