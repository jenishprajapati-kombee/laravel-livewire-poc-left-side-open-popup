<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use League\OAuth2\Server\Exception\OAuthServerException as LeagueOAuthServerException;
use Laravel\Passport\Exceptions\OAuthServerException as PassportOAuthServerException;
use Throwable;

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
        $this->reportable(function (Throwable $e) {
            // Handle Laravel Passport OAuthServerException and prevent logging for specific error codes
            if ($e instanceof PassportOAuthServerException && ($e->getCode() === 8 || $e->getCode() === 9)) {
                return false; // Prevent logging
            }

            // Handle League OAuthServerException and prevent logging for specific error codes
            if ($e instanceof LeagueOAuthServerException && ($e->getCode() === 8 || $e->getCode() === 9)) {
                return false; // Prevent logging
            }
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof TokenMismatchException) {
            return redirect()->route('login')->with('message', 'Your session has expired. Please log in again.');
        }

        return parent::render($request, $exception);
    }
}
