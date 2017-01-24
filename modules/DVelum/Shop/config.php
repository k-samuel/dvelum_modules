<?php
return [
    'id' => 'dvelum_shop',
    'version' => '1.0',
    'author' => 'Kirill Egorov',
    'name' => 'DVelum Shop',
    'description' => 'Catalog module, requires DVelum >=1.0.2',
    'configs' => './configs',
    'locales' => './locales',
    'resources' =>'./resources',
    'templates' => './templates',
    'vendor'=>'Dvelum',
    'autoloader'=> [
        './classes'
    ],
    'objects' =>[
        'dvelum_shop_category',
        'dvelum_shop_product',
        'dvelum_shop_goods',
        'dvelum_shop_goods_properties',
        'dvelum_shop_product_category_to_dvelum_shop_category'
    ],
    'post-install'=>'Dvelum_Backend_Shop_Installer'
];