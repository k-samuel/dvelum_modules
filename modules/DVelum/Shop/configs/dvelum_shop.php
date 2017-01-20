<?php
return [
    'product_config'=> [
        'object'=>'Dvelum_Shop_Product',
        'lang'=>'dvelum_shop',
    ],
    'storage' =>[
        'adapter' => 'Dvelum_Shop_Product_Storage_Table',
        'items_object'=> 'dvelum_shop_goods',
        'fields_object' => 'dvelum_shop_goods_properties'
    ]
];