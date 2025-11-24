<?php declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

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
    public function register() : void
    {
        // 429は日本語Jsonで返す
        $this->renderable(function(ThrottleRequestsException $_e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'API制限に引っ掛かりました'], 429);
            }

            return null;
        });
    }
}
