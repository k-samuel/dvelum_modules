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
        'adapter'=>'Dvelum_Shop_Image_Medialib',
        // path relative uploads directory (main.php -> uploads)
        'file_path' => 'goods/',
        'category'=>null,
        'uploader' =>[
            'image' => [
                'extensions' => ['.gif', '.png','.jpg','.jpeg'],
                'rewrite'=>false,
                // 15 mb
                'max_file_size'=> 1024*1024*1024*15,
                'sizes' => [
                    'icon'=> [48,48],
                    'thumbnail' => [150, 150],
                    'medium' => [300, 300]
                ],
                'thumb_types' => [
                    'icon' => 'crop',
                    'thumbnail' => 'resize_fit',
                    'medium' => 'resize_fit'
                ]
            ]
        ]
    ]
];