<?php

namespace App\Exceptions;

use App\Http\Resources\ErrorResource;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Laravel\Sanctum\Exceptions\MissingAbilityException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): Response|JsonResponse|\Symfony\Component\HttpFoundation\Response|RedirectResponse|ResponseFactory
    {
        if ($e instanceof MissingAbilityException || $e instanceof CredentialMismatchException) {
            return (new ErrorResource([]))->toResponse($request);
        }

        if ($e instanceof AuthenticationException) {
            return (new ErrorResource(['message' => 'Unauthenticated']))->toResponse($request);
        }

        if ($e instanceof \Error) {
            return (new ErrorResource(['message' => $e->getMessage()]))->toResponse($request);
        }

        return parent::render($request, $e);
    }
}
