<?php return array (
  'dvelum_shop_category' => 
  array (
    'title' => 'Каталог',
    'fields' => 
    array (
      'parent_id' => 'Родительский каталог',
      'title' => 'Наименование',
      'description' => 'Описание',
      'code' => 'URL Код',
      'enabled' => 'Включена',
      'order_no' => '№ По порядку',
    ),
  ),
  'dvelum_shop_product' => 
  array (
    'title' => 'Товар',
    'fields' => 
    array (
      'fields' => 'Поля',
      'category' => 'Категории каталога',
      'code' => 'URL код',
      'external_id' => 'ID  внешней системы',
      'title' => 'Наименование',
    ),
  ),
  'dvelum_shop_product_category_to_dvelum_shop_category' => 
  array (
    'title' => 'Многие ко многим (таблица связей) dvelum_shop_product & dvelum_shop_category',
    'fields' => 
    array (
      'source_id' => 'SOURCE',
      'target_id' => 'TARGET',
      'order_no' => 'SORT',
    ),
  ),
); 