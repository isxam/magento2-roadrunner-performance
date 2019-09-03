<?php

namespace Isxam\M2RoadRunner\Framework\Webapi\Rest;

use Isxam\M2RoadRunner\Application\Request\RegistryInterface;
use Isxam\M2RoadRunner\Framework\RequestTrait;
use Magento\Framework\App\AreaList;
use Magento\Framework\Config\ScopeInterface;
use Magento\Framework\Stdlib\Cookie\CookieReaderInterface;
use Magento\Framework\Stdlib\StringUtils;
use Magento\Framework\Webapi\Rest\Request as CoreRequest;

/**
 * Child of magento2 core Http request to replace global request with dynamic PSR-7 request.
 */
class Request extends CoreRequest
{
    use RequestTrait;

    /**
     * @var RegistryInterface
     */
    private $registry;

    /**
     * @var AreaList
     */
    private $areaList;

    /**
     * @var ScopeInterface
     */
    private $configScope;

    /**
     * @param CookieReaderInterface $cookieReader
     * @param StringUtils $converter
     * @param AreaList $areaList
     * @param ScopeInterface $configScope
     * @param CoreRequest\DeserializerFactory $deserializerFactory
     * @param RegistryInterface $registry
     * @param null $uri
     */
    public function __construct(
        CookieReaderInterface $cookieReader,
        StringUtils $converter,
        AreaList $areaList,
        ScopeInterface $configScope,
        CoreRequest\DeserializerFactory $deserializerFactory,
        RegistryInterface $registry,
        $uri = null
    ) {
        $this->registry = $registry;
        parent::__construct($cookieReader, $converter, $areaList, $configScope, $deserializerFactory, $uri);
        $this->areaList = $areaList;
        $this->configScope = $configScope;
    }

    /**
     * @inheritdoc
     */
    protected function getRegistry(): RegistryInterface
    {
        return $this->registry;
    }

    /**
     * @inheritdoc
     */
    public function getHttpMethod()
    {
        return $this->getMethod();
    }

    /**
     * @inheritdoc
     */
    public function getPathInfo()
    {
        $pathInfo = $this->getRequestUri();
        /** Remove base url and area from path */
        $areaFrontName = $this->areaList->getFrontName($this->configScope->getCurrentScope());
        $pathInfo = preg_replace("#.*?/{$areaFrontName}/?#", '/', $pathInfo);
        /** Remove GET parameters from path */
        $pathInfo = preg_replace('#\?.*#', '', $pathInfo);

        return $pathInfo;
    }

    /**
     * @inheritdoc
     */
    public function getBodyParams()
    {
        $content = (string)$this->getContent();

        return $content ? (array)$this->_getDeserializer()->deserialize($content) : [];
    }
}
