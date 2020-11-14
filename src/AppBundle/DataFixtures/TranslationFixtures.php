<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Translation;
use AppBundle\Entity\TranslationKey;
use AppBundle\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TranslationFixtures extends Fixture implements ORMFixtureInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $keys = array(
            array('lang' => 1, 'value' => 'cat en', 'keyID' => 1),
            array('lang' => 1, 'value' => 'dog en', 'keyID' => 2),
            array('lang' => 1, 'value' => 'fish en', 'keyID' => 3),
            array('lang' => 1, 'value' => 'chicken en', 'keyID' => 4),
            array('lang' => 1, 'value' => 'shark en', 'keyID' => 5),
            array('lang' => 2, 'value' => 'cat it', 'keyID' => 1),
            array('lang' => 2, 'value' => 'dog it', 'keyID' => 2),
            array('lang' => 2, 'value' => 'fish it', 'keyID' => 3),
            array('lang' => 2, 'value' => 'chicken it', 'keyID' => 4),
            array('lang' => 2, 'value' => 'shark it', 'keyID' => 5),
            array('lang' => 3, 'value' => 'cat fr', 'keyID' => 1),
            array('lang' => 3, 'value' => 'dog fr', 'keyID' => 2),
            array('lang' => 3, 'value' => 'fish fr', 'keyID' => 3),
            array('lang' => 3, 'value' => 'chicken fr', 'keyID' => 4),
            array('lang' => 3, 'value' => 'shark fr', 'keyID' => 5),
            array('lang' => 4, 'value' => 'cat nl', 'keyID' => 1),
            array('lang' => 4, 'value' => 'dog nl', 'keyID' => 2),
            array('lang' => 4, 'value' => 'fish nl', 'keyID' => 3),
            array('lang' => 4, 'value' => 'chicken nl', 'keyID' => 4),
            array('lang' => 4, 'value' => 'shark nl', 'keyID' => 5),
            array('lang' => 5, 'value' => 'cat fa', 'keyID' => 1),
            array('lang' => 5, 'value' => 'dog fa', 'keyID' => 2),
            array('lang' => 5, 'value' => 'fish fa', 'keyID' => 3),
            array('lang' => 5, 'value' => 'chicken fa', 'keyID' => 4),
            array('lang' => 5, 'value' => 'shark fa', 'keyID' => 5),

        );

        $languages = $manager
            ->getRepository(Language::class)
            ->findAll();

        $translationKeys = $manager
            ->getRepository(TranslationKey::class)
            ->findAll();

        foreach ($keys as $v) {
            foreach ($languages as $language) {
                if ($v['lang'] === $language->getId()) {
                    $translationEntity = new Translation();
                    $translationEntity->setValue($v['value']);
                    $translationEntity->setLanguage($language);

                    foreach ($translationKeys as $translationKey) {
                        if ($v['keyID'] === $translationKey->getId()) {
                            $translationEntity->setTranslationKey($translationKey);
                        }
                    }

                    $manager->persist($translationEntity);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            LanguageFixtures::class,
        );
    }
}
