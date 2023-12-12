<?php

namespace Tests\Unit\EAV\Values;

use App\EAV\Values\ID;
use PHPUnit\Framework\TestCase;

class IDTest extends TestCase
{
    /** @test */
    public function it_can_convert_id_value_object_as_a_string()
    {
        $id = new ID(1);

        $this->assertEquals('id: 1', (string) $id);
    }

    /** @test */
    public function it_can_convert_id_value_as_array()
    {
        $id = new ID(1);

        $this->assertEquals(['id' => 1], $id->toArray());
    }
}
