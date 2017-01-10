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
    ),
  ),
  'dvelum_shop_property' => 
  array (
    'title' => 'Аттрибут товара',
    'fields' => 
    array (
      'group_id' => 'Группа',
      'code' => 'Код',
      'type' => 'Тип аттрибута',
      'title' => 'Наименование',
    ),
  ),
  'dvelum_shop_property_group' => 
  array (
    'title' => 'Группа аттрибутов товара',
    'fields' => 
    array (
      'title' => 'Наименование',
    ),
  ),
  'dvelum_shop_product' => 
  array (
    'title' => 'Товар',
    'fields' => 
    array (
      'code' => 'URL код',
      'category_id' => 'Категория каталога',
      'title' => 'Наименование',
      'description' => 'Описание',
    ),
  ),
  'dvelum_shop_category_property' => 
  array (
    'title' => 'Аттрибуты товаров в категории',
    'fields' => 
    array (
      'category_id' => 'Категория каталога',
      'property_id' => 'Аттрибут',
      'required' => 'Обязательный',
    ),
  ),
  'dvelum_shop_property_list' => 
  array (
    'title' => 'Списки для свойств товаров',
    'fields' => 
    array (
      'property_id' => 'ID  Свойства',
      'value' => 'Значение',
    ),
  ),
); 