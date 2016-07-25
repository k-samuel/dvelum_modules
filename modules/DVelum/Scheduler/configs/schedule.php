<?php
return [
  'object' => 'dvelum_schedule',
   //Distributed execution (tasks run on multiple servers)  
  'distributed' => false,
  //Queue adapter for distributed execution Mysql/RabbitMq
  'queue' => 'Mysql',
  //Skip queued tasks (no doubles in queue)
  'skip_queued' => true
];