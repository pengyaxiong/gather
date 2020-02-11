<?php
use Illuminate\Database\Seeder;
use App\Models\System\Role;
use App\Models\System\HasRoles;
class UsersTableSeeder extends Seeder
{
    use HasRoles;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::where('slug','admin')->first();
        $user = Role::where('slug','user')->first();

        factory('App\Models\System\User', 1)->create([
            'name' => 'grubby',
            'real_name' => '博伊卡',
            'email' => '710925952@qq.com',
            'phone' => '13886146473',
            'qq' => '710925952',
            'password' => bcrypt('123456')
        ])->each(function ($u) use ($admin){
            $u->assignRole('超级管理员');
        });

        factory('App\Models\System\User', 2)->create([
            'password' => bcrypt('123456')
        ])->each(function ($u) use ($user){
            $u->assignRole('普通用户');
        });
    }
}