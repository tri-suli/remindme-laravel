<?php

declare(strict_types=1);

namespace App\EAV\Values;

use App\EAV\Attribute;
use App\EAV\Value;

class Timestamp extends Value
{
    /**
     * {@inheritDoc}
     *
     * @param string $name
     * @param int|string $value
     */
    public function __construct(string $name, int|string $value)
    {
        if (! str_contains($name, '_at')) {
            $name = sprintf('%s_at', $name);
        }

        parent::__construct(new Attribute($name), $value);
    }
}
