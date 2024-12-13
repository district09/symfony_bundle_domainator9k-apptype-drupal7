<?php

namespace DigipolisGent\Domainator9k\AppTypes\DrupalSevenBundle\CacheClearer;

use DigipolisGent\CommandBuilder\CommandBuilder;
use DigipolisGent\Domainator9k\CoreBundle\CacheClearer\CacheClearerInterface;
use DigipolisGent\Domainator9k\CoreBundle\CLI\CliInterface;

class DrupalSevenCacheClearer implements CacheClearerInterface
{

    /**
     * {@inheritdoc}
     */
    public function clearCache($object, CliInterface $cli)
    {
        return $cli->execute(
            CommandBuilder::create('drush')
                ->addArgument('cc')
                ->addArgument('all')
        );
    }
}
