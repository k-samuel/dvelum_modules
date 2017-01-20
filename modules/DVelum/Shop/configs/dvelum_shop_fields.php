<?php
return [
    'id'=>[
        'name'=>'id',
        'type' => 'number',
        'system' => true,
        'title'=>'ID',
        'minValue'=> 1,
        'required' => true,
        'lazyLang' => false
    ],
    'price' => [
        'name'=>'price',
        'type' => 'money',
        'system' => true,
        'title'=>'price',
        'required' => true,
        'lazyLang' => true,
        'external_code' => ''
    ],
    'title' => [
        'name'=>'title',
        'title'=>'title',
        'type' => 'string',
        'system' => true,
        'required' => true,
        'lazyLang' => true,
        'external_code' => ''
    ],
    'model' => [
        'name'=>'model',
        'title'=>'model_number',
        'type' => 'string',
        'system' => true,
        'required' => false,
        'lazyLang' => true,
        'external_code' => ''
    ],
    'description' => [
        'name'=>'description',
        'title'=>'description',
        'type' => 'text',
        'system' => true,
        'required' => false,
        'lazyLang' => true,
        'external_code' => ''
    ]
];