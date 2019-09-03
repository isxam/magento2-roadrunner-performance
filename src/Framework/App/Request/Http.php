<?php

namespace Isxam\M2RoadRunner\Framework\App\Request;

use Isxam\M2RoadRunner\Application\Request\RegistryInterface;
use Isxam\M2RoadRunner\Framework\RequestTrait;
use Magento\Framework\App\Request\Http as CoreHttp;
use Magento\Framework\App\Request\PathInfo;
use Magento\Framework\App\Request\PathInfoProcessorInterface;
use Magento\Framework\App\Route\ConfigInterface\Proxy as ConfigInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Stdlib\Cookie\CookieReaderInterface;
use Magento\Framework\Stdlib\StringUtils;

/**
 * Child of magento2 core Http request to replace global request with dynamic PSR-7 request.
 */
class Http extends CoreHttp
{
    use RequestTrait;

    /**
     * @var RegistryInterface
     */
    private $registry;

    /**
     * @param CookieReaderInterface $cookieReader
     * @param StringUtils $converter
     * @param ConfigInterface $routeConfig
     * @param PathInfoProcessorInterface $pathInfoProcessor
     * @param ObjectManagerInterface $objectManager
     * @param RegistryInterface $registry
     * @param null $uri
     * @param array $directFrontNames
     * @param PathInfo|null $pathInfoService
     */
    public function __construct(
        CookieReaderInterface $cookieReader,
        StringUtils $converter,
        ConfigInterface $routeConfig,
        PathInfoProcessorInterface $pathInfoProcessor,
        ObjectManagerInterface $objectManager,
        RegistryInterface $registry,
        $uri = null,
        $directFrontNames = [],
        PathInfo $pathInfoService = null
    ) {
        $this->registry = $registry;
        parent::__construct(
            $cookieReader,
            $converter,
            $routeConfig,
            $pathInfoProcessor,
            $objectManager,
            $uri,
            $directFrontNames,
            $pathInfoService
        );
    }

    /**
     * @inheritdoc
     */
    protected function getRegistry(): RegistryInterface
    {
        return $this->registry;
    }
}
