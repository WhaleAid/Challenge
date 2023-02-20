<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\Personne;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $rolesName = ['developer', 'apprentice' ,'Lead', 'Admin'];
        $desciptions = ['Execute Task,not able to create Project or Team but create Task and assign it to apprentice',
            'Can execute Task',
            'Can create Project and Team. Can assign Task to Developer',
            'Has Admin privileges'];

        $faker = Factory::create('fr_FR');
        for ($i=0;$i<40;$i++)
        {
            $user = new Personne();
            $user->setName($faker->name);
            $user->setFirstname($faker->firstName);
            $user->setAge($faker->numberBetween(18,65));

            $roles = $manager->getRepository(Role::class);
            $role = $roles->find(($faker->numberBetween(0,100))%3+1);

            $user->setRole($role);

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
