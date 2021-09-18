<?php

namespace App\DataFixtures;

use App\Entity\AdminUser;
use App\Utils\PasswordSafeUtils;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdminUserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $adminUser1 = new AdminUser();
        $adminUser1->setUserName('admin')
            ->setIsAdmin(true)
            ->setRealName('管理员')
            ->setDeptId(4)
            ->setDeptPath('1-4')
            ->setHomePath('/dashboard/workbench')
            ->setPassword(PasswordSafeUtils::generate('admin888'));

        $adminUser2 = new AdminUser();
        $adminUser2->setUserName('user')
            ->setRealName('测试账号')
            ->setDeptId(4)
            ->setDeptPath('1-4')
            ->setPassword(PasswordSafeUtils::generate('user888'));


        $manager->persist($adminUser1);
        $manager->persist($adminUser2);
        $manager->flush();
    }
}
