<?php

namespace MenuBundle\Menu;

use Doctrine\ORM\EntityManagerInterface;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use MenuBundle\Entity\MenuItem;
use MenuBundle\Repository\MenuRepository;

class MenuBuilder
{
    private $factory;
    private $em;

    /**
     * MenuBuilder constructor.
     * @param FactoryInterface $factory
     * @param EntityManagerInterface $em
     */
    public function __construct(FactoryInterface $factory, EntityManagerInterface $em)
    {
        $this->factory = $factory;
        $this->em = $em;
    }

    public function createDefaultMenu(array $options)
    {
        $ulClass = isset($options['ulClass']) ? $options['ulClass'] : '';
        $menu = $this->factory->createItem('root', [
            'childrenAttributes' => ['class' => $ulClass],
        ]);

        $name = 'default';
        if (!empty($options)) {
            $name = isset($options['name']) ? $options['name'] : $name;
            unset($options['name']);
        }

        return $this->getDefaultMenu($menu, $name, $options);
    }

    protected function getDefaultMenu(ItemInterface $menu, $name, $options = [])
    {

        /** @var MenuRepository $repository */
        $repository = $this->em->getRepository('MenuBundle:Menu');
        $entity = $repository->findOneByName($name);

        $liClass = isset($options['liClass']) ? $options['liClass'] : '';
        $linkClass = isset($options['linkClass']) ? $options['linkClass'] : '';
        $linkRouteClass = isset($options['linkRouteClass']) ? $options['linkRouteClass'] : '';

        if ($entity === null) {
            $menu->addChild('Home', [
                'uri' => '#home',
                'linkAttributes' => ['class' => $linkClass],
                'attributes' => ['class' => $liClass],
            ]);
            return $menu;
        }


        /** @var MenuItem[] $items */
        $items = $entity->getItems();
        foreach ($items as $item) {
            $options = ['linkAttributes' => ['class' => $linkClass]];
            if ($item->getUseCustomUrl()) {
                $options['uri'] = $item->getUrl();
            } else {
                $options['route'] = $item->getRouteName();
                $parameters = @json_decode($item->getRouteParameters(), true);
                if (!empty($parameters) && is_array($parameters)) {
                    $options['routeParameters'] = $parameters;
                }
                $options['linkAttributes']['class'] = $linkClass . ' ' . $linkRouteClass;
            }
            $target = $item->getTarget();
            if (!empty($target)) {
                $options['linkAttributes']['target'] = $target;
            }

            if (!empty($liClass)) {
                $options['attributes']['class'] = $liClass;
            }

            $menu->addChild($item->getName(), $options);
        }
        return $menu;
    }
}