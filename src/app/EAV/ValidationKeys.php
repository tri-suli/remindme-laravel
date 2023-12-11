<?php

declare(strict_types=1);

namespace App\EAV;

use InvalidArgumentException;

trait ValidationKeys
{
    /**
     * Validate that some attributes key's should be present
     *
     * @param array $values
     * @param array $requiredKeys
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public function validateAttribute(array $values, array $requiredKeys): void
    {
        foreach ($requiredKeys as $key) {
            if (! array_key_exists($key, $values)) {
                throw new InvalidArgumentException(
                    sprintf('Array key [%s] is required', $key)
                );
            }
        }
    }
}
