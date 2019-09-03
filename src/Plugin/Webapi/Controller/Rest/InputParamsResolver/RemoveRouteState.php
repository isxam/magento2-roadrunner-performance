<?php

namespace Isxam\M2RoadRunner\Plugin\Webapi\Controller\Rest\InputParamsResolver;

use Magento\Framework\Webapi\Exception;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Webapi\Controller\Rest\InputParamsResolver;
use Magento\Webapi\Controller\Rest\Router;
use Magento\Webapi\Controller\Rest\Router\Route;

/**
 * Plugin to remove internal state from InputParamsResolver.
 */
class RemoveRouteState
{
    /**
     * @var Router
     */
    private $router;
    /**
     * @var Request
     */
    private $request;

    /**
     * @param Router $router
     * @param Request $request
     */
    public function __construct(
        Router $router,
        Request $request
    ) {
        $this->router = $router;
        $this->request = $request;
    }

    /**
     * @param InputParamsResolver $subject
     * @param \Closure $proceed
     * @return Route
     * @throws Exception
     */
    public function aroundGetRoute(InputParamsResolver $subject, \Closure $proceed)
    {
        return $this->router->match($this->request);
    }
}
