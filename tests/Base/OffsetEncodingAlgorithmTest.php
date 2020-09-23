<?php

namespace Base;

/**
 * Class OffsetEncodingAlgorithmTest
 * @package Base
 */
class OffsetEncodingAlgorithmTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getTexts
     * @param $offset
     * @param $text
     * @param $encoded
     */
    public function testValidEncoding(int $offset, string $text, string $encoded): void
    {
        $algorithm = new \OffsetEncodingAlgorithm($offset);

        $this->assertEquals($encoded, $algorithm->encode($text));
    }

    /**
     * @return array
     */
    public function getTexts(): iterable
    {
        return array(
            array(0, '', ''),
            array(1, '', ''),
            array(1, 'a', 'b'),
            array(0, 'abc def.', 'abc def.'),
            array(1, 'abc def.', 'bcd efg.'),
            array(2, 'z', 'B'),
            array(1, 'Z', 'a'),
            array(26, 'abc def.', 'ABC DEF.'),
            array(78, 'ABC DEF.', 'abc def.'),
        );
    }
}