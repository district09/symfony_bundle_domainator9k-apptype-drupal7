<?php

namespace DigipolisGent\Domainator9k\AppTypes\DrupalSevenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

//todo basesetup, daar app en id in, installprofile in extended entity

/**
 * @ORM\Entity
 * @ORM\Table(name="drupalseven_settings")
 */
class DrupalSevenSettings
{
    /**
     * @var int
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length(min="3", max="255")
     */
    protected $installProfile;

    /**
     * @ORM\ManyToOne(targetEntity="DigipolisGent\Domainator9k\CoreBundle\Entity\Application")
     * @ORM\JoinColumn(name="application_id", referencedColumnName="id")
     **/
    protected $application;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
    public function setInstallProfile($installProfile)
    {
        $this->installProfile = $installProfile;
    }

    /**
     * @return mixed
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param mixed $application
     */
    public function setApplication($application)
    {
        $this->application = $application;
    }
}
