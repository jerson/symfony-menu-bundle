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
        $menu = $this->factory->createItem('root');

        $name = 'default';
        if (!empty($options)) {
            $name = isset($options['name']) ? $options['name'] : $name;
        }

        return $this->getDefaultMenu($menu, $name);
    }

    protected function getDefaultMenu(ItemInterface $menu, $name)
    {

        /** @var MenuRepository $repository */
        $repository = $this->em->getRepository('MenuBundle:Menu');
        $entity = $repository->findOneByName($name);

        if ($entity === null) {
            $menu->addChild('Home', ['uri' => '#home']);
            return $menu;
        }
        /** @var MenuItem[] $items */
        $items = $entity->getItems();
        foreach ($items as $item) {
            $options = ['linkAttributes'=>['class'=>'ajax']];
            if ($item->getUseCustomUrl()) {
                $options['uri'] = $item->getUrl();
            } else {
                $options['route'] = $item->getRouteName();
                $parameters = @json_decode($item->getRouteParameters(),true);
                if (!empty($parameters) && is_array($parameters)) {
                    $options['routeParameters'] = $parameters;
                }
            }
            $target = $item->getTarget();
            if (!empty($target)) {
                $options['linkAttributes']['target'] = $target;
            }

            $menu->addChild($item->getName(), $options);
        }
        return $menu;
    }
}