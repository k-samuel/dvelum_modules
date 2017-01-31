<?php
/**
 *  DVelum project http://dvelum.net, http://dvelum.ru, https://github.com/k-samuel/dvelum
 *  Copyright (C) 2011-2017  Kirill Yegorov
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


class Dvelum_Shop_Goods_Form
{

    protected $lang;
    protected $shopLang;

    public function __construct()
    {
        $this->lang = Lang::lang();

    }

    public function backendForm(Dvelum_Shop_Product $product)
    {
        $fields = $product->getFields();

        $tabs = [];

        $tabs['general'] = [
          'xtype' => 'panel',
          'anchor'=>'100%',
          'bodyCls' =>'formBody',
          'bodyPadding' =>3,
          'frame' =>false,
          'layout'=>'anchor',
          'title' => $this->lang->get('GENERAL'),
          'fieldDefaults' => [
              'labelAlign' => 'right',
              'labelWidth' => 160,
              'anchor'=> '100%'
          ],
          'items' => [
              [
                  'xtype'=>'hiddenfield',
                  'name'=>'product',
                  'value'=>$product->getId()
              ]
          ]
        ];

        foreach ($fields as $field)
        {
            if($field->getName() == 'id' || $field->getName() == 'images'){
                continue;
            }

            $minValue = $field->getMinValue();
            $maxValue = $field->getMaxValue();

            switch ($field->getType())
            {
                case 'number' :

                    $cfg = [
                        'xtype'=>'numberfield',
                        'name' => $field->getName(),
                        'fieldLabel'=> $field->getTitle(),
                        'allowDecimals'=>false
                    ];

                    if(!is_null($minValue)){
                        $cfg['minValue'] = $minValue;
                    }
                    if(!is_null($maxValue)){
                        $cfg['maxValue'] = $maxValue;
                    }
                    if($field->isRequired()){
                        $cfg['allowBlank'] = false;
                    }

                    if($field->isMultiValue())
                    {
                        $cfg['registerLink'] = true;
                    }

                    $tabs['general']['items'][] = $cfg;
                    break;

                case 'float' :
                    $cfg =[
                        'xtype'=>'numberfield',
                        'name' => $field->getName(),
                        'fieldLabel'=> $field->getTitle(),
                        'allowDecimals'=>true
                    ];

                    if(!is_null($minValue)){
                        $cfg['minValue'] = $minValue;
                    }
                    if(!is_null($maxValue)){
                        $cfg['maxValue'] = $maxValue;
                    }
                    if($field->isRequired()){
                        $cfg['allowBlank'] = false;
                    }

                    if($field->isMultiValue())
                    {
                        $cfg['registerLink'] = true;
                    }

                    $tabs['general']['items'][] = $cfg;
                    break;

                case 'money':

                    $cfg =[
                        'xtype'=>'numberfield',
                        'name' => $field->getName(),
                        'fieldLabel'=> $field->getTitle(),
                        'allowDecimals'=>true,
                    ];

                    if($field->isRequired()){
                        $cfg['allowBlank'] = false;
                    }

                    if($field->isMultiValue())
                    {
                        $tabs[] = [
                            'xtype' => 'multivaluepanel',
                            'fieldName' => $field->getName(),
                            'datatype' => 'float',
                            'title'=> $field->getTitle(),
                            'frame' =>false,
                            'fieldConfig'=> $cfg,
                            'registerLink'=>true
                        ];

                    }else{
                        $tabs['general']['items'][] = $cfg;
                    }
                    break;

                case 'string' :
                    $cfg =[
                        'xtype'=>'textfield',
                        'name' => $field->getName(),
                        'fieldLabel'=> $field->getTitle(),
                    ];

                    if($field->isRequired()){
                        $cfg['allowBlank'] = false;
                    }

                    if($field->isMultiValue())
                    {
                        $tabs[] = [
                            'xtype' => 'multivaluepanel',
                            'fieldName' => $field->getName(),
                            'datatype' => 'string',
                            'title'=> $field->getTitle(),
                            'frame' =>false,
                            'fieldConfig'=> $cfg,
                            'registerLink'=>true
                        ];

                    }else{
                        $tabs['general']['items'][] = $cfg;
                    }
                    break;

                case 'boolean':
                    $tabs['general']['items'][] =[
                        'xtype'=>'checkbox',
                        'name' => $field->getName(),
                        'fieldLabel'=> $field->getTitle(),
                    ];
                    break;

                case 'list':
                    $cfg =[
                        'xtype'=>'combobox',
                        'name' => $field->getName(),
                        'fieldLabel'=> $field->getTitle(),
                        'displayField'=>'id',
                        'valueField'=>'id',
                        'store'=> $field->getList()
                    ];

                    if($field->isRequired()){
                        $cfg['allowBlank'] = false;
                    }

                    if($field->isMultiValue())
                    {
                        $tabs[] = [
                            'xtype' => 'multivaluepanel',
                            'registerLink'=>true,
                            'fieldName' => $field->getName(),
                            'datatype' => 'string',
                            'title'=> $field->getTitle(),
                            'frame' =>false,
                            'fieldConfig'=> $cfg
                        ];

                    }else{
                        $tabs['general']['items'][] = $cfg;
                    }
                    break;
                case 'text':
                    $tabs[] = [
                      'xtype' => 'medialibhtmlpanel',
                      'name' => $field->getName(),
                      'title'=> $field->getTitle(),
                      'frame' =>false
                    ];

                    break;
            }
        }
        return array_values($tabs);
    }
}