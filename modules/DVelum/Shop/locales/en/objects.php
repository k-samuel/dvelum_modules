<?php return array (
  'dvelum_shop_category' => 
  array (
    'title' => 'Catalog',
    'fields' => 
    array (
      'parent_id' => 'Parent category',
      'title' => 'Title',
      'description' => 'Description',
      'code' => 'URL code',
      'enabled' => 'Enabled',
      'order_no' => 'Sorting order',
      'external_code' => 'External code',
    ),
  ),
  'dvelum_shop_product' => 
  array (
    'title' => 'Product',
    'fields' => 
    array (
      'fields' => 'Fields',
      'category' => 'Category',
      'code' => 'URL code',
      'title' => 'Name',
      'external_code' => 'External code',
    ),
  ),
  'dvelum_shop_product_category_to_dvelum_shop_category' => 
  array (
    'title' => 'Many to many (relations table) dvelum_shop_product & dvelum_shop_category',
    'fields' => 
    array (
      'source_id' => 'SOURCE',
      'target_id' => 'TARGET',
      'order_no' => 'SORT',
    ),
  ),
); 