<?php

namespace Tests\Unit\EAV;

use App\EAV\Attribute;
use App\EAV\Value;
use Mockery;
use PHPUnit\Framework\TestCase;

class AttributeTest extends TestCase
{
    /** @test */
    public function can_create_new_attribute(): void
    {
        $attribute = new Attribute('name');

        $this->assertEquals('name', (string) $attribute);
    }

    /** @test */
    public function can_add_new_value_to_the_attribute(): void
    {
        $attribute = Mockery::spy(Attribute::class, 'position');

        $value = new Value($attribute, 'defender');

        $this->assertStringContainsString(
            'position',
            (string) $value
        );
        $attribute
            ->shouldHaveReceived('addValue')
            ->with(Mockery::on(function (Value $arg) use ($value) {
                return $arg->getName() === $value->getName();
            }))
            ->once();
    }

    /** @test */
    public function can_get_attribute_as_an_array(): void
    {
        $attribute = new Attribute('attribute');

        $value1 = new Value($attribute, 'value1');
        $value2 = new Value($attribute, 'value2');

        $this->assertEquals([
            'attribute' => [
                $value1->getName(),
                $value2->getName(),
            ],
        ], $attribute->toArray());
    }
}
