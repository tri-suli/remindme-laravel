<?php

declare(strict_types=1);

namespace App\EAV\Values;

use App\EAV\Attribute;
use App\EAV\Value;

class ID extends Value
{
    /**
     * {@inheritDoc}
     */
    public function __construct(int $value)
    {
        parent::__construct(new Attribute('id'), $value);
    }
}
