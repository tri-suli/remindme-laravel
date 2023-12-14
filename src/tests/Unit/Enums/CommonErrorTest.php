<?php

namespace Tests\Unit\Enums;

use App\Enums\CommonError;
use PHPUnit\Framework\TestCase;

class CommonErrorTest extends TestCase
{
    /**
     * @dataProvider errorTypeDataProvider
     * @test
     */
    public function it_will_return_new_common_error_instance_base_on_error_code(int $code, string $name, string $message): void
    {
        $error = CommonError::make($code);

        $this->assertEquals($name, $error->value);
        $this->assertEquals($message, $error->message());
    }

    public static function errorTypeDataProvider(): array
    {
        return [
            'error code 400' => [400, 'ERR_BAD_REQUEST', 'invalid value of `type`'],
            'error code 401' => [401, 'ERR_INVALID_ACCESS_TOKEN', 'invalid access token'],
            'error code 403' => [403, 'ERR_FORBIDDEN_ACCESS', "user doesn't have enough authorization"],
            'error code 404' => [404, 'ERR_NOT_FOUND', 'resource is not found'],
            'error code 500' => [500, 'ERR_INTERNAL_ERROR', 'unable to connect into database'],
        ];
    }
}
