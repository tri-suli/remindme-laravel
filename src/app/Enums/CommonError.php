<?php

namespace App\Enums;

enum CommonError: string
{
    /**
     * Error for status code 400
     *
     * @var string
     */
    case BAD_REQUEST = 'ERR_BAD_REQUEST';

    /**
     * Error for status code 401
     *
     * @var string
     */
    case UN_AUTHORIZED = 'ERR_INVALID_ACCESS_TOKEN';

    /**
     * Error for status code 403
     *
     * @var string
     */
    case FORBIDDEN = 'ERR_FORBIDDEN_ACCESS';

    /**
     * Error for status code 404
     *
     * @var string
     */
    case NOT_FOUND = 'ERR_NOT_FOUND';

    /**
     * Error for status code 500
     *
     * @var string
     */
    case SERVER = 'ERR_INTERNAL_ERROR';

    /**
     * Get new error instance base on error code
     *
     * @param int $code
     * @return self
     */
    public static function make(int $code): self
    {
        return match ($code) {
            400 => self::BAD_REQUEST,
            401 => self::UN_AUTHORIZED,
            403 => self::FORBIDDEN,
            404 => self::NOT_FOUND,
            500 => self::SERVER,
        };
    }

    /**
     * Get error type message
     *
     * @return string
     */
    public function message(): string
    {
        return match ($this) {
            self::BAD_REQUEST => 'invalid value of `type`',
            self::UN_AUTHORIZED => 'invalid access token',
            self::FORBIDDEN => "user doesn't have enough authorization",
            self::NOT_FOUND => 'resource is not found',
            self::SERVER => 'unable to connect into database',
        };
    }
}
