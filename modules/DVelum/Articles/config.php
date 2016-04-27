<?php
return [
    'id' => 'dvelum_articles',
    'version' => '1.0',
    'author' => 'Kirill Egorov',
    'name' => 'DVelum Articles',
    'configs' => './configs',
    'locales' => './locales',
    'resources' =>'./resources',
    'autoloader'=> [
        './classes'
    ],
    'objects' =>[
        'dvelum_article',
        'dvelum_article_category',
        'dvelum_article_related_category_to_dvelum_article_category'
    ],
    'post-install'=>'Dvelum_Backend_Articles_Installer'
];