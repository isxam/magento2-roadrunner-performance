<?php

namespace Isxam\M2RoadRunner\Application\Response;

use Magento\Framework\App\ResponseInterface as MagentoResponseInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface to convert Magento response to PSR-7 response.
 */
interface ResponseConverterInterface
{
    /**
     * Convert magento response to psr-7 response.
     * 
     * @param MagentoResponseInterface $response
     * @return ResponseInterface
     * @throws \Exception
     */
    public function convert(MagentoResponseInterface $response): ResponseInterface;
}
