<?php

namespace App\Exceptions;

use App\Traits\HasApiResponseTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use HasApiResponseTrait;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (ValidationException $e) {
            return $this->responseWithError($e->getMessage(),$e->errors(),$e->status);
        });

        $this->renderable(function (AuthenticationException $e){
            return $this->responseWithError($e->getMessage(), [], Response::HTTP_UNAUTHORIZED);
        });

        $this->renderable(function (AccessDeniedHttpException $e) {
            return $this->responseWithError($e->getMessage(), [], Response::HTTP_FORBIDDEN);
        });

        $this->renderable(function (NotFoundHttpException $e) {
            return $this->responseWithError('Not found.', [], $e->getStatusCode());
        });

        $this->renderable(function (ModelNotFoundException $e) {
            return $this->responseWithError($e->getMessage(), [], Response::HTTP_NOT_FOUND);
        });

        $this->renderable(function (MethodNotAllowedHttpException $e) {
            return $this->responseWithError($e->getMessage(), [], Response::HTTP_METHOD_NOT_ALLOWED);
        });
    }
}
