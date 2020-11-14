<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\TranslationKey;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TranslationKeyFixtures extends Fixture implements ORMFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $keys = array(
            'cat',
            'dog',
            'fish',
            'chicken',
            'shark',
        );

        foreach ($keys as $v) {
            $keyEntity = new TranslationKey();
            $keyEntity->setName($v);

            $manager->persist($keyEntity);
        }

        $manager->flush();
    }
}
