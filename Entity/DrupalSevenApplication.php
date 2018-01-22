<?php

namespace DigipolisGent\Domainator9k\AppTypes\DrupalSevenBundle\Entity;

use DigipolisGent\Domainator9k\CoreBundle\Entity\AbstractApplication;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class DrupalSevenApplication
 * @package DigipolisGent\Domainator9k\AppTypes\DrupalSevenBundle
 *
 * @ORM\Entity()
 */
class DrupalSevenApplication extends AbstractApplication
{

    const TYPE = "DRUPAL_SEVEN";

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(min="3", max="255")
     */
    protected $installProfile;


    public static function getType()
    {
        return self::TYPE;
    }

    /**
     * @return string
     */
    public function getInstallProfile()
    {
        return $this->installProfile;
    }

    /**
     * @param string $installProfile
     */
    public function setInstallProfile(string $installProfile)
    {
        $this->installProfile = $installProfile;
    }

    /**
     * @return array
     */
    public static function getTemplateReplacements(): array
    {
        $templateReplacements = parent::getTemplateReplacements();
        $templateReplacements['installProfile()'] =  'getInstallProfile()';

        return $templateReplacements;
    }
}