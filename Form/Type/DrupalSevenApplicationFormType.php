<?php


namespace DigipolisGent\Domainator9k\AppTypes\DrupalSevenBundle\Form\Type;

use DigipolisGent\Domainator9k\AppTypes\DrupalSevenBundle\Entity\DrupalSevenApplication;
use DigipolisGent\Domainator9k\CoreBundle\Form\Type\AbstractApplicationFormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DrupalSevenApplicationFormType
 * @package DigipolisGent\Domainator9k\AppTypes\DrupalSevenBundle\Form\Type
 */
class DrupalSevenApplicationFormType extends AbstractApplicationFormType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->add('installProfile');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefault('data_class',DrupalSevenApplication::class);
    }
}
