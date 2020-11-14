<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements ORMFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $users = array(
            'admin' => array(
                'email' => 'user.admin@mail.com',
                'roles' => array('ROLE_ADMIN'),
            ),
            'reader' => array(
                'email' => 'user.reader@mail.com',
                'roles' => array('ROLE_READER'),
            ),
        );

        foreach ($users as $k => $v) {
            $user = new User();
            $user->setUsername($k);
            $user->setEmail($v['email']);

            $password = $this->encoder->encodePassword($user, '123456');
            $user->setPassword($password);

            $user->setRoles($v['roles']);
            $user->setEnabled(true);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
