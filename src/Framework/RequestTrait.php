<?php

namespace Isxam\M2RoadRunner\Framework;

use Isxam\M2RoadRunner\Application\Request\RegistryInterface;
use Zend\Http\Headers;
use Zend\Stdlib\Parameters;

/**
 * Request trait to override three types of magento requests classes.
 *
 * @method RegistryInterface getRegistry()
 */
trait RequestTrait
{
    /**
     * @inheritdoc
     */
    public function getMethod()
    {
        if (!$this->getRegistry()->getCurrentRequest()) {
            return parent::getMethod();
        }

        return $this->getRegistry()->getCurrentRequest()->getMethod();
    }

    /**
     * @inheritdoc
     */
    public function getRequestUri()
    {
        if (!$this->getRegistry()->getCurrentRequest()) {
            return parent::getRequestUri();
        }

        return $this->getRegistry()->getCurrentRequest()->getUri()->getPath();
    }

    /**
     * @inheritdoc
     */
    public function getHeaders($name = null, $default = false)
    {
        if (!$this->getRegistry()->getCurrentRequest()) {
            return parent::getHeaders($name, $default);
        }

        $request = $this->getRegistry()->getCurrentRequest();

        $headers = new Headers();
        $headers->addHeaders($request->getHeaders());

        if ($name === null) {
            return $headers;
        }

        if($headers->has($name)) {
            return $headers->get($name);
        }

        return $default;
    }

    /**
     * @inheritdoc
     */
    public function getContent()
    {
        if (!$this->getRegistry()->getCurrentRequest()) {
            return parent::getContent();
        }

        return (string)$this->getRegistry()->getCurrentRequest()->getBody();
    }

    /**
     * @inheritdoc
     */
    public function getQuery($name = null, $default = null)
    {
        if (!$this->getRegistry()->getCurrentRequest()) {
            return parent::getQuery($name, $default);
        }

        $request = $this->getRegistry()->getCurrentRequest();

        $queryParams = (new Parameters());
        $queryParams->fromArray($request->getQueryParams());

        if ($name === null) {
            return $queryParams;
        }

        return $queryParams->get($name, $default);
    }

    /**
     * @inheritdoc
     */
    public function getPost($name = null, $default = null)
    {
        if (!$this->getRegistry()->getCurrentRequest()) {
            return parent::getPost($name, $default);
        }

        $request = $this->getRegistry()->getCurrentRequest();

        $postParams = new Parameters();
        $postParams->fromArray($request->getParsedBody() ?: []);

        if ($name === null) {
            return $postParams;
        }

        return $postParams->get($name, $default);
    }
}
