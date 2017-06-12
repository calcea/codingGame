<?php

namespace FrameworkExtensionBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;


class ImageTypeExtension extends AbstractTypeExtension
{
    /**
     * Flag which determines if the LiipImagineBundle is enabled.
     *
     * @var boolean
     */
    protected $liipImagineBundleEnabled;

    /**
     * The class constructor.
     *
     * @param array $enabledBundles
     */
    public function __construct(array $enabledBundles)
    {
        $this->liipImagineBundleEnabled = array_key_exists('LiipImagineBundle', $enabledBundles);
    }

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
        $resolver->setDefined(array('image_path', 'image_style'));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        // Determine the URL of the image to be displayed in the form, if any.
        $imageUrl = null;
        if (array_key_exists('image_path', $options)) {
            // We try to fetch from the form model the value indicated by the image path property.
            $formData = $form->getParent()->getData();
            if (null !== $formData) {
                $accessor = PropertyAccess::createPropertyAccessor();
                $imageUrl = $accessor->getValue($formData, $options['image_path']);
            }
        }

        // The user may also pass a style for rendering the image. Because this is a feature provided
        // by the LiipImagineBundle, we first check if the component is enabled.
        $imageStyle = null;
        if ($this->liipImagineBundleEnabled && !empty($options['image_style'])) {
            $imageStyle = $options['image_style'];
        }

        $view->vars['image_url'] = $imageUrl;
        $view->vars['image_style'] = $imageStyle;
    }

}