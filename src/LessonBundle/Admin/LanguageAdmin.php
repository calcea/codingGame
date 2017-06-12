<?php

namespace LessonBundle\Admin;

use Knp\Menu\ItemInterface;
use LessonBundle\Entity\Language;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class LanguageAdmin extends Admin
{

    /**
     * Directorul unde se vor salva pozele pentru profilul unui user.
     *
     * @var string
     */
    const LOGO_DIRECTORY = 'uploads/language_logo';

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('name')
            ->add('logo', 'file',array('image_path' => 'logoUrl', 'image_style' => 'avatar_profile_edit'));
    }

    /**
     * @inheritdoc
     */
    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('name')
            ->add('logoUrl',null,array('template' => "LessonBundle:Admin/Language:logo_list_field.html.twig", 'sortable' => false));
    }

    /**
     * @inheritdoc
     */
    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter->add('name');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureSideMenu(ItemInterface $menu, $action, AdminInterface $childAdmin = null)
    {
        /** @var Language $subject */
        $subject = $this->getSubject();

        if (!$childAdmin && !in_array($action, array('edit'))) {
            return;
        }

        $admin = $this->isChild() ? $this->getParent() : $this;

        $id = $admin->getRequest()->get('id');

        // add route for edit current deal
        $menu->addChild('Current Language',
            $admin->generateMenuUrl('edit', array('id' => $id))
        );

        //add route for a transactions list
        $menu->addChild('Lessons',
            $admin->generateMenuUrl('lesson_bundle.lesson_admin.list', array('id' => $id)));
    }

    /**
     * @inheritdoc
     */
    public function prePersist($object)
    {
        $uploadManager = $this->getConfigurationPool()->getContainer()->get('framework_extension.upload_manager');
        $uploadManager->setDocumentUploadDir(self::LOGO_DIRECTORY);
        $uploadManager->setDocumentUrl($object,'getLogo','setLogo','setLogoUrl','getOldLogoUrl','language_logo');
    }

    /**
     * @inheritdoc
     */
    public function preUpdate($object)
    {
        $uploadManager = $this->getConfigurationPool()->getContainer()->get('framework_extension.upload_manager');
        $uploadManager->setDocumentUploadDir(self::LOGO_DIRECTORY);
        $uploadManager->setDocumentUrl($object,'getLogo','setLogo','setLogoUrl','getOldLogoUrl','language_logo');
    }

}