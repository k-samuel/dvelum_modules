<?php
return [
    'facebook' =>[
        'adapter' =>'\\Dvelum\\Social\\Auth\\Adapter\\Facebook',
        'fields'=>[
            'sid'        => 'uid',
            'email'      => 'email',
            'name'       => 'name',
            'page'       => 'link',
            'sex'        => 'gender',
            'birthday'   => 'birthday',
            'username'   => 'username'
            // auto fields: avatar
        ],
        'settings'=>[
            'auth_url' =>'https://www.facebook.com/dialog/oauth',
            'access_token' => 'https://graph.facebook.com/oauth/access_token',
            'auth_params'   =>  [
                'response_type' => 'code',
                'scope'         => 'email,user_birthday',
            ]
        ]
    ],
    'vk' =>[
        'adapter' =>'\\Dvelum\\Social\\Auth\\Adapter\\Vk',
        'fields'=>[
            'sid'        => 'uid',
            'email'      => 'email',
            'avatar'     => 'photo_big',
            'birthday'   => 'bdate'
            // auto fields: page, sex, name
        ],
        'settings'=>[
            'auth_url' =>'http://oauth.vk.com/authorize',
            'access_token'=>'https://api.vkontakte.ru/oauth/access_token',
            'user_info' => 'https://api.vk.com/method/users.get',
            'auth_params'   =>  [
                'response_type' => 'code',
                'scope'         => 'notify',
            ]
        ]
    ],
    'yandex' =>[
        'adapter' =>'\\Dvelum\\Social\\Auth\\Adapter\\Yandex',
        'fields'=>[
            'sid'        => 'id',
            'email'      => 'default_email',
            'name'       => 'real_name',
            'page'       => 'link',
            'avatar'     => 'picture',
            'sex'        => 'sex',
            'birthday'   => 'birthday'
        ],
        'settings'=>[
            'auth_url' =>'https://oauth.yandex.ru/authorize',
            'auth_params'=>[
                'response_type' => 'code',
                'display'         => 'popup'
            ]
        ]
    ],
    'google' =>[
        'adapter' =>'\\Dvelum\\Social\\Auth\\Adapter\\Google',
        'fields'=>[
            'sid'        => 'id',
            'email'      => 'email',
            'name'       => 'name',
            'socialPage' => 'link',
            'avatar'     => 'picture',
            'sex'        => 'gender'
            // auto fields: birthday
        ],
        'settings'=>[
            'auth_url' =>'https://accounts.google.com/o/oauth2/auth',
            'auth_params'=>[
                'response_type' => 'code',
                'scope'         => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
            ]
        ]
    ],
    'odnoklassniki' => [
        'adapter' =>'\\Dvelum\\Social\\Auth\\Adapter\\Odnoklasskinki',
        'fields'=>[
            'sid'        => 'uid',
            'email'      => 'email',
            'name'       => 'name',
            'avatar'     => 'pic_2',
            'sex'        => 'gender',
            'birthday'   => 'birthday'
            // auto fields: page
        ],
        'settings'=>[
            'auth_url' =>'http://www.odnoklassniki.ru/oauth/authorize',
            'access_token' => 'http://api.odnoklassniki.ru/oauth/token.do',
            'auth_params'=>[
                'response_type' => 'code',
            ]
        ]
    ],
    'mailru' => [
        'adapter' =>'\\Dvelum\\Social\\Auth\\Adapter\\Mailru',
        'fields'=>[
            'sid'        => 'uid',
            'email'      => 'email',
            'name'       => 'nick',
            'page' => 'link',
            'avatar'     => 'pic_big',
            'birthday'   => 'birthday'
            // auto fields: sex
        ],
        'settings'=>[
            'auth_url' =>'https://connect.mail.ru/oauth/authorize',
            'access_token' => 'https://connect.mail.ru/oauth/token',
            'auth_params'=>[
                'response_type' => 'code',
            ]
        ]
    ],
    'twitter' => [
        'adapter' =>'\\Dvelum\\Social\\Auth\\Adapter\\Twitter',
        'fields'=>[
            'sid'        => 'id',
            'email'      => 'email',
            'name'       => 'name',
            'sex'        => 'sex',
            'birthday'   => 'bdate'

            // auto fields: page avatar
        ],
        'settings'=>[
            'auth_url' =>'https://api.twitter.com/oauth/authenticate',
            'access_token' => 'https://api.twitter.com/oauth/access_token',
            'request_token' => 'https://api.twitter.com/oauth/request_token',
            'account_data'=>'https://api.twitter.com/1.1/users/show.json',
            'auth_params'=>[
                'response_type' => 'code',
            ]
        ]
    ]

];