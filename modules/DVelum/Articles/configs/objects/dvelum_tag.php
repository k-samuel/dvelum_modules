<?php return array (
  'table' => 'articles_tags',
  'engine' => 'InnoDB',
  'connection' => 'default',
  'rev_control' => false,
  'save_history' => false,
  'link_title' => 'id',
  'disable_keys' => false,
  'readonly' => false,
  'locked' => false,
  'primary_key' => 'id',
  'use_db_prefix' => true,
  'fields' => 
  array (
    'article_id' => 
    array (
      'type' => 'link',
      'unique' => '',
      'db_isNull' => false,
      'required' => true,
      'validator' => '',
      'link_config' => 
      array (
        'link_type' => 'object',
        'object' => 'articles',
      ),
      'db_type' => 'bigint',
      'db_default' => false,
      'db_unsigned' => true,
    ),
    'tag_id' => 
    array (
      'type' => 'link',
      'unique' => '',
      'db_isNull' => false,
      'required' => true,
      'validator' => '',
      'link_config' => 
      array (
        'link_type' => 'object',
        'object' => 'tags',
      ),
      'db_type' => 'bigint',
      'db_default' => false,
      'db_unsigned' => true,
    ),
  ),
  'indexes' => 
  array (
    'article_tag' => 
    array (
      'columns' => 
      array (
        0 => 'article_id',
        1 => 'tag_id',
      ),
      'unique' => true,
      'fulltext' => false,
      'PRIMARY' => false,
    ),
  ),
); 