<?php

declare(strict_types=1);

namespace App\EAV\Values;

use App\EAV\Attribute;
use App\EAV\Value;

class Title extends Value
{
    /**
     * {@inheritDoc}
     */
    public function __construct(string $value)
    {
        parent::__construct(new Attribute('title'), $value);
    }
}
