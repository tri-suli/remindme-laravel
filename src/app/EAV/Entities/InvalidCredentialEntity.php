<?php

namespace App\EAV\Entities;

use App\EAV\Attribute;
use App\EAV\Entity;
use App\EAV\Value;
use App\Enums\AuthError;

class InvalidCredentialEntity extends Entity
{
    /**
     * Create a new reminder instance
     */
    public function __construct(AuthError $error)
    {
        parent::__construct('Auth Error', [
            new Value(new Attribute('ok'), false),
            new Value(new Attribute('err'), $error->value),
            new Value(new Attribute('msg'), $error->message()),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $values = [];

        foreach ($this->getValues() as $value) {
            [$attribute, $value] = explode(': ', (string) $value);

            if ($attribute === 'ok') {
                $value = false;
            }

            $values[$attribute] = $value;
        }

        return $values;
    }
}
