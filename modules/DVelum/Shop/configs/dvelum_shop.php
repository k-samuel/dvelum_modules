<?php
return [
    'goods' =>[
        'system_fields'=>'dvelum_shop_fields.php',
    ],
    'product_config' => [
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
        'category'=>null
    ]
];