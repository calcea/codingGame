<?php

namespace UserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class UserAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('username')
            ->add('email')
            ->add('avatarUrl',null,array(
                    'template' => 'AdminOverrideBundle:Admin:avatar_list_field.html.twig',
                    'sortable' => false
                )
            )
            ->add('birthday', null, array('format' => 'Y-M-d'));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter ->add('username')
                ->add('email');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'show'));
    }
}