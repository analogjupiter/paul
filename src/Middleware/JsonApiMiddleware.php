<?php

declare(strict_types=1);

namespace Voidblaster\Paul\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

/**
 * Sets Content-Type header to a default value if non is provided
 */
class DefaultContentTypeMiddleware implements MiddlewareInterface
{
    private $defaultContentType;

    public function __construct(string $defaultContentType)
    {
        $this->defaultContentType = $defaultContentType;
    }

    public function process(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);

        if (!$response->hasHeader('Content-Type')) {
            $response = $response->withHeader('Content-Type', $this->defaultContentType);
        }

        return $response;
    }
}
