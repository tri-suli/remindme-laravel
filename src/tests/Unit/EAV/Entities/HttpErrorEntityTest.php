<?php

namespace Tests\Unit\EAV\Entities;

use App\EAV\Entities\HttpErrorEntity;
use App\Enums\CommonError;
use PHPUnit\Framework\TestCase;

class HttpErrorEntityTest extends TestCase
{
    /** @test */
    public function it_should_return_bad_request_message(): void
    {
        $error = CommonError::BAD_REQUEST;
        $entity = new HttpErrorEntity([
            'name' => [
                'field name is invalid',
            ],
        ]);

        $this->assertEquals("BAD_REQUEST, ok: false, data: {\"name\":[\"field name is invalid\"]}, err: {$error->value}, msg: invalid value of name", (string) $entity);
        $this->assertEquals([
            'ok' => false,
            'data' => [
                'name' => [
                    'field name is invalid',
                ],
            ],
            'err' => $error->value,
            'msg' => 'invalid value of name',
        ], $entity->toArray());
    }

    /** @test */
    public function it_should_return_bad_request_message_with_more_than_2_fields(): void
    {
        $error = CommonError::BAD_REQUEST;
        $errors = [
            'name' => [
                'field name is invalid',
            ],
            'email' => [
                'field email is invalid',
            ],
            'password' => [
                'field password is invalid',
            ],
        ];
        $entity = new HttpErrorEntity($errors);

        $this->assertEquals("BAD_REQUEST, ok: false, data: {\"name\":[\"field name is invalid\"],\"email\":[\"field email is invalid\"],\"password\":[\"field password is invalid\"]}, err: {$error->value}, msg: invalid value of name, email, password", (string) $entity);
        $this->assertEquals([
            'ok' => false,
            'data' => $errors,
            'err' => $error->value,
            'msg' => 'invalid value of name, email, password',
        ], $entity->toArray());
    }
}
