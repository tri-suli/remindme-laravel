<?php

namespace App\EAV\Entities;

use App\EAV\Attribute;
use App\EAV\Entity;
use App\EAV\Value;
use App\Enums\TokenAbility;

class AccessTokenEntity extends Entity
{
    /**
     * {@inheritDoc}
     */
    public function __construct(string $accessToken, string $refreshToken = '')
    {
        parent::__construct('Token', [
            new Value(new Attribute(TokenAbility::ACCESS_API->getName()), $accessToken),
            new Value(new Attribute(TokenAbility::ISSUE_ACCESS_TOKEN->getName()), $refreshToken),
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $values = array_values(parent::toArray())[0];

        if (empty($values[TokenAbility::ISSUE_ACCESS_TOKEN->getName()])) {
            unset($values[TokenAbility::ISSUE_ACCESS_TOKEN->getName()]);
        }

        return $values;
    }
}
