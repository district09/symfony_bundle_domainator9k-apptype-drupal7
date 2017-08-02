<?php

namespace DigipolisGent\Domainator9k\AppTypes\DrupalSevenBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use DigipolisGent\Domainator9k\AppTypes\DrupalSevenBundle\Entity\DrupalSevenSettings;

class DrupalSevenSettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('installProfile', TextType::class, ['data' => 'digipolis'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => DrupalSevenSettings::class,
        ));
    }

    public function getBlockPrefix()
    {
        return 'drupalseven_deploy_type_settings';
    }
}
