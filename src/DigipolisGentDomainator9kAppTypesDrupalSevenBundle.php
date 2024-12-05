<?php

namespace DigipolisGent\Domainator9k\AppTypes\DrupalSevenBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class DigipolisGentDomainator9kAppTypesDrupalSevenBundle extends AbstractBundle
{
    #[\Override]
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.yml');
    }
}
