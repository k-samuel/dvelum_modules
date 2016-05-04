<?php
return [
    'id' => 'dvelum_sitemap',
    'version' => '1.0',
    'author' => 'Kirill Egorov',
    'name' => 'DVelum Sitemap',
    'configs' => './configs',
    'vendor'=>'Dvelum',
    'locales' => './locales',
    'autoloader'=> [
        './library'
    ],
    'post-install'=>'Dvelum_Backend_Sitemap_Installer'
];