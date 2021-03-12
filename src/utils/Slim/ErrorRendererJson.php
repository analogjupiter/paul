<?php

declare(strict_types=1);

namespace Voidblaster\Paul\Utils\Slim;

use ReflectionClass;
use Slim\Interfaces\ErrorRendererInterface;
use Throwable;

use function json_encode;

class ErrorRendererJson implements ErrorRendererInterface
{
    public function __invoke(Throwable $exception, bool $displayErrorDetails): string
    {
        $e = [
            'status' => $exception->getCode(),
            'message' => $exception->getMessage(),
        ];

        $flags = 0;

        if ($displayErrorDetails) {
            $exceptionType = new ReflectionClass($exception);

            $e['details'] = [
                'type' => $exceptionType->getName(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => $exception->getTrace(),
            ];

            $flags |= JSON_PRETTY_PRINT;
        }

        return json_encode($e, $flags);
    }
}
