<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210914092029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin_dept (id INT AUTO_INCREMENT NOT NULL, pid INT DEFAULT 0 NOT NULL COMMENT \'上级部门\', name VARCHAR(255) DEFAULT \'\' NOT NULL COMMENT \'部门名称\', remark VARCHAR(255) DEFAULT \'\' NOT NULL COMMENT \'备注\', dept_sort INT DEFAULT 1 NOT NULL COMMENT \'部门排序\', status TINYINT(1) DEFAULT \'1\' NOT NULL COMMENT \'状态,1-启用,2-禁用\', created_time DATETIME DEFAULT NULL COMMENT \'创建时间\', updated_time DATETIME DEFAULT NULL COMMENT \'更新时间\', INDEX pid_idx (pid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'部门表\' ');
        $this->addSql('CREATE TABLE admin_log (id BIGINT AUTO_INCREMENT NOT NULL, uid INT NOT NULL COMMENT \'用户Id\', descript VARCHAR(255) DEFAULT \'\' NOT NULL COMMENT \'描述\', method VARCHAR(15) DEFAULT \'\' NOT NULL COMMENT \'请求方式\', controller VARCHAR(255) DEFAULT \'\' NOT NULL COMMENT \'请求控制器\', request_ip VARCHAR(255) DEFAULT \'\' NOT NULL COMMENT \'请求ip\', ip_addr VARCHAR(255) DEFAULT \'\' NOT NULL COMMENT \'ip地址\', brower VARCHAR(255) DEFAULT \'\' NOT NULL COMMENT \'浏览器\', request LONGTEXT NOT NULL COMMENT \'请求参数\', response LONGTEXT NOT NULL COMMENT \'请求参数\', created_time DATETIME DEFAULT NULL COMMENT \'创建时间\', INDEX user_idx (uid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'日志表\' ');
        $this->addSql('CREATE TABLE admin_menu (id INT AUTO_INCREMENT NOT NULL, pid INT DEFAULT 0 NOT NULL COMMENT \'上级菜单ID\', type INT NOT NULL COMMENT \'菜单类型 1-目录，2-菜单，3-按钮\', status TINYINT(1) DEFAULT \'1\' NOT NULL COMMENT \'是否启用\', permission VARCHAR(255) DEFAULT \'\' NOT NULL COMMENT \'权限标识符\', path VARCHAR(255) DEFAULT \'\' NOT NULL COMMENT \'链接地址\', redirect VARCHAR(255) DEFAULT \'\' NOT NULL COMMENT \'重定向\', name VARCHAR(255) DEFAULT \'\' NOT NULL COMMENT \'组件名称\', component VARCHAR(255) DEFAULT \'\' NOT NULL COMMENT \'组件\', title VARCHAR(255) NOT NULL COMMENT \'菜单标题\', icon VARCHAR(255) DEFAULT \'\' NOT NULL COMMENT \'图标\', menu_sort INT DEFAULT 1 NOT NULL COMMENT \'排序\', i_frame TINYINT(1) DEFAULT \'0\' NOT NULL COMMENT \'是否外链\', frame_path VARCHAR(255) DEFAULT \'\' NOT NULL COMMENT \'frame链接地址\', cache TINYINT(1) DEFAULT \'0\' NOT NULL COMMENT \'是否启用缓存\', hidden TINYINT(1) DEFAULT \'0\' NOT NULL COMMENT \'是否隐藏\', ignore_keep_alive TINYINT(1) DEFAULT \'0\' NOT NULL COMMENT \'是否忽略KeepAlive缓存\', affix TINYINT(1) DEFAULT \'0\' NOT NULL COMMENT \'是否固定在标签上\', hide_breadcrumb TINYINT(1) DEFAULT \'0\' NOT NULL COMMENT \'是否隐藏该路由在面包屑上面的显示\', hide_children_in_menu TINYINT(1) DEFAULT \'0\' NOT NULL COMMENT \'是否隐藏所有子菜单\', current_active_menu VARCHAR(255) DEFAULT \'\' NOT NULL COMMENT \'当前激活的菜单。用于配置详情页时左侧激活的菜单路径\', hide_tab TINYINT(1) DEFAULT \'0\' NOT NULL COMMENT \'当前路由是否不在标签页显示\', hide_menu TINYINT(1) DEFAULT \'0\' NOT NULL COMMENT \'当前路由是否不在菜单中显示\', ignore_route TINYINT(1) DEFAULT \'0\' NOT NULL COMMENT \'是否生成对应的菜单而忽略路由\', hide_path_for_children TINYINT(1) DEFAULT \'0\' NOT NULL COMMENT \'是否在子级菜单的完整path中忽略本级path\', created_time DATETIME DEFAULT NULL COMMENT \'创建时间\', updated_time DATETIME DEFAULT NULL COMMENT \'更新时间\', INDEX permission_idx (permission), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'菜单表\' ');
        $this->addSql('CREATE TABLE admin_role (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COMMENT \'角色名称\', level INT DEFAULT 1 NOT NULL COMMENT \'角色级别，越小越大最小为1，下级角色无法操作上级角色数据\', description VARCHAR(255) NOT NULL COMMENT \'角色描述\', data_scope VARCHAR(255) NOT NULL COMMENT \'数据权限\', created_time DATETIME DEFAULT NULL COMMENT \'创建时间\', updated_time DATETIME DEFAULT NULL COMMENT \'更新时间\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'角色表\' ');
        $this->addSql('CREATE TABLE admin_role_depts (dept_id INT NOT NULL COMMENT \'部门id\', role_id INT NOT NULL COMMENT \'角色id\', INDEX role_idx (role_id), PRIMARY KEY(dept_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'角色部门关联表\' ');
        $this->addSql('CREATE TABLE admin_role_menus (menu_id INT NOT NULL COMMENT \'菜单id\', role_id INT NOT NULL COMMENT \'角色id\', INDEX role_idx (role_id), PRIMARY KEY(menu_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'角色菜单关联表\' ');
        $this->addSql('CREATE TABLE admin_user (id INT AUTO_INCREMENT NOT NULL, dept_id INT DEFAULT 0 NOT NULL COMMENT \'所属部门\', dept_path VARCHAR(255) DEFAULT \'\' NOT NULL COMMENT \'部门路径\', user_name VARCHAR(15) NOT NULL COMMENT \'账号\', real_name VARCHAR(15) DEFAULT \'\' NOT NULL COMMENT \'真实姓名\', password VARCHAR(80) NOT NULL COMMENT \'密码\', phone VARCHAR(15) DEFAULT \'\' NOT NULL COMMENT \'手机号\', home_path VARCHAR(255) DEFAULT \'\' NOT NULL COMMENT \'首页path\', is_admin TINYINT(1) DEFAULT \'0\' NOT NULL COMMENT \'是否为超级管理员\', state TINYINT(1) DEFAULT \'1\' NOT NULL COMMENT \'用户状态【0冻结，1正常】\', created_time DATETIME DEFAULT NULL COMMENT \'创建时间\', updated_time DATETIME DEFAULT NULL COMMENT \'更新时间\', UNIQUE INDEX UNIQ_AD8A54A924A232CF (user_name), UNIQUE INDEX UNIQ_AD8A54A937842052 (real_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'管理员表\' ');
        $this->addSql('CREATE TABLE admin_user_roles (user_id INT NOT NULL COMMENT \'用户Id\', role_id INT NOT NULL COMMENT \'角色id\', INDEX role_idx (role_id), PRIMARY KEY(user_id, role_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'管理员用户角色关联表\' ');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE admin_dept');
        $this->addSql('DROP TABLE admin_log');
        $this->addSql('DROP TABLE admin_menu');
        $this->addSql('DROP TABLE admin_role');
        $this->addSql('DROP TABLE admin_role_depts');
        $this->addSql('DROP TABLE admin_role_menus');
        $this->addSql('DROP TABLE admin_user');
        $this->addSql('DROP TABLE admin_user_roles');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
