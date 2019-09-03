<?php

namespace Isxam\M2RoadRunner\Application;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Application interface.
 */
interface ApplicationInterface
{
    /**
     * Handle request.
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface;
}
