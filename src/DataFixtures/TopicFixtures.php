<?php

namespace App\DataFixtures;

use App\Entity\Topic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TopicFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sujets = array(
            "Développement web",
            "Développement mobile",
            "Frameworks web",
            "API",
            "UX/UI",
            "Test et qualité",
            "DevOps",
            "Sécurité informatique",
            "Cloud Computing",
            "Analyse de données",
            "Frameworks mobile",
            "Progressive Web Apps",
            "Responsive design"
        );

        for($i=0;$i<count($sujets) ;$i++)
        {
            $topic = new Topic();
            $topic->setTitre($sujets[$i]);
        }

        $manager->flush();
    }
}
