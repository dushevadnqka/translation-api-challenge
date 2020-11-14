<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Translation
 *
 * @ORM\Table(name="translation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TranslationRepository")
 */
class Translation implements AppEntityInterface
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
     * @var string|null
     *
     * @ORM\Column(name="value", type="text", nullable=true)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TranslationKey", inversedBy="translations")
     * @ORM\JoinColumn(name="translationkey_id", referencedColumnName="id")
     */
    private $translationKey;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Language", inversedBy="translations")
     * @ORM\JoinColumn(name="language_id", referencedColumnName="id")
     */
    private $language;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value.
     *
     * @param string|null $value
     *
     * @return Translation
     */
    public function setValue($value = null)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value.
     *
     * @return string|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get language.
     *
     * @return Language
     */
    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage(Language $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get key.
     *
     * @return TranslationKey
     */
    public function getTranslationKey()
    {
        return $this->translationKey;
    }

    public function setTranslationKey(TranslationKey $translationKey)
    {
        $this->translationKey = $translationKey;

        return $this;
    }
}
