<?php

namespace LessonBundle\Admin;


use Knp\Menu\ItemInterface;
use LessonBundle\Entity\Lesson;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class LessonAdmin extends Admin
{

    protected $parentAssociationMapping = 'language';

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $form)
    {
        $form->with('Lesson details')
                ->add('title')
                ->add('language','sonata_type_model_list')
                ->add('chapter')
                ->add('score_to_unlock')
                ->add('content','ckeditor', array(
                    'config_name' => 'my_config',
                ))
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title')
                ->add('language',null, array(
                        'sortable'=>true,
                        'sort_field_mapping'=> array('fieldName'=>'name'),
                        'sort_parent_association_mappings' => array(array('fieldName'=>'language'))))
                ->add('chapter');
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('title')
            ->add('chapter');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureSideMenu(ItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        /** @var Lesson $subject */
        $subject = $this->getSubject();

        if (!$childAdmin && !in_array($action, array('edit'))) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;

        $id = $admin->getRequest()->get('id');

        $menu->addChild('Current Lesson',
            $admin->generateMenuUrl('edit', array('id' => $id))
        );

        $menu->addChild('Question',
            $admin->generateMenuUrl('exam_bundle.question_admin.list', array('id' => $id)));
    }
}