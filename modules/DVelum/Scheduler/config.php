<?php
return [
    'id' => 'dvelum_scheduler',
    'version' => '1.0',
    'author' => 'Kirill Egorov',
    'name' => 'DVelum Scheduler',
    'configs' => './configs',
    'vendor'=>'Dvelum',
    'locales' => './locales',
    'resources' =>'./resources',
    'autoloader'=> [
        './classes'
    ],
    'post-install'=>'Dvelum_Backend_Schedule_Installer'
];