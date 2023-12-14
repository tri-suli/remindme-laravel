<?php

namespace Tests\Unit\EAV\Entities;

use App\EAV\Entities\UserEntity;
use PHPUnit\Framework\TestCase;

class UserEntityTest extends TestCase
{
    /** @test */
    public function it_will_return_user_entity_as_a_string(): void
    {
        $entity = new UserEntity(1, 'John Doe', 'johndoe@mail.com');

        $this->assertEquals(
            'User, id: 1, name: John Doe, email: johndoe@mail.com',
            (string) $entity
        );
    }

    /** @test */
    public function it_will_return_user_entity_as_array(): void
    {
        $entity = new UserEntity(1, 'John Doe', 'johndoe@mail.com');

        $this->assertEquals(
            ['id' => 1, 'name' => 'John Doe', 'email' => 'johndoe@mail.com'],
            $entity->toArray()
        );
    }
}
