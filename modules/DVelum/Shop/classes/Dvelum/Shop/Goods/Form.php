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

    protected $tagFieldConfig = [
        'xtype' =>'tagfield',
        'queryMode' => 'local',
        'displayField' => 'id',
        'valueField' =>  'id',
        'filterPickList' =>  true,
        'createNewOnEnter' =>  true,
        'forceSelection' => false,
        'encodeSubmitValue' => false,
        'grow' =>  true,
        'editable' => true,
        'hideTrigger' =>  true,
        'anchor' => '100%',
        'cls' =>  'shop-tagField',
        'store' =>  []
    ];

    public function backendFormConfig(Dvelum_Shop_Goods $object)
    {
        $product = $object->getConfig();
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

            $cfg = [
                'name' => $field->getName(),
                'fieldLabel'=> $field->getTitle(),
            ];

            switch ($field->getType())
            {
                case 'number' :

                    $cfg['xtype'] ='numberfield';
                    $cfg['allowDecimals'] = false;

                    if(!is_null($minValue)){
                        $cfg['minValue'] = $minValue;
                    }
                    if(!is_null($maxValue)){
                        $cfg['maxValue'] = $maxValue;
                    }
                    if($field->isRequired()){
                        $cfg['allowBlank'] = false;
                    }

                    if($field->isMultiValue()) {
                       $cfg = array_merge($cfg, $this->tagFieldConfig);
                        $cfg['name'].='[]';
                    }

                    $tabs['general']['items'][] = $cfg;
                    break;

                case 'float' :
                case 'money':

                    $cfg['xtype'] ='numberfield';
                    $cfg['allowDecimals'] = true;

                    if(!is_null($minValue)){
                        $cfg['minValue'] = $minValue;
                    }
                    if(!is_null($maxValue)){
                        $cfg['maxValue'] = $maxValue;
                    }
                    if($field->isRequired()){
                        $cfg['allowBlank'] = false;
                    }

                    if($field->isMultiValue()) {
                        $cfg = array_merge($cfg, $this->tagFieldConfig);
                        $cfg['name'].='[]';
                    }

                    $tabs['general']['items'][] = $cfg;
                    break;

                case 'string' :
                    $cfg['xtype'] ='textfield';

                    if($field->isRequired()){
                        $cfg['allowBlank'] = false;
                    }

                    if($field->isMultiValue()) {
                        $cfg = array_merge($cfg, $this->tagFieldConfig);
                        $cfg['name'].='[]';
                    }

                    $tabs['general']['items'][] = $cfg;
                    break;

                case 'boolean':
                    $tabs['general']['items'][] =[
                        'xtype'=>'checkbox',
                        'name' => $field->getName(),
                        'fieldLabel'=> $field->getTitle(),
                    ];
                    break;

                case 'list':
                    $cfg['xtype'] ='combobox';
                    $cfg['displayField'] = 'id';
                    $cfg['valueField'] = 'id';

                    if($field->isRequired()){
                        $cfg['allowBlank'] = false;
                    }

                    if($field->isMultiValue()) {
                        $cfg = array_merge($cfg, $this->tagFieldConfig);
                        $cfg['forceSelection'] = true;
                        $cfg['hideTrigger'] = false;
                        $cfg['editable'] = false;
                        $cfg['createNewOnEnter'] = false;
                        $cfg['selectOnFocus'] = false;
                        $cfg['name'].='[]';
                    }
                    $cfg['store'] = $field->getList();
                    $tabs['general']['items'][] = $cfg;
                    break;
                case 'text':
                    $tabs[] = [
                      'xtype' => 'medialibhtmlpanel',
                      'name' => $field->getName(),
                      'editorName'  => $field->getName(),
                      'title'=> $field->getTitle(),
                      'frame' =>false
                    ];
                    break;
            }
        }
        return array_values($tabs);
    }

    /**
     * Prepare goods data
     * @param Dvelum_Shop_Goods $object
     * @return array
     */
    public function backendFormData(Dvelum_Shop_Goods $object)
    {
        $product = $object->getConfig();
        $fields = $product->getFields();

        $data = $object->getData();

        $data['id'] = $object->getId();

        $images = $object->get('images');

        if(!empty($images) && is_array($images))
        {
            $imageStore = Dvelum_Shop_Image::factory();
            $images = $imageStore->getImages($images);
            foreach ($images as &$image){
                $image = [
                    'id' => $image['id'],
                    'icon' => $image['pics']['thumbnail']
                ];
            }unset($image);
            $data['images'] = array_values($images);
        }else{
            $data['images'] = [];
        }

        $result = [];

        foreach ($fields as $item)
        {
            $fieldName = $item->getName();
            $formName = $fieldName;

            if($item->isMultiValue() && !$item->isSystem()){
                $formName.='[]';
            }

            if(isset($data[$fieldName])){
                $result[$formName] = $data[$fieldName];
            }else{
                $result[$formName] = null;
            }
        }


        return $result;
    }
}