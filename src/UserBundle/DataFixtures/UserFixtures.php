<?php

namespace UserBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setName($faker->firstNameMale());
            $user->setEmail($faker->unique()->freeEmail);
            $user->setPassword(sha1($faker->password));
            if ($i === 0) {
                $user->setAdmin(1);
            } else {
                $user->setAdmin(0);
            }
            $user->setCreatedAt(new \DateTime('now'));;
            $user->setUpdatedAt(new \DateTime('now'));;
            $manager->persist($user);
            $manager->flush();
        }
    }
}
