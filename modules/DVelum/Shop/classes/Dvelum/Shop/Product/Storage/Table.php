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

/**
 * Simple product storage.
 * All data saves to 1 DB table
 * product_id - int
 * field - varchar
 * value - text
 *
 * Advantages:
 *  - simple administration
 *  - simple sphinx integration
 *
 * Disadvantages:
 *  - only exact match filtering
 *  - data types ignored
 *  - not optimal storage size
 */
class Dvelum_Shop_Product_Storage_Table extends Dvelum_Shop_Product_Storage_AbstractAdapter
{
    /**
     * @var Model $itemsModel
     */
    protected $itemsModel;
    /**
     * @var Model $fieldsModel
     */
    protected $fieldsModel;

    public function __construct(Config_Abstract $config)
    {
        parent::__construct($config);
        $this->itemsModel = Model::factory($config->get('items_object'));
        $this->fieldsModel = Model::factory($config->get('fields_object'));
    }


    public function load($productId)
    {
        $item = $this->itemsModel->getItem($productId);

        if(empty($data)){
            $msg = 'Undefined product: '.$productId;
            $this->model->logError($msg);
            throw new Exception($msg);
        }

        $productCode = $item['product_id'];


        $db = $this->model->getSlaveDbConnection();
        $query = $db->select()->from($this->model->table())->where(['product_id'=>$productId]);
        $data = $db->fetchAll($query);



        $productData = [];
        foreach ($data as $k=>$v){
            $productData[$v['field']] = $v['value'];
        }

        // TODO: Implement load() method.
    }

    public function loadProducts(array $productIds)
    {
        // TODO: Implement loadProducts() method.
    }

    public function save(Dvelum_Shop_Product $product)
    {
        $fields = $product->getConfig()->getFields();
        $data = $product->getData();

        $system = [];
        $properties = [];

        $productId = $product->getId();
        $productCode = $product->getCode();

        $system['product'] = $productCode;

        foreach ($fields as $name=>$field)
        {
            if(!isset($data[$name]))
                continue;

            if($field->isSystem()){
                $system[$name] = $data[$name];
            }else{
                if($field->isMultiValue()){
                    foreach ($data[$name] as $val){
                        $properties[] = [
                            'item_id'=> $productId,
                            'product_id'=> $productCode,
                            'value' => $val,
                            'field' => $name
                        ];
                    }
                }else{
                    $properties[] = [
                        'item_id'=> $productId,
                        'product_id'=> $productCode,
                        'value' => $data[$name],
                        'field' => $name
                    ];
                }
            }
        }

        $itemsDb = $this->itemsModel->getDbConnection();
        $itemsDb->beginTransaction();

        if(!$this->itemsModel->insertOnDuplicateKeyUpdate($system)){
            $itemsDb->rollBack();
            return false;
        }

        $fieldsDb = $this->fieldsModel->getDbConnection();
        try{
            $fieldsDb->delete($this->fieldsModel->table(),'item_id ='.intval($productId));
            if(!$this->fieldsModel->multiInsert($properties)){
               return false;
            }
            $itemsDb->commit();
        }catch (Exception $e){
            $itemsDb->rollBack();
            return false;
        }
        return true;
    }

    public function find($filters = false, $params = false)
    {
        // TODO: Implement find() method.
    }

}