<?php

namespace App\Exceptions;

use Throwable;
use F9Web\ApiResponseHelpers;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponseHelpers;
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render ($request , Throwable $e)
    {
        switch ($e)
        {
            case $e instanceof ModelNotFoundException:
                return response()->json(['error' => 'the given item is not found'], 404);
            case $e instanceof QueryException:
                return response()->json(['error' => 'Something went wrong! Try again later.'], 500);
            case $e instanceof MethodNotAllowedHttpException:
                return response()->json(['error' => 'It is not allowed Http method for this route'], 403);
        }

        return parent::render($request, $e);
    }
}
