<?php

namespace App\Exceptions;

use BadMethodCallException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        // $this->renderable(function (NotFoundHttpException $e, $request) {
        //     if($request->wantsJson())
        //     {
        //         return response()->json(['message' => __('generic.not_found')], 404);
        //     }
        // });

        // $this->renderable(function (QueryException $e, $request) {
        //     if($request->wantsJson())
        //     {
        //         return response()->json(['message' => $e->getMessage()], 503);
        //     }
        // });

        // $this->renderable(function (BadMethodCallException $e, $request) {
        //     if($request->wantsJson())
        //     {
        //         return response()->json(['message' => __('generic.not_found')], 404);
        //     }
        // });
    }
}
