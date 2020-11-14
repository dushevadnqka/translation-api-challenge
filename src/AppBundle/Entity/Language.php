<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Language
 *
 * @ORM\Table(name="language")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LanguageRepository")
 */
class Language
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="iso_code", type="string", length=100, unique=true)
     */
    private $isoCode;

    /**
     * @var bool
     *
     * @ORM\Column(name="rtl_flag", type="boolean")
     */
    private $rtlFlag;

    /**
     * Many Languages have Many Translation Keys.
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\TranslationKey", inversedBy="languages")
     * @ORM\JoinTable(name="languages_translationkeys")
     */
    private $translationKeys;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Translation", mappedBy="language")
     */
    private $translations;

    public function __construct()
    {
        $this->translationKeys = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Language
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set isoCode
     *
     * @param string $isoCode
     *
     * @return Language
     */
    public function setIsoCode($isoCode)
    {
        $this->isoCode = $isoCode;

        return $this;
    }

    /**
     * Get isoCode
     *
     * @return string
     */
    public function getIsoCode()
    {
        return $this->isoCode;
    }

    /**
     * Set rtlFlag
     *
     * @param boolean $rtlFlag
     *
     * @return Language
     */
    public function setRtlFlag($rtlFlag)
    {
        $this->rtlFlag = $rtlFlag;

        return $this;
    }

    /**
     * Get rtlFlag
     *
     * @return bool
     */
    public function isRtlFlag()
    {
        return $this->rtlFlag;
    }

    /**
     * Get translationKeys
     *
     * @return array
     */
    public function getTranslationKeys()
    {
        return $this->translationKeys;
    }

    public function setTranslationKeys(TranslationKey $translationKey)
    {
        $this->translationKeys[] = $translationKey;
    }
}
