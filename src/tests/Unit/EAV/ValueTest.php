<?php

namespace Tests\Unit\EAV;

use App\EAV\Attribute;
use App\EAV\Value;
use PHPUnit\Framework\TestCase;

class ValueTest extends TestCase
{
    /** @test */
    public function can_get_value_as_a_string(): void
    {
        $attributeName = 'name';
        $attribute = $this->createMock(Attribute::class);
        $attribute->method('__toString')->willReturn($attributeName);

        $attributeValue = 'Player 1';
        $value = new Value($attribute, $attributeValue);

        $this->assertEquals(
            "$attributeName: $attributeValue",
            (string) $value
        );
    }

    /** @test */
    public function can_get_value_as_a_array(): void
    {
        $attributeName = 'position';
        $attribute = $this->createMock(Attribute::class);
        $attribute->method('__toString')->willReturn($attributeName);

        $position = 'midfielder';
        $value = new Value($attribute, $position);

        $this->assertEquals(
            [$attributeName => $position],
            $value->toArray()
        );
    }
}
