<?php

namespace GlassBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use GlassBundle\Entity\Section;
use Faker\Factory;

class SectionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $section = new Section();
            $section->setTitle($faker->lexify('Glasses GEEK ?????'));
            $section->setActive($faker->boolean);
            $section->setCreatedAt(new \DateTime('now'));;
            $section->setUpdatedAt(new \DateTime('now'));;
            $manager->persist($section);
            $manager->flush();
        }
    }
}
