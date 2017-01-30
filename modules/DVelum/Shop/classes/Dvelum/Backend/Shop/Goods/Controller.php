<?php
/**
 *  DVelum project http://code.google.com/p/dvelum/ , https://github.com/k-samuel/dvelum , http://dvelum.net
 *  Copyright (C) 2011-2017  Kirill Yegorov
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */
class Dvelum_Backend_Shop_Goods_Controller extends Backend_Controller_Crud
{
    protected $_listFields = ["title","id","model","product"];
    protected $_canViewObjects = ["dvelum_shop_category","dvelum_shop_product"];

    public function getModule()
    {
        return 'Dvelum_Shop_Goods';
    }

    public function  getObjectName()
    {
        return 'Dvelum_Shop_Goods';
    }

    protected function _getList()
    {
        $pager = Request::post('pager' , 'array' , []);
        $filter = Request::post('filter' , 'array' , []);
        $query = Request::post('search' , 'string' , false);

        $storage = Dvelum_Shop_Storage::factory();
        $count = $storage->count($filter, $query);
        $data = [];

        if($count)
        {
            $result = $storage->find($filter, $pager, $query);
            /**
             * @var Dvelum_Shop_Goods $item
             */
            foreach ($result as $item)
            {
                $fields = $item->getData();
                $fields['id'] = $item->getId();

                foreach ($fields as $field=>$val){
                    if(!in_array($field,$this->_listFields,true)){
                        unset($fields[$field]);
                    }
                }
                $data[] = $fields;
            }

            $productIds = Utils::fetchCol('product', $data);
            $products = Db_Object::factory('Dvelum_Shop_Product', $productIds);
            foreach ($data as $k=>&$v)
            {
                if(isset($products[$v['product']])){
                    $v['product_title'] = $products[$v['product']]->getTitle();
                }
            }unset($v);
        }

        return ['data' =>$data , 'count'=> $count];
    }

    /**
     * Prepare data for loaddataAction
     * @return array
     * @throws Exception
     */
    protected function _getData()
    {
        $id = Request::post('id' , 'integer' , false);

        if(!$id)
            return [];

        $storage = Dvelum_Shop_Storage::factory();
        try{
            $obj = $storage->load($id);
        }catch(Exception $e){
            Model::factory($this->_objectName)->logError($e->getMessage());
            return [];
        }

        $data = $obj->getData();
        $data['id'] = $obj->getId();

        $images = $obj->get('images');

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
        return $data;
    }

    public function loadObjectAction()
    {
        $id = Request::post('id' , 'integer' , false);

        if(!$id){
            Response::jsonError($this->_lang->get('WRONG_REQUEST'));
        }

        $storage = Dvelum_Shop_Storage::factory();
        try{
            $obj = $storage->load($id);
        }catch(Exception $e){
            Model::factory($this->_objectName)->logError($e->getMessage());
            Response::jsonError($this->_lang->get('CANT_EXEC'));
        }

        $form = new Dvelum_Shop_Goods_Form();

        $config = $form->backendForm($obj->getConfig());
        $data = $obj->getData();

        Response::jsonSuccess(['data'=>$data,'config'=>$config]);
    }
}