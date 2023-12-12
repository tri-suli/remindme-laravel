<?php

namespace Tests\Unit\EAV\Values;

use App\EAV\Values\Description;
use PHPUnit\Framework\TestCase;

class DescriptionTest extends TestCase
{
    /** @test */
    public function it_can_get_description_value_as_string()
    {
        $value = new Description('simple description');

        $this->assertEquals('description: simple description', (string) $value);
    }

    /** @test */
    public function it_can_convert_description_value_as_array()
    {
        $value = new Description('short text');

        $this->assertEquals(['description' => 'short text'], $value->toArray());
    }
}
