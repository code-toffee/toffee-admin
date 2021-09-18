<?php

namespace App\DataFixtures;

use App\Entity\AdminMenu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdminMenuFixtures extends Fixture
{
    private ObjectManager $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $array = [
            [
                'pid'       => 0,
                'type'      => 1,
                'path'      => '/dashboard',
                'component' => 'LAYOUT',
                'title'     => 'routes.dashboard.dashboard',
                'icon'      => 'bx:bx-home',
                'name'      => 'Dashboard',
                'redirect'  => '/dashboard/analysis',
                'childern'  => [
                    //index
                    [
                        'type'      => 2,
                        'path'      => 'analysis',
                        'component' => '/dashboard/analysis/index',
                        'title'     => 'routes.dashboard.analysis',
                        'icon'      => 'bx:bx-home',
                        'name'      => 'Analysis',
                        'redirect'  => ''
                    ],
                    [
                        'type'      => 2,
                        'path'      => 'workbench',
                        'component' => '/dashboard/workbench/index',
                        'title'     => 'routes.dashboard.workbench',
                        'icon'      => 'bx:bx-home',
                        'name'      => 'Workbench',
                        'redirect'  => ''
                    ],
                ]

            ],
            [
                'pid'       => 0,
                'type'      => 1,
                'path'      => '/link',
                'component' => 'LAYOUT',
                'title'     => 'routes.demo.iframe.frame',
                'icon'      => 'ion:tv-outline',
                'name'      => 'Link',
                'redirect'  => '',
                'childern'  => [
                    //demo
                    [
                        'type'      => 2,
                        'path'      => 'doc',
                        'component' => '',
                        'title'     => 'routes.demo.iframe.doc',
                        'icon'      => 'bx:bx-home',
                        'name'      => 'Doc',
                        'redirect'  => '',
                        'iFrame'    => true,
                        'framePath' => 'https://vvbin.cn/doc-next/'
                    ],
                    [
                        'type'      => 2,
                        'path'      => 'https://vvbin.cn/doc-next/',
                        'component' => '',
                        'title'     => 'routes.demo.iframe.docExternal',
                        'icon'      => 'bx:bx-home',
                        'name'      => 'routes.demo.iframe.docExternal',
                        'redirect'  => ''
                    ],
                ]

            ],
            [
                'pid'       => 0,
                'type'      => 1,
                'path'      => '/system',
                'component' => 'LAYOUT',
                'title'     => 'routes.demo.system.moduleName',
                'icon'      => 'ion:settings-outline',
                'name'      => 'System',
                'redirect'  => '/system/account',
                'childern'  => [
                    // system
                    [
                        'type'      => 2,
                        'path'      => 'account',
                        'name'      => 'AccountManagement',
                        'component' => '/system/account/index',
                        'title'     => 'routes.demo.system.account',
                        'childern'  => [
                            [
                                'type'       => 3,
                                'path'       => '',
                                'component'  => '',
                                'title'      => '新增账号',
                                'icon'       => '',
                                'name'       => '',
                                'redirect'   => '',
                                'permission' => 'user:add'
                            ],
                            [
                                'type'       => 3,
                                'path'       => '',
                                'component'  => '',
                                'title'      => '编辑账号',
                                'icon'       => '',
                                'name'       => '',
                                'redirect'   => '',
                                'permission' => 'user:update'
                            ],
                            [
                                'type'       => 3,
                                'path'       => '',
                                'component'  => '',
                                'title'      => '删除账号',
                                'icon'       => '',
                                'name'       => '',
                                'redirect'   => '',
                                'permission' => 'user:delete'
                            ],

                        ]
                    ],
                    [
                        'type'      => 2,
                        'path'      => 'role',
                        'name'      => 'RoleManagement',
                        'component' => '/system/role/index',
                        'title'     => 'routes.demo.system.role',
                        'childern'  => [
                            [
                                'type'       => 3,
                                'path'       => '',
                                'component'  => '',
                                'title'      => '新增角色',
                                'icon'       => '',
                                'name'       => '',
                                'redirect'   => '',
                                'permission' => 'role:add'
                            ],
                            [
                                'type'       => 3,
                                'path'       => '',
                                'component'  => '',
                                'title'      => '编辑角色',
                                'icon'       => '',
                                'name'       => '',
                                'redirect'   => '',
                                'permission' => 'role:update'
                            ],
                            [
                                'type'       => 3,
                                'path'       => '',
                                'component'  => '',
                                'title'      => '删除角色',
                                'icon'       => '',
                                'name'       => '',
                                'redirect'   => '',
                                'permission' => 'role:delete'
                            ],

                        ]
                    ],
                    [
                        'type'              => 2,
                        'path'              => 'account_detail/:id',
                        'name'              => 'AccountDetail',
                        'component'         => '/system/account/AccountDetail',
                        'title'             => 'routes.demo.system.account_detail',
                        'ignoreKeepAlive'   => true,
                        'hideMenu'          => true,
                        'currentActiveMenu' => '/system/account',
                    ],
                    [
                        'type'            => 2,
                        'path'            => 'menu',
                        'name'            => 'MenuManagement',
                        'component'       => '/system/menu/index',
                        'title'           => 'routes.demo.system.menu',
                        'ignoreKeepAlive' => true,
                        'childern'        => [
                            [
                                'type'       => 3,
                                'path'       => '',
                                'component'  => '',
                                'title'      => '新增菜单',
                                'icon'       => '',
                                'name'       => '',
                                'redirect'   => '',
                                'permission' => 'menu:add'
                            ],
                            [
                                'type'       => 3,
                                'path'       => '',
                                'component'  => '',
                                'title'      => '编辑菜单',
                                'icon'       => '',
                                'name'       => '',
                                'redirect'   => '',
                                'permission' => 'menu:update'
                            ],
                            [
                                'type'       => 3,
                                'path'       => '',
                                'component'  => '',
                                'title'      => '删除菜单',
                                'icon'       => '',
                                'name'       => '',
                                'redirect'   => '',
                                'permission' => 'menu:delete'
                            ],
                        ]

                    ],
                    [
                        'type'            => 2,
                        'path'            => 'dept',
                        'name'            => 'DeptManagement',
                        'component'       => '/system/dept/index',
                        'title'           => 'routes.demo.system.dept',
                        'ignoreKeepAlive' => true,
                        'childern'        => [
                            [
                                'type'       => 3,
                                'path'       => '',
                                'component'  => '',
                                'title'      => '新增部门',
                                'icon'       => '',
                                'name'       => '',
                                'redirect'   => '',
                                'permission' => 'dept:add'
                            ],
                            [
                                'type'       => 3,
                                'path'       => '',
                                'component'  => '',
                                'title'      => '编辑部门',
                                'icon'       => '',
                                'name'       => '',
                                'redirect'   => '',
                                'permission' => 'dept:update'
                            ],
                            [
                                'type'       => 3,
                                'path'       => '',
                                'component'  => '',
                                'title'      => '删除部门',
                                'icon'       => '',
                                'name'       => '',
                                'redirect'   => '',
                                'permission' => 'dept:delete'
                            ],
                        ]

                    ],
                    [
                        'type'            => 2,
                        'path'            => 'changePassword',
                        'name'            => 'ChangePassword',
                        'component'       => '/system/password/index',
                        'title'           => 'routes.demo.system.password',
                        'ignoreKeepAlive' => true,
                    ],
                ]
            ],
        ];

        $this->recursion($array);
    }

    private function recursion(array $datas, ?int $parentMenuId = null)
    {
        foreach ($datas as $item) {
            $menu = $this->addMenu($item, $parentMenuId);
            $this->manager->persist($menu);
            $this->manager->flush();
            if (isset($item['childern'])) {
                $this->recursion($item['childern'], $menu->getId());
            }
        }
    }

    private function addMenu(array $data, ?int $parentMenuId = null): AdminMenu
    {
        $pid = is_null($parentMenuId) ? $data['pid'] : $parentMenuId;

        $menu1 = new AdminMenu();
        $menu1->setPid($pid);
        $menu1->setType($data['type']);
        $menu1->setPath($data['path'] ?? '');
        $menu1->setComponent($data['component'] ?? '');
        $menu1->setTitle($data['title']);
        $menu1->setIcon($data['icon'] ?? '');
        $menu1->setName($data['name'] ?? '');
        $menu1->setRedirect($data['redirect'] ?? '');
        $menu1->setIFrame($data['iFrame'] ?? false);
        $menu1->setFramePath($data['framePath'] ?? '');
        $menu1->setIgnoreKeepAlive($data['ignoreKeepAlive'] ?? false);
        $menu1->setCurrentActiveMenu($data['currentActiveMenu'] ?? '');
        $menu1->setHideMenu($data['hideMenu'] ?? false);
        $menu1->setPermission($data['permission'] ?? '');
        return $menu1;
    }
}
