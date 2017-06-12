<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EditProfileForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email', 'text')
            ->add('birthday', 'birthday')
            ->add('avatar', 'file',array('image_path' => 'avatarUrl', 'image_style' => 'avatar_profile_edit'));
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'edit_profile';
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\User',
        ));
    }
}