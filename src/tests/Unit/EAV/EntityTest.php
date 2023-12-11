<?php

namespace Tests\Unit\EAV;

use InvalidArgumentException;
use Mockery;
use App\EAV\Attribute;
use App\EAV\Entity;
use App\EAV\Value;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    /** @test */
    public function can_get_entity_as_a_string(): void
    {
        $attribute = Mockery::spy(Attribute::class);
        $skill = Mockery::spy(Value::class, [$attribute, 'attack']);
        $skillValue = Mockery::spy(Value::class, [$attribute, '90']);

        $entity = new Entity('Player', [$skill, $skillValue]);

        $this->assertStringContainsString(sprintf('%s, %s', $skill, $skillValue), (string) $entity);
        $skill->shouldHaveReceived('__toString')->twice();
        $skillValue->shouldHaveReceived('__toString')->twice();
        $attribute->shouldHaveReceived('addValue')->twice();
    }

    /** @test */
    public function should_throw_an_error_if_the_given_value_is_invalid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Entity('Team', ['test']);
    }

    /** @test */
    public function can_get_entity_as_an_array(): void
    {
        $attributeName = new Attribute('name');
        $valueName = new Value($attributeName, 'Player Name');
        $attributePosition = new Attribute('position');
        $valuePosition = new Value($attributePosition, 'forward');

        $entity = new Entity('Player', [
            $valueName,
            $valuePosition
        ]);

        $this->assertEquals(
            [
                'Player' => [
                    'name' => 'Player Name',
                    'position' => 'forward'
                ]
            ],
            $entity->toArray()
        );
    }
}
