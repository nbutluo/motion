<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
Use Illuminate\Support\Facades\Hash;
use App\Model\User\AdminUser;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminUser::create([
            'username' => 'root',
            'password' => Hash::make('123456'),
            'nickname' => '超级管理员',
            'email' => 'root@dgg.net',
            'api_token' => hash('sha256', Str::random(60)),
        ]);
    }
}
