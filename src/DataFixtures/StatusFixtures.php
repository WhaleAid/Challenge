<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $status1 = new Status();
        $status1->setStatueTache("A Faire");

        $status2 = new Status();
        $status2->setStatueTache("En Progression");

        $status3 = new Status();
        $status3->setStatueTache("A Tester");

        $status4 = new Status();
        $status4->setStatueTache("Terminé");

        $manager->persist($status1);
        $manager->persist($status2);
        $manager->persist($status3);
        $manager->persist($status4);

        $manager->flush();
    }
}
