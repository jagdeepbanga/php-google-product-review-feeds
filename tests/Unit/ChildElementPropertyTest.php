<?php

namespace JagdeepBanga\GoogleProductReviewFeed\Tests\Unit;

use JagdeepBanga\GoogleProductReviewFeed\Elements\ChildElementProperty;
use JagdeepBanga\GoogleProductReviewFeed\Tests\TestCase;

class ChildElementPropertyTest extends TestCase
{
    /** @test */
    public function can_generate_xml_data_array(): void
    {
        $properties = new ChildElementProperty('xml_key', 'value');

        $payload = $properties->getXmlStructure('');

        $this->assertEquals([
            'name' => 'xml_key',
            'value' => 'value',
        ], $payload);
    }
}