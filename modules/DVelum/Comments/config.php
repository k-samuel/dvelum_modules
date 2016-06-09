<?php
return [
    'id' => 'dvelum_comments',
    'version' => '1.0.0',
    'author' => 'Kirill Egorov',
    'name' => 'DVelum Comments',
    'configs' => './configs',
    'locales' => './locales',
    'resources' =>'./resources',
    'templates' => './templates',
    'vendor'=>'Dvelum',
    'autoloader'=> [
        './classes'
    ],
    'objects' =>[

    ],
    'post-install'=>'Dvelum_Backend_Comments_Installer'
];