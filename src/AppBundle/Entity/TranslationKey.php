<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Workflow\Transition;

/**
 * TranslationKey
 *
 * @ORM\Table(name="translation_key")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TranslationKeyRepository")
 * @UniqueEntity("name")
 */
class TranslationKey implements AppEntityInterface
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
     * @ORM\Column(name="name", type="string", length=100, unique=true)
     */
    private $name;

    /**
     * Many Translation Keys have many Languages.
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Language", mappedBy="translationKeys", cascade={"persist"})
     */
    private $languages;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Translation", mappedBy="translationKey", cascade={"persist", "remove"})
     */
    private $translations;

    public function __construct()
    {
        $this->languages = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

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
     * Set name.
     *
     * @param string $name
     *
     * @return TranslationKey
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function setLanguages(Language $language)
    {
        $this->languages[] = $language;
    }

    public function setTranslations(Translation $translation)
    {
        $this->translations[] = $translation;
    }
}
