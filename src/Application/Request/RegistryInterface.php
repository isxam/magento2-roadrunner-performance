<?php

namespace Isxam\M2RoadRunner\Application\Request;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Request registry interface.
 */
interface RegistryInterface
{
    /**
     * Set current request.
     *
     * @param ServerRequestInterface $request
     * @return void
     */
    public function setCurrentRequest(ServerRequestInterface $request): void;

    /**
     * Get current request.
     *
     * @return ServerRequestInterface|null
     */
    public function getCurrentRequest(): ?ServerRequestInterface;
}
