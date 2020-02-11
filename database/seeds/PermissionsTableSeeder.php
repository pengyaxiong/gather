<?php

use Illuminate\Database\Seeder;
use App\Models\System\Permission;
class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * 后台首页
         */
        Permission::create([
            'id' => 1,
            'name' => 'admin',
            'label' => '首页',
            'parent_id' => 0,
            'icon' => 'am-icon-home',
            'sort_order' => 1
        ]);
        /**
         * 系统管理
         */
        Permission::create([
            'id' => 2,
            'name' => 'system',
            'label' => '系统管理',
            'parent_id' => 0,
            'icon' => 'am-icon-gear am-icon-spin',
            'sort_order' => 2
        ]);

        /**
         * 菜单与权限
         */
        Permission::create([
            'id' => 3,
            'name' => 'system.permission.index',
            'label' => '菜单与权限',
            'parent_id' => 2,
            'icon' => 'am-icon-lock',
            'sort_order' => 3
        ]);
        /*菜单与权限（删除）*/
        Permission::create([
            'id' => 4,
            'name' => 'system.permission.destroy',
            'label' => '删除',
            'parent_id' => 3,
        ]);
        /*菜单与权限（保存）*/
        Permission::create([
            'id' => 5,
            'name' => 'system.permission.store',
            'label' => '保存',
            'parent_id' => 3,
        ]);
        /*菜单与权限（新增）*/
        Permission::create([
            'id' => 6,
            'name' => 'system.permission.create',
            'label' => '新增',
            'parent_id' => 3,
        ]);
        /* 菜单与权限（编辑）*/
        Permission::create([
            'id' => 7,
            'name' => 'system.permission.edit',
            'label' => '编辑',
            'parent_id' => 3,
        ]);
        /*菜单与权限（更新）*/
        Permission::create([
            'id' => 8,
            'name' => 'system.permission.update',
            'label' => '更新',
            'parent_id' => 3,
        ]);
        /* 菜单与权限（排序）*/
        Permission::create([
            'id' => 9,
            'name' => 'system.permission.sort_order',
            'label' => '排序',
            'parent_id' => 3,
        ]);
        /**
         * 用户管理
         */
        Permission::create([
            'id' => 10,
            'name' => 'system.user.index',
            'label' => '用户管理',
            'parent_id' => 2,
            'icon' => 'am-icon-user',
            'sort_order' => 4
        ]);
        /*用户管理（删除）*/
        Permission::create([
            'id' => 11,
            'name' => 'system.user.destroy',
            'label' => '删除',
            'parent_id' => 10,
        ]);
        /*用户管理（保存）*/
        Permission::create([
            'id' => 12,
            'name' => 'system.user.store',
            'label' => '保存',
            'parent_id' => 10,
        ]);
        /*用户管理（新增）*/
        Permission::create([
            'id' => 13,
            'name' => 'system.user.create',
            'label' => '新增',
            'parent_id' => 10,
        ]);
        /* 用户管理（编辑）*/
        Permission::create([
            'id' => 14,
            'name' => 'system.user.edit',
            'label' => '编辑',
            'parent_id' => 10,
        ]);
        /*用户管理（更新）*/
        Permission::create([
            'id' => 15,
            'name' => 'system.user.update',
            'label' => '更新',
            'parent_id' => 10,
        ]);

        /**
         * 用户组管理
         */
        Permission::create([
            'id' => 16,
            'name' => 'system.role.index',
            'label' => '用户组管理',
            'parent_id' => 2,
            'icon' => 'am-icon-users',
            'sort_order' => 5
        ]);
        /*用户组管理（删除）*/
        Permission::create([
            'id' => 17,
            'name' => 'system.role.destroy',
            'label' => '删除',
            'parent_id' => 16,
        ]);
        /*用户组管理（保存）*/
        Permission::create([
            'id' => 18,
            'name' => 'system.role.store',
            'label' => '保存',
            'parent_id' => 16,
        ]);
        /*用户组管理（新增）*/
        Permission::create([
            'id' => 19,
            'name' => 'system.role.create',
            'label' => '新增',
            'parent_id' => 16,
        ]);
        /* 用户组管理（编辑）*/
        Permission::create([
            'id' => 20,
            'name' => 'system.role.edit',
            'label' => '编辑',
            'parent_id' => 16,
        ]);
        /*用户组管理（更新）*/
        Permission::create([
            'id' => 21,
            'name' => 'system.role.update',
            'label' => '更新',
            'parent_id' => 16,
        ]);
        /**
         * 系统设置
         */
        Permission::create([
            'id' => 22,
            'name' => 'system.config.edit',
            'label' => '系统设置',
            'parent_id' => 2,
            'icon' => 'am-icon-desktop',
            'sort_order' => 6
        ]);
        /*系统设置（更新）*/
        Permission::create([
            'id' => 23,
            'name' => 'system.config.update',
            'label' => '更新',
            'parent_id' =>22,
        ]);

        /**
         * 缓存管理
         */
        Permission::create([
            'id' => 24,
            'name' => 'system.cache.index',
            'label' => '缓存管理',
            'parent_id' => 2,
            'icon' => 'am-icon-refresh am-icon-spin',
            'sort_order' => 8
        ]);
        /*缓存管理（删除）*/
        Permission::create([
            'id' => 25,
            'name' => 'system.cache.destroy',
            'label' => '删除',
            'parent_id' => 24,
        ]);

        /**
         * 文件管理
         */
        Permission::create([
            'id' => 26,
            'name' => 'system.photo.index',
            'label' => '文件管理',
            'parent_id' => 2,
            'icon' => 'am-icon-file-image-o',
            'sort_order' => 7
        ]);
        /*文件管理（上传网站图标）*/
        Permission::create([
            'id' => 27,
            'name' => 'system.photo.upload_icon',
            'label' => '上传网站图标',
            'parent_id' => 26,
        ]);
        /*文件管理（上传网站背景图）*/
        Permission::create([
            'id' => 28,
            'name' => 'system.photo.upload_background_img',
            'label' => '上传网站背景图',
            'parent_id' => 26,
        ]);
        /*文件管理（上传文件）*/
        Permission::create([
            'id' => 29,
            'name' => 'system.photo.upload',
            'label' => '上传文件',
            'parent_id' => 26,
        ]);
        /*文件管理（读取文件）*/
        Permission::create([
            'id' => 30,
            'name' => 'system.photo.get_contents',
            'label' => '读取文件',
            'parent_id' => 26,
        ]);
        /*文件管理（上传公共文件）*/
        Permission::create([
            'id' => 31,
            'name' => 'system.photo.upload_public',
            'label' => '上传公共文件',
            'parent_id' => 26,
        ]);
        /*文件管理（删除文件）*/
        Permission::create([
            'id' => 32,
            'name' => 'system.photo.destroy_file',
            'label' => '删除文件',
            'parent_id' => 26,
        ]);
        /*文件管理（更新文件）*/
        Permission::create([
            'id' => 33,
            'name' => 'system.photo.update_file',
            'label' => '更新文件',
            'parent_id' => 26,
        ]);
        /*文件管理（上传图片文件）*/
        Permission::create([
            'id' => 34,
            'name' => 'system.photo.upload_img',
            'label' => '上传图片文件',
            'parent_id' => 26,
        ]);

        /*用户管理（更新属性）*/
        Permission::create([
            'id' => 35,
            'name' => 'system.user.is_something',
            'label' => '更新属性',
            'parent_id' => 10,
        ]);

        /**
         * 工具管理
         */
        Permission::create([
            'id' => 36,
            'name' => 'tool',
            'label' => '工具管理',
            'parent_id' => 0,
            'icon' => 'am-icon-paper-plane',
        ]);
        /*
         * 爬虫管理
         */
        Permission::create([
            'id' => 37,
            'name' => 'tool.spider.index',
            'label' => '爬虫管理',
            'parent_id' => 36,
            'icon' => 'am-icon-code-fork',
        ]);
        /*爬虫管理（新增）*/
        Permission::create([
            'id' => 38,
            'name' => 'tool.spider.create',
            'label' => '新增',
            'parent_id' => 37,
        ]);
        /*爬虫管理（保存）*/
        Permission::create([
            'id' => 39,
            'name' => 'tool.spider.store',
            'label' => '保存',
            'parent_id' => 37,
        ]);
        /*爬虫管理（更新属性）*/
        Permission::create([
            'id' => 40,
            'name' => 'tool.spider.is_something',
            'label' => '更新属性',
            'parent_id' => 37,
        ]);
        /*爬虫管理（编辑）*/
        Permission::create([
            'id' => 41,
            'name' => 'tool.spider.edit',
            'label' => '编辑',
            'parent_id' => 37,
        ]);
        /*爬虫管理（更新）*/
        Permission::create([
            'id' => 42,
            'name' => 'tool.spider.update',
            'label' => '更新',
            'parent_id' => 37,
        ]);
        /*爬虫管理（软删除）*/
        Permission::create([
            'id' => 43,
            'name' => 'tool.spider.destroy',
            'label' => '软删除',
            'parent_id' => 37,
        ]);
        /*爬虫管理（多选软删除）*/
        Permission::create([
            'id' => 44,
            'name' => 'tool.spider.destroy_checked',
            'label' => '多选软删除',
            'parent_id' => 37,
        ]);
        /*爬虫管理（回收站）*/
        Permission::create([
            'id' => 45,
            'name' => 'tool.spider.trash',
            'label' => '回收站',
            'parent_id' => 37,
        ]);
        /*爬虫管理（恢复）*/
        Permission::create([
            'id' => 46,
            'name' => 'tool.spider.restore',
            'label' => '恢复',
            'parent_id' => 37,
        ]);
        /*爬虫管理（多选恢复）*/
        Permission::create([
            'id' => 47,
            'name' => 'tool.spider.restore_checked',
            'label' => '多选恢复',
            'parent_id' => 37,
        ]);
        /*爬虫管理（删除）*/
        Permission::create([
            'id' => 48,
            'name' => 'tool.spider.force_destroy',
            'label' => '删除',
            'parent_id' => 37,
        ]);
        /*爬虫管理（多选删除）*/
        Permission::create([
            'id' => 49,
            'name' => 'tool.spider.force_destroy_checked',
            'label' => '多选删除',
            'parent_id' => 37,
        ]);
    }
}
