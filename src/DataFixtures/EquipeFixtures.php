<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EquipeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //$equipe = new Equipe();
        // $manager->persist($product);

        $manager->flush();
    }
}
