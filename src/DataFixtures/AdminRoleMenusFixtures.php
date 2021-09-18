<?php

namespace App\DataFixtures;

use App\Entity\AdminRoleMenus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdminRoleMenusFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $roleMenu = [
            [1, 1],
            [1, 3],
            [1, 4],
            [2, 2],
            [2, 5],
            [2, 6],
        ];
        foreach ($roleMenu as $value) {
            $rom = new AdminRoleMenus();
            $rom->setRoleId($value[0])
                ->setMenuId($value[1]);
            $manager->persist($rom);
            $manager->flush();
        }
    }
}
