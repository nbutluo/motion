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
                'value' => 'info',
                'son' => [
                    [
                        'label' => 'address',
                        'value' => 'Ningbo,Zhejiang,China'
                    ],
                    [
                        'label' => 'Phone',
                        'value' => '+86-574-56809465'
                    ],
                    [
                        'label' => 'Fax',
                        'value' => '+86-574-56809465'
                    ],
                ],
            ],
            [
                'label' => 'PRODUCTS',
                'value' => 'PRODUCTS',
                'son' => [
                    [
                        'label' => 'Lifting Columns',
                        'value' => 'Lifting Columns',
                    ],
                    [
                        'label' => 'Control Box',
                        'value' => 'Control Box',
                    ]
                ],
            ],[
                'label' => 'TECHNOLOGY',
                'value' => 'TECHNOLOGY',
                'son' => [
                    [
                        'label' => 'Handset',
                        'value' => 'Handset',
                    ],
                    [
                        'label' => 'Control Box',
                        'value' => 'Control Box',
                    ]
                ],
            ],
            [
                'label' => 'ABOUT US',
                'value' => 'ABOUT US',
                'son' => [
                    [
                        'label' => 'About LoctekMotion',
                        'value' => 'About LoctekMotion',
                    ],
                    [
                        'label' => 'Our History',
                        'value' => 'Our History',
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
