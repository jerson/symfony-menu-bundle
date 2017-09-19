<?php

namespace MenuBundle\Services;


use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Routing\RouteCollection;

class RoutersService
{
    protected $routerLoader;
    /** @var  array */
    protected $router;

    public function __construct(DelegatingLoader $routerLoader, $router)
    {
        $this->routerLoader = $routerLoader;
        $this->router = $router;
    }

    public function getRouteCollection()
    {
        $collection = new RouteCollection();

        foreach ($this->router as $route) {

            $resource = isset($route['resource']) ? $route['resource'] : '';
            $type = isset($route['type']) ? $route['type'] : '';
            $importedRoutes = $this->routerLoader->import($resource, $type);
            $collection->addCollection($importedRoutes);
        }

        return $collection;
    }

}