<?php

namespace Tests\Unit\EAV\Attributes;

use App\EAV\Attributes\ID;
use PHPUnit\Framework\TestCase;

class IDTest extends TestCase
{
    /** @test */
    public function should_get_attribute_name_as_id_by_default()
    {
        $id = new ID();

        $this->assertEquals('id', (string) $id);
    }

    /** @test */
    public function should_get_attribute_name_base_on_param()
    {
        $id = new ID('custom');

        $this->assertEquals('custom', (string) $id);
    }
}
