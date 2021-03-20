<?php

declare(strict_types=1);

namespace Voidblaster\Paul\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/**
 * Sets the specified header to a specified value if non is provided
 */
class DefaultHeaderMiddleware implements MiddlewareInterface
{
    private string $header;
    private string $defaultValue;

    public function __construct(string $header, string $defaultValue)
    {
        $this->header = $header;
        $this->defaultValue = $defaultValue;
    }

    public function process(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        if (!$response->hasHeader($this->header)) {
            $response = $response->withHeader($this->header, $this->defaultValue);
        }

        return $response;
    }
}
