<?php

use Illuminate\Database\Seeder;
use App\Model\MenuCategory;

class MenuCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'category' => 'Product',
                'category_title' => [
                    [
                        'category_name' => 'Frame+Tableop',
                        'category_label' => [
                            'Home Use Series',
                            'Office Use Series',
                            'Gaming Series',
                            'Study Series',
                            'Storage Series',
                            'Side-Desk Series'
                        ],
                    ],
                    [
                        'category_name' => 'Frame Only',
                        'category_label' => [
                            'Single Motor',
                            'Double Motor',
                            'Triple Motor',
                            'Multi-Motor'
                        ],
                    ],
                    [
                        'category_name' => 'Bedding',
                        'category_label' => [
                            'Twin Size',
                            'Queen Size',
                            'King Size'
                        ],
                    ],
                    [
                        'category_name' => 'Desk Accessories',
                        'category_label' => [
                            'Desk Converter',
                            'montitor Arms',
                            'Seating',
                            'Other'
                        ],
                    ],
                ],
            ],
            [
                'category' => 'Business Solutions',
                'category_title' => [
                    [
                        'category_name' => 'Office Solutions',
                        'category_label' => [],
                    ],
                    [
                        'category_name' => 'Home Solutions',
                        'category_label' => [],
                    ],
                ],
            ],
            [
                'category' => 'News',
                'category_title' => [
                    [
                        'category_name' => 'About Products',
                        'category_label' => [],
                    ],
                    [
                        'category_name' => 'Ergonomic Design',
                        'category_label' => [],
                    ],
                    [
                        'category_name' => 'Activities',
                        'category_label' => [],
                    ],
                    [
                        'category_name' => 'Indutry News',
                        'category_label' => [],
                    ],
                ],
            ],
            [
                'category' => 'Resource',
                'category_title' => [
                    [
                        'category_name' => 'Video',
                        'category_label' => [],
                    ],
                    [
                        'category_name' => 'Brochure',
                        'category_label' => [],
                    ],
                    [
                        'category_name' => 'Installation Information',
                        'category_label' => [],
                    ],
                    [
                        'category_name' => 'Certification',
                        'category_label' => [],
                    ],
                ],
            ],
            [
                'category' => 'About Loctek',
//                'category_title' => [
//                    [
//                        'category_name' => 'Mission&Vision',
//                        'category_label' => [],
//                    ],
//                    [
//                        'category_name' => 'Company History',
//                        'category_label' => [],
//                    ],
//                ],
            ],
            [
                'category' => 'Contact Us',
            ],
        ];
        foreach ($datas as $data) {
            $category = MenuCategory::create([
                'category_name' => $data['category'],
            ]);
            if (isset($data['category_title']) && !empty($data['category_title'])) {
                foreach ($data['category_title'] as $title) {
                    $titleData = MenuCategory::create([
                        'category_name' => $title['category_name'],
                        'parent_id' => $category->id,
                    ]);
                    if (isset($title['category_label']) && !empty($title['category_label'])) {
                        foreach ($title['category_label'] as $label) {
                            MenuCategory::create([
                                'category_name' => $label,
                                'parent_id' => $titleData->id,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
