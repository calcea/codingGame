<?php

namespace FrameworkExtensionBundle\Form\Extension;


use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class DocumentFileExtension extends AbstractTypeExtension
{

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(array('file_path','file_name'));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $filePath = null;
        $fileName = null;
        if(array_key_exists('file_path',$options)){
            $formData = $form->getParent()->getData();
            if(!is_null($formData)){
                $accessor = PropertyAccess::createPropertyAccessor();
                $filePath = $accessor->getValue($formData,$options['file_path']);
            }
        }

        if(array_key_exists('file_name',$options)){
            $formData = $form->getParent()->getData();
            if(!is_null($formData)){
                $accessor = PropertyAccess::createPropertyAccessor();
                $fileName = $accessor->getValue($formData,$options['file_name']);
            }
        }
        $view->vars['file_path'] = $filePath;
        $view->vars['file_name'] = $fileName;
    }
}