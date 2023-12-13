<?php

namespace Tests\Unit\EAV\Entities;

use App\EAV\Entities\InvalidCredentialEntity;
use App\Enums\AuthError;
use PHPUnit\Framework\TestCase;

class InvalidCredentialEntityTest extends TestCase
{
    /** @test */
    public function it_will_return_invalid_credential_entity_as_a_string(): void
    {
        $error = AuthError::LOGIN;
        $entity = new InvalidCredentialEntity($error);

        $this->assertEquals(
            "Auth Error, ok: false, err: $error->value, msg: {$error->message()}",
            (string) $entity
        );
    }

    /** @test */
    public function it_will_return_invalid_credential_entity_as_array(): void
    {
        $error = AuthError::REFRESH;
        $entity = new InvalidCredentialEntity($error);

        $this->assertEquals(
            ['ok' => false, 'err' => $error->value, 'msg' => $error->message()],
            $entity->toArray()
        );
    }
}
