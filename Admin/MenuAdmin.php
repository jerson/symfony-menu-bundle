<?php

namespace MenuBundle\Admin;

use MenuBundle\Entity\Menu;
use MenuBundle\Form\Type\NameType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * {@inheritDoc}
 */
class MenuAdmin extends AbstractAdmin
{

    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'name'
    ];

    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            ['@Menu/Form/fields.html.twig']
        );
    }

    /**
     * {@inheritDoc}
     */
    public function preUpdate($entity)
    {
        /** @var Menu $entity */
        foreach ($entity->getItems() as $link) {
            $link->setMenu($entity);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function prePersist($entity)
    {
        /** @var Menu $entity */
        foreach ($entity->getItems() as $link) {
            $link->setMenu($entity);
        }
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
        $collection->remove('delete');
        $collection->remove('show');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', 'trans', [
                'catalogue' => 'messages'
            ])
            ->add('dateUpdated')
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                ]
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $formMapper
            ->with('General')
            ->add('name', NameType::class, ['required' => false])
            //->add('name', null, ['required' => false])
            ->add('items', 'sonata_type_collection', [
                'required' => false,
            ], [
                'allow_delete' => true,
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
            ])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('dateUpdated');
    }
}
