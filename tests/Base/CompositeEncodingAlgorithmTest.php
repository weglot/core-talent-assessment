<?php

namespace Base;

use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophecy\ProphecySubjectInterface;
use Prophecy\Prophet;

/**
 * Class CompositeEncodingAlgorithmTest
 * @package verify_pack
 */
class CompositeEncodingAlgorithmTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Prophet
     */
    private $prophet;

    protected function setup(): void
    {
        $this->prophet = new Prophet();
    }

    public function testComposedAlgorithmsAreCalled(): void
    {
        /** @var \EncodingAlgorithm $algorithmA */
        $algorithmA = $this->prophet->prophesize(\EncodingAlgorithm::class);
        /** @var \EncodingAlgorithm $algorithmB */
        $algorithmB = $this->prophet->prophesize(\EncodingAlgorithm::class);

        $algorithmA->encode("plain text")->shouldBeCalledOnce()->willReturn("encoded text");
        $algorithmB->encode("encoded text")->shouldBeCalledOnce()->willReturn("text encoded twice");

        $algorithm = new \CompositeEncodingAlgorithm();
        $algorithm->add($algorithmA->reveal());
        $algorithm->add($algorithmB->reveal());

        $this->assertSame("text encoded twice", $algorithm->encode("plain text"));
    }

    protected function tearDown(): void
    {
        $this->prophet->checkPredictions();
    }
}