<?php

namespace Isxam\M2RoadRunner\Application;

use GuzzleHttp\Psr7\Response;
use Isxam\M2RoadRunner\Application\Request\RegistryInterface;
use Isxam\M2RoadRunner\Application\Response\ResponseConverterInterface;
use Magento\Framework\AppInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Wrapper over Magento application to follow PSR-7.
 */
class MagentoAppWrapper implements ApplicationInterface
{
    /**
     * @var RegistryInterface
     */
    private $registry;

    /**
     * @var AppInterface
     */
    private $magentoApp;

    /**
     * @var ResponseConverterInterface
     */
    private $responseConverter;

    /**
     * @param RegistryInterface $registry
     * @param AppInterface $magentoApp
     * @param ResponseConverterInterface $responseConverter
     */
    public function __construct(
        RegistryInterface $registry,
        AppInterface $magentoApp,
        ResponseConverterInterface $responseConverter
    ) {
        $this->registry = $registry;
        $this->magentoApp = $magentoApp;
        $this->responseConverter = $responseConverter;
    }

    /**
     * @inheritdoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->registry->setCurrentRequest($request);

        try {
            $magentoResponse = $this->magentoApp->launch();

            $response = $this->responseConverter->convert($magentoResponse);
        } catch (\Exception $e) {
            $response = $this->buildExceptionResponse($e);
        }

        return $response;
    }

    /**
     * Build exception response.
     *
     * @param \Exception $e
     * @return ResponseInterface
     */
    private function buildExceptionResponse(\Exception $e): ResponseInterface
    {
        return new Response(
            500,
            [],
            $e->getMessage()
        );
    }
}
