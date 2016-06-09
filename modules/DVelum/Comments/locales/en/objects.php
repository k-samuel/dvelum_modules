<?php return array (
  'dvelum_comment' => 
  array (
    'title' => 'DVelum Comment',
    'fields' => 
    array (
      'user_id' => 'User',
      'date' => 'Date',
      'text' => 'Text',
      'user_ip' => 'User IP',
      'parent_id' => 'Parent Comment ID',
      'xid' => 'Resource XID',
      'resources' => 'Resources',
    ),
  ),
  'dvelum_comment_resource' => 
  array (
    'title' => 'Comment Resources',
    'fields' => 
    array (
      'comment_id' => 'Comment ID',
      'path' => 'Resource Path',
      'resource_type' => 'Resource type',
    ),
  ),
  'dvelum_comment_resources_to_dvelum_comment_resource' => 
  array (
    'title' => 'Many to many (associations table) dvelum comment resources',
    'fields' => 
    array (
      'source_id' => 'SOURCE',
      'target_id' => 'TARGET',
      'order_no' => 'SORT',
    ),
  ),
  'dvelum_vote_comment' => 
  array (
    'title' => 'DVelum  vote comment',
    'fields' => 
    array (
      'vote' => 'Vote',
      'user_id' => 'User',
      'comment_id' => 'Comment',
    ),
  ),
  'dvelum_vote_resource' => 
  array (
    'title' => 'DVelum  vote resource',
    'fields' => 
    array (
      'xid' => 'Resource id',
      'user_id' => 'User',
      'vote' => 'Vote',
    ),
  ),
); 