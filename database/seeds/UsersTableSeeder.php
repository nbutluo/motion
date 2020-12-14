<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 生成数据集合
        $users = factory(User::class)->times(100)->create();

        $user = User::find(1);
        $user->name = 'nbutluo';
        $user->email = 'nbutluo@163.com';
        $user->save();
    }
}
