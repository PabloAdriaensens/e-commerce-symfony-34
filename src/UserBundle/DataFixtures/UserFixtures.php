<?php

namespace UserBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName("PruebaFixture");
        $user->setEmail("prueba@gmail.com");
        $user->setPassword("123456");
        $user->setAdmin("0");
        $user->setCreatedAt(new \DateTime('now'));
        $user->setUpdatedAt(new \DateTime('now'));
        $manager->persist($user);
        $manager->flush();
    }
}
