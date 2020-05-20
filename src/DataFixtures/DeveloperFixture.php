<?php

namespace App\DataFixtures;

use App\Entity\Developer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DeveloperFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $developerNames = [
            'Ali',
            'Ayşe',
            'Kemal',
            'Cengiz',
            'Alameddin',
        ];
        for ($i = 1; $i <= 5; $i++) {
            $dev = new Developer();
            $dev
                ->setFullName($developerNames[$i - 1])
                ->setLevel($i);
            $manager->persist($dev);
        }
        $manager->flush();
    }
}
