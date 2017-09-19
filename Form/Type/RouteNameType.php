<?php

namespace MenuBundle\Form\Type;

use MenuBundle\Services\RoutersService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RouteNameType extends AbstractType
{

    private $router;

    public function __construct(RoutersService $router)
    {
        $this->router = $router;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $routes = $this->router->getRouteCollection();
        $choices = [];
        foreach ($routes as $name => $route) {
            $choices[$route->getPath()] = $name;
        }
        $resolver->setDefaults([
            'choices' => $choices
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

    public function getName()
    {
        return 'routeName';
    }

}