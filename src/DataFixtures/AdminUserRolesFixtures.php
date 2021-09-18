<?php

namespace App\DataFixtures;

use App\Entity\AdminRole;
use App\Entity\AdminUserRoles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdminUserRolesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $userRoles1 = new AdminUserRoles();
        $userRoles1->setRoleId(1)
            ->setUserId(1);

        $userRoles2 = new AdminUserRoles();
        $userRoles2->setRoleId(2)
            ->setUserId(2);
        $manager->persist($userRoles1);
        $manager->persist($userRoles2);
        $manager->flush();
    }
}
