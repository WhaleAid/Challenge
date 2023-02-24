<?php

namespace App\DataFixtures;

use App\Entity\Priorite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PrioriteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $priorite1 = new Priorite();
        $priorite1->setNiveauPriorite("Faible");

        $priorite2 = new Priorite();
        $priorite2->setNiveauPriorite("Moyenne");

        $priorite3 = new Priorite();
        $priorite3->setNiveauPriorite("Forte");



        $manager->persist($priorite1);
        $manager->persist($priorite2);
        $manager->persist($priorite3);

        $manager->flush();
    }
}
