<?php

namespace Isxam\M2RoadRunner\Application\Response;

use GuzzleHttp\Psr7\Response;
use Magento\Framework\App\ResponseInterface as MagentoResponseInterface;
use Magento\Framework\HTTP\PhpEnvironment\Response as HttpResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Response converter implementation.
 */
class ResponseConverter implements ResponseConverterInterface
{
    /**
     * @inheritdoc
     */
    public function convert(MagentoResponseInterface $response): ResponseInterface
    {
        if (!$response instanceof HttpResponse) {
            throw new \Exception('Undefined Magento response type.');
        }

        return new Response(
            $response->getHttpResponseCode(),
            $response->getHeaders()->toArray(),
            $response->getBody()
        );
    }
}
