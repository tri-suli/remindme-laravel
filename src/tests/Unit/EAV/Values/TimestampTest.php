<?php

namespace Tests\Unit\EAV\Values;

use App\EAV\Values\Timestamp;
use PHPUnit\Framework\TestCase;

class TimestampTest extends TestCase
{
    /** @test */
    public function it_will_add_suffix_at_to_the_timestamp_attribute_name(): void
    {
        $value = new Timestamp('created', 'now');

        $this->assertEquals('created_at: now', (string) $value);
    }

    /** @test */
    public function it_can_get_timestamp_value_as_string()
    {
        $value = new Timestamp('updated_at', '2023-12-11');

        $this->assertEquals('updated_at: 2023-12-11', (string) $value);
    }

    /** @test */
    public function it_can_convert_timestamp_value_as_array()
    {
        $value = new Timestamp('updated_at', '2023-12-11');

        $this->assertEquals(['updated_at' => '2023-12-11'], $value->toArray());
    }
}
