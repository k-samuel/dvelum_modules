<?php
return [
    'product_config'=> [
        'object'=>'Dvelum_Shop_Product',
        'lang'=>'dvelum_shop',
    ],
    'storage' =>[
        'adapter' => 'Dvelum_Shop_Storage_Table',
        'items_object'=> 'dvelum_shop_goods',
        'fields_object' => 'dvelum_shop_goods_properties',
    ],
    'images' => [
        // path relative uploads directory (main.php -> uploads)
        'uploads_dir' => 'goods/',
        'storage' =>[
            'adapter'=>'Medialibrary',
            'config' => [
                'category'=>null
            ]
        ],
        'uploader_config' => array(
            'image' => [
                'extensions' => ['.gif', '.png','.jpg','.jpeg'],
                'sizes' => [
                    'icon'=> [48,48],
                    'thumbnail' => [150, 94],
                    'medium' => [300, 188]
                ],
                'thumb_types' => [
                    'icon' => 'crop',
                    'thumbnail' => 'resize_fit',
                    'medium' => 'resize_fit'
                ],
            ]
        ),
    ]
];