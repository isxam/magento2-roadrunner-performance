<?php

namespace Isxam\M2RoadRunner\Application\Request;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Request registry implementation.
 */
class Registry implements RegistryInterface
{
    /**
     * @var ServerRequestInterface|null
     */
    private $currentRequest;

    /**
     * @inheritdoc
     */
    public function setCurrentRequest(ServerRequestInterface $request): void
    {
        $this->currentRequest = $request;
    }

    /**
     * @inheritdoc
     */
    public function getCurrentRequest(): ?ServerRequestInterface
    {
        return $this->currentRequest;
    }
}
