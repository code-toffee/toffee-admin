<?php

namespace App\DataFixtures;

use App\Entity\AdminDept;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdminDeptFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $roleMenu = [
            [0, '华东分部'],
            [0, '华南分部'],
            [0, '西北分部'],
            [1, '研发部'],
            [1, '市场部'],
            [1, '商务部'],
            [1, '财务部'],
            [2, '研发部'],
            [2, '市场部'],
            [2, '商务部'],
            [2, '财务部'],
            [3, '研发部'],
            [3, '市场部'],
            [3, '商务部'],
            [3, '财务部'],
        ];
        foreach ($roleMenu as $value) {
            $dept = new AdminDept();
            $dept->setPid($value[0])
                ->setName($value[1]);
            $manager->persist($dept);
            $manager->flush();
        }
    }
}
