<?php

namespace App\DataFixtures;


use App\Entity\Dev;
use App\Entity\Lead;
use App\Entity\Manager;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        for ($i=0;$i<3;$i++)
        {
            $user = new Manager();
            $user->setName($faker->name);
            $user->setFirstname($faker->firstName);
            $user->setEmail($faker->email);
            $user->setPassword($faker->password);
            $user->setRoles(["ROLE_MANAGER"]);

            $manager->persist($user);
        }

        for ($i=0;$i<5;$i++)
        {
            $user = new Lead();
            $user->setName($faker->name);
            $user->setFirstname($faker->firstName);
            $user->setEmail($faker->email);
            $user->setPassword($faker->password);

            $user->setRoles(["ROLE_LEAD"]);

            $manager->persist($user);
        }

        for ($i=0;$i<12;$i++)
        {
            $user = new Dev();
            $user->setName($faker->name);
            $user->setFirstname($faker->firstName);
            $user->setEmail($faker->email);
            $user->setPassword($faker->password);
            $user->setRoles(["ROLE_DEV"]);

            $manager->persist($user);
        }

        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            RoleFixtures::class,
        ];
    }
}
