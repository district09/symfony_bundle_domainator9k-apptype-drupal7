<?php

namespace DigipolisGent\Domainator9k\AppTypes\DrupalSevenBundle\Entity;

use DigipolisGent\Domainator9k\AppTypes\DrupalSevenBundle\Form\Type\DrupalSevenApplicationFormType;
use DigipolisGent\Domainator9k\CoreBundle\Entity\AbstractApplication;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class DrupalSevenApplication
 * @package DigipolisGent\Domainator9k\AppTypes\DrupalSevenBundle
 */
#[ORM\Table(name: 'drupal_seven_application')]
#[ORM\Entity]
class DrupalSevenApplication extends AbstractApplication
{

    const TYPE = "DRUPAL_SEVEN";

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    protected $installProfile;

    /**
     * @return string
     */
    public static function getApplicationType(): string
    {
        return self::TYPE;
    }

    /**
     * @return string
     */
    public static function getFormType(): string
    {
        return DrupalSevenApplicationFormType::class;
    }

    /**
     * @return string
     */
    public function getInstallProfile(): ?string
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

}
