<?php

namespace Tests\Unit\Http\Resources;

use App\EAV\Entities\InvalidCredentialEntity;
use App\Http\Resources\ErrorResource;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\TestCase;

class ErrorResourceTest extends TestCase
{
    /** @test */
    public function it_will_return_internal_server_error_status_code_by_default(): void
    {
        $resource = new ErrorResource();

        $this->assertEquals(500, $resource->getStatusCode());
    }

    /** @test */
    public function it_will_return_not_found_status_code_when_resource_errors_has_key_id(): void
    {
        $validationException = \Mockery::mock(ValidationException::class);
        $validationException->shouldReceive('errors')->andReturn(['id' => 'not found']);
        $resource = new ErrorResource($validationException);

        $this->assertEquals(404, $resource->getStatusCode());
    }

    /** @test */
    public function it_will_return_forbidden_status_code_when_resource_errors_id_have_words_belongs_to(): void
    {
        $validationException = \Mockery::mock(ValidationException::class);
        $validationException->shouldReceive('errors')->andReturn(['id' => ['text belongs to']]);
        $resource = new ErrorResource($validationException);

        $this->assertEquals(403, $resource->getStatusCode());
    }

    /**
     * The `getStatusCode` method will return 401 status code
     * if the resource value is instance of InvalidCredentialEntity::class
     *
     * @test
     */
    public function it_will_return_un_authorized_status_code(): void
    {
        $entity = $this->createMock(InvalidCredentialEntity::class);
        $resource = new ErrorResource($entity);

        $this->assertEquals(401, $resource->getStatusCode());
    }

    /** @test */
    public function it_will_return_bad_request_status_code(): void
    {
        $validationException = \Mockery::mock(ValidationException::class);
        $validationException->shouldReceive('errors')->andReturn(['field' => 'invalid']);
        $resource = new ErrorResource($validationException);

        $this->assertEquals(400, $resource->getStatusCode());
    }

    /** @test */
    public function it_will_return_http_error_entity_instance_as_array(): void
    {
        $requestMock = $this->createMock(Request::class);
        $validationException = \Mockery::mock(ValidationException::class);
        $validationException->shouldReceive('errors')->andReturn(['field' => ['invalid']]);
        $resource = new ErrorResource($validationException);

        $this->assertEquals([
            'ok' => false,
            'data' => [
                'field' => ['invalid'],
            ],
            'err' => 'ERR_BAD_REQUEST',
            'msg' => 'invalid value of field',
        ], $resource->toArray($requestMock));
    }

    /** @test */
    public function it_will_return_invalid_credential_login_entity_as_array(): void
    {
        $requestMock = \Mockery::mock(Request::class);
        $requestMock->shouldReceive('routeIs')->with('api.login')->andReturn(true);
        $resource = new ErrorResource();

        $this->assertEquals([
            'ok' => false,
            'err' => 'ERR_INVALID_CREDS',
            'msg' => 'incorrect username or password',
        ], $resource->toArray($requestMock));
    }

    /** @test */
    public function it_will_return_invalid_credential_refresh_token_entity_as_array(): void
    {
        $requestMock = \Mockery::mock(Request::class);
        $requestMock->shouldReceive('routeIs')->with('api.login')->andReturn(false);
        $requestMock->shouldReceive('routeIs')->with('api.token.issue')->andReturn(true);
        $resource = new ErrorResource();

        $this->assertEquals([
            'ok' => false,
            'err' => 'ERR_INVALID_REFRESH_TOKEN',
            'msg' => 'invalid refresh token',
        ], $resource->toArray($requestMock));
    }
}
