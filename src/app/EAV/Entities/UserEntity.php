<?php

namespace App\EAV\Entities;

use App\EAV\Attribute;
use App\EAV\Entity;
use App\EAV\Value;
use App\EAV\Values\ID;

class UserEntity extends Entity
{
    /**
     * {@inheritDoc}
     */
    public function __construct(int $id, string $name, string $email)
    {
        parent::__construct('User', [
            new ID($id),
            new Value(new Attribute('name'), $name),
            new Value(new Attribute('email'), $email),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return array_values(parent::toArray())[0];
    }
}
