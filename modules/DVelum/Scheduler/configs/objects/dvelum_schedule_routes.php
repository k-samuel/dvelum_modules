<?php return array (
  'table' => 'dvelum_schedule_routes',
  'engine' => 'InnoDB',
  'connection' => 'default',
  'acl' => false,
  'parent_object' => '',
  'rev_control' => false,
  'save_history' => true,
  'link_title' => 'name',
  'disable_keys' => false,
  'readonly' => false,
  'locked' => false,
  'primary_key' => 'id',
  'use_db_prefix' => true,
  'slave_connection' => 'default',
  'log_detalization' => 'default',
  'fields' => 
  array (
    'name' => 
    array (
      'type' => '',
      'unique' => 'name',
      'db_isNull' => false,
      'required' => true,
      'validator' => 'Validator_Alphanum',
      'db_type' => 'varchar',
      'db_default' => false,
      'db_len' => 255,
      'is_search' => true,
      'allow_html' => false,
    ),
    'description' => 
    array (
      'type' => '',
      'unique' => '',
      'db_isNull' => true,
      'required' => false,
      'validator' => '',
      'db_type' => 'text',
      'db_default' => false,
      'is_search' => false,
      'allow_html' => false,
    ),
  ),
  'indexes' => 
  array (
    'name' => 
    array (
      'columns' => 
      array (
        0 => 'name',
      ),
      'unique' => true,
      'fulltext' => false,
      'PRIMARY' => false,
    ),
  ),
); 