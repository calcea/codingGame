<?php

namespace ActivityBundle\Admin;

use ActivityBundle\Entity\Badge;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class BadgeAdmin extends Admin
{

    /**
    * Directorul unde se vor salva pozele pentru profilul unui user.
    *
    * @var string
    */
    const LOGO_DIRECTORY = 'uploads/badge_logo';

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('title')
            ->add('language')
            ->add('logoUrl', null, array('sortable' => false,'template' => 'AdminOverrideBundle:Admin:avatar_list_field.html.twig'));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('title')
            ->add('language','sonata_type_model_list')
            ->add('type', 'choice', array('choices' => Badge::getTypeLabels()))
            ->add('logo', 'file',array('image_path' => 'logoUrl', 'image_style' => 'avatar_profile_edit'));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title');
    }

    /**
     * @inheritdoc
     */
    public function prePersist($object)
    {
        $uploadManager = $this->getConfigurationPool()->getContainer()->get('framework_extension.upload_manager');
        $uploadManager->setDocumentUploadDir(self::LOGO_DIRECTORY);
        $uploadManager->setDocumentUrl($object,'getLogo','setLogo','setLogoUrl','getOldLogoUrl','badge_logo');
    }

    /**
     * @inheritdoc
     */
    public function preUpdate($object)
    {
        $uploadManager = $this->getConfigurationPool()->getContainer()->get('framework_extension.upload_manager');
        $uploadManager->setDocumentUploadDir(self::LOGO_DIRECTORY);
        $uploadManager->setDocumentUrl($object,'getLogo','setLogo','setLogoUrl','getOldLogoUrl','badge_logo');
    }
}