<?php

namespace MenuBundle\Admin;


use MenuBundle\Form\Type\RouteArgumentsType;
use MenuBundle\Form\Type\RouteNameType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * {@inheritDoc}
 */
class MenuItemAdmin extends AbstractAdmin
{


    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            ['@Menu/Form/fields.html.twig']
        );
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('target')
            ->add('url');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('target')
            ->add('url')
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                    'delete' => [],
                ]
            ]);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('useCustomUrl', CheckboxType::class, [
            ])
            ->add('routeName', RouteNameType::class, [
            ])
            ->add('routeParameters', null, [
                'attr' => [
                    'hidden' => true
                ],
            ])
            ->add('url', null, [
                'attr' => [
                    'hidden' => true
                ],
            ])
            ->add('target', ChoiceType::class, [
                'choices' => [
                    'Default' => '',
                    'New tab' => '_blank',
                ]
            ])
            ->add('position', HiddenType::class, [
                'attr' => [
                    //'hidden' => true
                ],
            ]);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('target')
            ->add('url');
    }
}
