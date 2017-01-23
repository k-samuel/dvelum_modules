<?php
return [
    'id'=>[
        'name'=>'id',
        'type' => 'number',
        'system' => true,
        'title'=>'ID',
        'minValue'=> 1,
        'required' => true,
        'lazyLang' => false,
        'group' => 'system'
    ],
    'price' => [
        'name'=>'price',
        'type' => 'money',
        'system' => true,
        'title'=>'price',
        'required' => true,
        'lazyLang' => true,
        'external_code' => '',
        'group' => 'system'
    ],
    'title' => [
        'name'=>'title',
        'title'=>'title',
        'type' => 'string',
        'system' => true,
        'required' => true,
        'lazyLang' => true,
        'external_code' => '',
        'group' => 'system'
    ],
    'model' => [
        'name'=>'model',
        'title'=>'model_number',
        'type' => 'string',
        'system' => true,
        'required' => false,
        'lazyLang' => true,
        'external_code' => '',
        'group' => 'system'
    ],
    'description' => [
        'name'=>'description',
        'title'=>'description',
        'type' => 'text',
        'system' => true,
        'required' => false,
        'lazyLang' => true,
        'external_code' => '',
        'group' => 'system'
    ],
    'external_code'=>[
        'name'=>'external_code',
        'title'=>'externalCode',
        'type' => 'string',
        'system' => true,
        'required' => false,
        'lazyLang' => true,
        'group' => 'system'
    ],
];