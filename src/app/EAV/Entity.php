<?php

declare(strict_types=1);

namespace App\EAV;

use Illuminate\Contracts\Support\Arrayable;
use InvalidArgumentException;
use SplObjectStorage;
use Stringable;

class Entity implements Arrayable, Stringable
{
    /**
     * The entity values
     *
     * @var SplObjectStorage<Value, Value>
     */
    private SplObjectStorage $values;

    /**
     * Create a new entity instance
     *
     * @param  Value[]  $values
     *
     * @throws InvalidArgumentException
     */
    public function __construct(private readonly string $name, array $values)
    {
        $this->values = new SplObjectStorage();

        foreach ($values as $value) {
            if ($value instanceof Value) {
                $this->values->attach($value);

                continue;
            }

            throw new InvalidArgumentException(
                sprintf('The entity value should be an instance of Value object, %s given', gettype($values))
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        $texts = [$this->name];

        foreach ($this->values as $value) {
            $texts[] = (string) $value;
        }

        return implode(', ', $texts);
    }

    /**
     * Get entity values
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
        foreach ($this->values as $value) {
            [$attribute, $value] = explode(': ', (string) $value);
            $values[$attribute] = $value;
        }

        return [
            $this->name => $values,
        ];
    }
}
