<?php return array (
  'table' => 'dvelum_shop_property_group',
  'engine' => 'InnoDB',
  'connection' => 'default',
  'acl' => false,
  'parent_object' => '',
  'rev_control' => false,
  'save_history' => true,
  'link_title' => 'title',
  'disable_keys' => false,
  'readonly' => false,
  'locked' => false,
  'primary_key' => 'id',
  'use_db_prefix' => true,
  'slave_connection' => 'default',
  'log_detalization' => 'default',
  'fields' => 
  array (
    'title' => 
    array (
      'type' => '',
      'unique' => 'title',
      'db_isNull' => false,
      'required' => true,
      'validator' => '',
      'db_type' => 'varchar',
      'db_default' => false,
      'db_len' => 255,
      'is_search' => true,
      'allow_html' => false,
    ),
  ),
  'indexes' => 
  array (
    'title' => 
    array (
      'columns' => 
      array (
        0 => 'title',
      ),
      'unique' => true,
      'fulltext' => false,
      'PRIMARY' => false,
    ),
  ),
); 