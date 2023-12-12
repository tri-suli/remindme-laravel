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
        $value = $this->name;

        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        return sprintf('%s: %s', $this->attribute, $value);
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
