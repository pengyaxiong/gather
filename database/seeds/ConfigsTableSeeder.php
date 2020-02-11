<?php

use Illuminate\Database\Seeder;
use App\Models\System\Config;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * 系统设置
         */
        Config::create([
            'title' => 'LEANzn后台管理系统',
            'keyword' => '权限管理系统',
            'description' => '我认为最深沉的爱 ，莫过于你离开以后 ，我活成了你的样子',
            'icp' => '鄂ICP备13016268号-2',
            'copyright' => 'Copyright © 2018-2020 LEANzn公司版权所有',
            'author' => 'Grubby',
            'company' => 'LEANzn',
            'qq' => '710925952',
            'email' => 'pengyaxiong0926@gmail.com',
            'telephone' => '84909844',
            'mobile' => '13886146473'
        ]);
    }
}
