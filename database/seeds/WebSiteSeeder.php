<?php

use Illuminate\Database\Seeder;

class WebSiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'seo_meta' => 'globle',
                'seo_content' => 'desk',
            ],
            [
                'seo_meta' => 'description',
                'seo_content' => '健康経営のソリューションや電動式昇降デスク等の人間工学製品を提供しております。',
            ],
            [
                'seo_meta' => 'keywords',
                'seo_content' => '健康経営ソリューション，電動式昇降デスク，オフィス椅子，スタンディングデスク。',
            ],
            [
                'seo_meta' => 'title',
                'seo_content' => 'FlexiSpot 健康経営ソリューション｜電動式昇降デスク｜オフィス椅子｜スタンディングデスク',
            ],
        ];

        foreach ($data as $value) {
            \App\Model\WebsiteSeo::create([
                'seo_meta' => $value['seo_meta'],
                'seo_content' => $value['seo_content'],
            ]);
        }
    }
}
