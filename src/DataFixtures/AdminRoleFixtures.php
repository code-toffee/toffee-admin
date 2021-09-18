<?php

namespace App\DataFixtures;

use App\Entity\AdminRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdminRoleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $role1 = new AdminRole();
        $role1->setDataScope('全部')
            ->setDescription('最大权限级别')
            ->setLevel(1)
            ->setName('超级管理员');

        $role2 = new AdminRole();
        $role2->setDataScope('本级')
            ->setDescription('-')
            ->setLevel(2)
            ->setName('普通用户');
        $manager->persist($role1);
        $manager->persist($role2);
        $manager->flush();
    }
}
