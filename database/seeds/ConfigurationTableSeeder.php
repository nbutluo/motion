<?php

use Illuminate\Database\Seeder;
use App\Model\Config\Configuration;
use App\Model\Config\ConfigGroup;

class ConfigurationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('configuration')->truncate();
        \Illuminate\Support\Facades\DB::table('config_group')->truncate();
        $datas = [
            [
                'name'=>'系统配置',
                'sort'=>1,
                'configuration' => [
                    [
                        'label' => '登录日志',
                        'key' => 'login_log',
                        'val' => 1,
                        'type' => 'radio',
                        'content' => '0:关闭|1:开启',
                        'tips' => '开启后将记录后台登录日志',
                    ],
                ],
            ],
        ];
        foreach ($datas as $data){
            $group = ConfigGroup::create([
                'name' => $data['name'],
                'sort' => $data['sort'],
            ]);
            if (isset($data['configuration']) && !empty($data['configuration'])){
                foreach ($data['configuration'] as $configuration){
                    $configuration['group_id'] = $group->id;
                    Configuration::create($configuration);
                }
            }
        }
    }
}
