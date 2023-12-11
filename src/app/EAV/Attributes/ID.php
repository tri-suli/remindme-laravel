<?php

declare(strict_types=1);

namespace App\EAV\Attributes;

use App\EAV\Attribute;

class ID extends Attribute
{
    /**
     * {@inheritDoc}
     */
    public function __construct(string $name = 'id')
    {
        parent::__construct($name);
    }
}
