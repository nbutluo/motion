<?php

use Illuminate\Database\Seeder;
use App\Model\FooterLinks;

class FooterLinksTableSeeder extends Seeder
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
                'label' => 'info',
                'value' => 'LoctekMotion is the leading manufacturer of electric linear actuators, lifting columns and control systems that help create innovative solutions for a multitude of product applications.',
                'son' => [
                    [
                        'label' => 'Address',
                        'value' => 'Ningbo, Zhejiang, China'
                    ],
                    [
                        'label' => 'Email',
                        'value' => 'catherine@loctekmotion.com'
                    ],
                ],
            ],
            [
                'label' => 'PRODUCTS',
                'value' => 'PRODUCTS',
                'son' => [
                    [
                        'label' => 'Standing Desks',
                        'value' => 'Standing Desks',
                    ],
                    [
                        'label' => 'Desk Frames',
                        'value' => 'Desk Frames',
                    ],
                    [
                        'label' => 'Electric Beds',
                        'value' => 'Electric Beds',
                    ],
                    [
                        'label' => 'Accessories',
                        'value' => 'Accessories',
                    ],
                ],
            ],[
                'label' => 'RESOURCE',
                'value' => 'RESOURCE',
                'son' => [
                    [
                        'label' => 'Video',
                        'value' => 'Video',
                    ],
                    [
                        'label' => 'Brochure',
                        'value' => 'Brochure',
                    ],
                    [
                        'label' => 'Installation Information',
                        'value' => 'Installation Information',
                    ],
                    [
                        'label' => 'Certification',
                        'value' => 'Certification',
                    ],
                ],
            ],
            [
                'label' => 'ABOUT US',
                'value' => 'ABOUT US',
                'son' => [
                    [
                        'label' => 'About Us',
                        'value' => 'About Us',
                    ],
                    [
                        'label' => 'Contact Us',
                        'value' => 'Contact Us',
                    ]
                ],
            ]
        ];

        foreach ($data as $value) {
            $father = FooterLinks::create([
                'label' => $value['label'],
                'value' => $value['value'],
            ]);
            if (isset($value['son']) && !empty($value['son'])) {
                foreach ($value['son'] as $son)
                    FooterLinks::create([
                        'label' => $son['label'],
                        'value' => $son['value'],
                        'parent_id' => $father->id,
                    ]);
            }
        }
    }
}
