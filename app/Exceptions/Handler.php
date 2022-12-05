<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
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
        $this->renderable(function (\Exception $e, $request) {
            dd($e->getMessage());
            switch (true) {
                case $this->isHttpException($e):
                    if ($e->getStatusCode() == Response::HTTP_FORBIDDEN) {
                        return response()->json('Forbidden', Response::HTTP_FORBIDDEN);
                    } elseif ($e->getStatusCode() == Response::HTTP_NOT_FOUND) {
                        return response()->json('NOT FOUND', Response::HTTP_NOT_FOUND);
                    }
                case $e instanceof QueryException:
                    return response()->json('Bad Request', Response::HTTP_BAD_REQUEST);
                case $e instanceof FileNotFoundException || $e instanceof NotFoundHttpException || $e instanceof ModelNotFoundException || $e instanceof RouteNotFoundException:
                    return response()->json('NOT FOUND', Response::HTTP_NOT_FOUND);
                case $e instanceof AuthenticationException || $e instanceof AuthorizationException:
                    return response()->json('Unauthorized', Response::HTTP_UNAUTHORIZED);
                default:
                    return response()->json('INTERNAL_SERVER_ERROR', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        });
    }
}
