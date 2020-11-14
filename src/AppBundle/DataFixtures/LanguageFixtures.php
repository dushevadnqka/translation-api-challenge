<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Language;
use AppBundle\Entity\TranslationKey;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LanguageFixtures extends Fixture implements ORMFixtureInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $languages = array(
            'English' => array(
                'isoCode' => "en",
                'rtlFlag' => false,
            ),
            'Italian' => array(
                'isoCode' => "it",
                'rtlFlag' => false,
            ),
            'French' => array(
                'isoCode' => "fr",
                'rtlFlag' => false,
            ),
            'Dutch' => array(
                'isoCode' => "nl",
                'rtlFlag' => false,
            ),
            'Persian' => array(
                'isoCode' => "fa",
                'rtlFlag' => true,
            ),
        );

        $keys = $manager
            ->getRepository(TranslationKey::class)
            ->findAll();

        foreach ($languages as $k => $v) {
            $langEntity = new Language();
            $langEntity->setName($k);
            $langEntity->setIsoCode($v['isoCode']);
            $langEntity->setRtlFlag($v['rtlFlag']);

            foreach ($keys as $key) {
                $langEntity->setTranslationKeys($key);
            }

            $manager->persist($langEntity);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            TranslationKeyFixtures::class,
        );
    }
}
