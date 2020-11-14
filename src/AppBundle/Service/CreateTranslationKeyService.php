<?php

namespace AppBundle\Service;

use AppBundle\Repository\TranslationKeyRepository;
use AppBundle\Repository\LanguageRepository;
use AppBundle\Entity\Translation;
use AppBundle\Entity\TranslationKey;

class CreateTranslationKeyService
{
    private $keyRepo;
    private $languageRepo;

    public function __construct(TranslationKeyRepository $keyRepo, LanguageRepository $languageRepo)
    {
        $this->keyRepo = $keyRepo;
        $this->languageRepo = $languageRepo;
    }

    public function createKey(string $name): void
    {
        $languages = $this->languageRepo->findAll();

        $entity = new TranslationKey();
        $entity->setName($name);

        foreach ($languages as $language) {
            // assign any lang to the key
            $language->setTranslationKeys($entity);
            $entity->setLanguages($language);
        
            // create & assign translations for any lang to the key
            $translation = new Translation();
            $translation->setTranslationKey($entity);
            $translation->setLanguage($language);
            $entity->setTranslations($translation);
        }

        $this->keyRepo->saveEntity($entity);
    }
}
