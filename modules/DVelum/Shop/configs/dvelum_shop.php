<?php
return [
    'product_config'=> [
        'object'=>'Dvelum_Shop_Product',
        'fields' => [
            'price' => [
                'type' => 'money',
                'system' => true,
                'required' => true
            ],
            'title' => [
                'type' => 'string',
                'system' => true,
                'required' => true
            ],
            'description' => [
                'type' => 'text',
                'system' => true,
                'required' => true
            ],
        ]
    ]
];