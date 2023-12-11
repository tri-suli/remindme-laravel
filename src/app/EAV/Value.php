<?php

namespace App\EAV;

use Illuminate\Contracts\Support\Arrayable;
use Stringable;

class Value implements Arrayable, Stringable
{
    /**
     * Create a new entity value instance
     *
     * @param  string  $name
     */
    public function __construct(private readonly Attribute $attribute, private readonly mixed $name)
    {
        $attribute->addValue($this);
    }

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        return sprintf('%s: %s', $this->attribute, $this->name);
    }

    public function getName(): mixed
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            (string) $this->attribute => $this->name,
        ];
    }
}
