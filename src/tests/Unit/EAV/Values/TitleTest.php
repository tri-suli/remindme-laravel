<?php

namespace Tests\Unit\EAV\Values;

use App\EAV\Values\Title;
use PHPUnit\Framework\TestCase;

class TitleTest extends TestCase
{
    /** @test */
    public function it_can_get_title_value_as_string()
    {
        $value = new Title('My Title');

        $this->assertEquals('title: My Title', (string) $value);
    }

    /** @test */
    public function it_can_convert_title_value_as_array()
    {
        $value = new Title('Your Title');

        $this->assertEquals(['title' => 'Your Title'], $value->toArray());
    }
}
