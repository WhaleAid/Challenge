<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $rolesName = ['developer', 'apprentice' ,'Lead', 'Admin'];

        $desciptions = ['Execute Task,not able to create Project or Team but create Task and assign it to apprentice',
            'Can execute Task',
            'Can create Project and Team. Can assign Task to Developer',
            'Has Admin privileges'];

        for($i=0; $i<count($rolesName);$i++)
        {
            $role = new Role();
            $role->setRole($rolesName[$i]);
            $role->setDescription($desciptions[$i]);
            $manager->persist($role);
        }


        $manager->flush();
    }
}
