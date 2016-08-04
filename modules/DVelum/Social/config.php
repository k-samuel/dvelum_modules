<?php
return [
    'id' => 'dvelum_social',
    'version' => '1.0 beta',
    'author' => 'Kirill Egorov',
    'name' => 'DVelum Social',
    'configs' => './configs',
    'vendor'=>'Dvelum',
    'locales' => './locales',
    'autoloader'=> [
        './classes'
    ],
    'post-install'=>'Dvelum_Backend_Social_Installer'
];