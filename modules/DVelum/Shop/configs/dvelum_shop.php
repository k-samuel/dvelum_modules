<?php
return [
    'product_config'=> [
        'object'=>'Dvelum_Shop_Product',
        'lang'=>'dvelum_shop',
        'fields' => [
            'price' => [
                'name'=>'price',
                'type' => 'money',
                'system' => true,
                'title'=>'price',
                'required' => true,
                'lazyLang' => true
            ],
            'title' => [
                'name'=>'title',
                'title'=>'title',
                'type' => 'string',
                'system' => true,
                'required' => true,
                'lazyLang' => true
            ],
            'description' => [
                'name'=>'description',
                'title'=>'description',
                'type' => 'text',
                'system' => true,
                'required' => false,
                'lazyLang' => true
            ],
        ]
    ]
];