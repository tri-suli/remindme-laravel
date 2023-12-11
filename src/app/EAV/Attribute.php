<?php

declare(strict_types=1);

namespace App\EAV;

use Illuminate\Contracts\Support\Arrayable;
use SplObjectStorage;
use Stringable;

class Attribute implements Arrayable, Stringable
{
    /**
     * The attribute value list
     */
    private SplObjectStorage $values;

    /**
     * Create a new entity attribute instance
     */
    public function __construct(private readonly string $name)
    {
        $this->values = new SplObjectStorage();
    }

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * Add a new value for this attribute
     */
    public function addValue(Value $value): void
    {
        $this->values->attach($value);
    }

    /**
     * Get all attribute values
     */
    public function getValues(): SplObjectStorage
    {
        return $this->values;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $values = [];
        $valueObject = $this->getValues();

        while ($valueObject->valid()) {
            $value = $valueObject->current();
            $values[] = $value->getName();

            $valueObject->next();
        }

        return [(string) $this => $values];
    }
}
