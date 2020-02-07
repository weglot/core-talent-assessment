<?php

/**
 *  Class CompositeEncodingAlgorithm
 */
class CompositeEncodingAlgorithm implements EncodingAlgorithm
{
    /**
     * @var EncodingAlgorithm[]
     */
    private $algorithms;

    /**
     *  CompositeEncodingAlgorithm constructor
     */
    public function __construct()
    {
        $this->algorithms = array();
    }

    /**
     * @param EncodingAlgorithm $algorithm
     */
    public function add(EncodingAlgorithm $algorithm)
    {
        $this->algorithms[] = $algorithm;
    }

    /**
     *  Encodes text using multiple Encoders stored in $this->algorithms (in orders encoders were added)
     *
     * @param string $text
     * @return string
     * http://www.writephponline.com/
     */
    public function encode($text)
    {
        /**
         * @TODO: Implement it
         */
        
        // return '';

        $this->algorithms[0].encode($text);
        $this->algorithms[1].encode($text);
        
        
    
    }
}
