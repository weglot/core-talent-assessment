<?php

namespace Base;

use PHPUnit\Framework\TestCase;

/**
 * Class OffsetEncodingAlgorithmTest
 */
class OffsetEncodingAlgorithmTest extends TestCase
{
    /**
     * @dataProvider getTexts
     * @param $offset
     * @param $text
     * @param $encoded
     */
    public function testValidEncoding($offset, $text, $encoded)
    {
        $algorithm = new \OffsetEncodingAlgorithm($offset);

        $this->assertEquals($encoded, $algorithm->encode($text));
    }

    /**
     * @return array
     */
    public function getTexts()
    {
        return [
            [0, '', ''],
            [1, '', ''],
            [1, 'a', 'b'],
            [0, 'abc def.', 'abc def.'],
            [1, 'abc def.', 'bcd efg.'],
            [2, 'z', 'B'],
            [1, 'Z', 'a'],
            [26, 'abc def.', 'ABC DEF.'],
            [78, 'ABC DEF.', 'abc def.'],
        ];
    }
}