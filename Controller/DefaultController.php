<?php

namespace MenuBundle\Controller;

use MenuBundle\Entity\MenuItem;
use MenuBundle\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{


    /**
     * @param $name
     * @param $url
     * @param array $options
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function renderAction($name, $url, $options = [])
    {

        /** @var MenuRepository $repository */
        $repository = $this->getRepository('MenuBundle:Menu');
        $entity = $repository->findOneByName($name);

        $menuItems = [];
        $lastParent = null;

        /** @var MenuItem[] $items */
        $items = $entity->getItems();

        foreach ($items as $item) {

            if (!$item->getUseCustomUrl()) {
                $parameters = @json_decode($item->getRouteParameters(), true);
                $url = $this->generateUrl($item->getRouteName(), $parameters);
                $item->setUrl($url);
            }
            $parent = $item->getParent();
            if (!$parent) {
                $lastParent = $item;
                $menuItems[$item->getId()] = [
                    'item' => $item,
                    'childrens' => []
                ];
            } elseif ($lastParent) {
                $menuItems[$lastParent->getId()]['childrens'][] = $item;
            }
        }


        return $this->render('@Menu/Default/render.html.twig', [
            'options' => $options,
            'url' => $url,
            'menuItems' => $menuItems,
            'name' => $name
        ]);
    }

    /**
     * @param $name
     * @return EntityRepository
     */
    protected function getRepository($name)
    {
        return $this->getDoctrine()->getRepository($name);
    }

}