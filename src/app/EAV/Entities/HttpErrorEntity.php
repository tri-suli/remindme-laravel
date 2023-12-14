<?php

namespace App\EAV\Entities;

use App\EAV\Attribute;
use App\EAV\Entity;
use App\EAV\Value;
use App\Enums\CommonError;

class HttpErrorEntity extends Entity
{
    /**
     * Create a new reminder instance
     */
    public function __construct(array $errors, int $statusCode = 400)
    {
        $commonError = CommonError::make($statusCode);

        parent::__construct($commonError->name, [
            new Value(new Attribute('ok'), false),
            new Value(new Attribute('data'), json_encode($errors)),
            new Value(new Attribute('err'), $commonError->value),
            new Value(new Attribute('msg'), $this->message($errors, $commonError->message())),
        ]);
    }

    /**
     * Get the HTTP error message
     */
    private function message(array $errors, string $message): string
    {
        $fieldKeys = array_keys($errors);

        if (count($fieldKeys) === 1) {
            $message = str_replace('`type`', $fieldKeys[0], $message);
        } else {
            $message = str_replace('`type`', implode(', ', $fieldKeys), $message);
        }

        return $message;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        $result = array_values(parent::toArray())[0];

        return [
            ...$result,
            'ok' => false,
            'data' => json_decode($result['data'], 1),
        ];
    }
}
