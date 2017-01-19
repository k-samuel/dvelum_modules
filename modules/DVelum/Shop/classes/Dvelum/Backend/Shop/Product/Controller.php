<?php
class Dvelum_Backend_Shop_Product_Controller extends Backend_Controller_Crud
{
    protected $_listFields = ["code","title","id"];
    protected $_listLinks = ["category"];
    protected $_canViewObjects = ["dvelum_shop_category"];

    public function getModule()
    {
        return 'Dvelum_Shop_Product';
    }

    public function  getObjectName()
    {
        return 'Dvelum_Shop_Product';
    }

    protected function _getList()
    {
        $result = parent::_getList();

        if(!empty($result['data']))
        {
            try{
                $configList = Dvelum_Shop_Product_Config::factoryMultiple(Utils::fetchCol('id', $result['data']));
            }catch (Exception $e){
                echo $e->getMessage();
                Model::factory($this->getObjectName())->logError($e->getMessage());
                return ['success'=>false,'msg'=>$this->_lang->get('CANT_EXEC')];
            }
            foreach ($result['data'] as &$item)
            {
                if(isset($configList[$item['id']])){
                    /**
                     * @var Dvelum_Shop_Product_Config $cfg
                     */
                    $cfg = $configList[$item['id']];
                    $item['fields_count'] = count($cfg->getFieldsConfig());
                }
            }unset($item);
        }
        return $result;
    }

    protected function _getData()
    {
        $result = parent::_getData();

        if(!empty($result))
        {
            $productConfig = Dvelum_Shop_Product_Config::factory($result['id']);
            $result['fields'] = array_values($productConfig->getFieldsConfig());

            if(!empty($result['category'])){
                $model = Model::factory('dvelum_shop_category');
                $filters = [
                    $model->getPrimaryKey() => Utils::fetchCol('id', $result['category'])
                ];
                $list = $model->getList(false,$filters,['id'=>$model->getPrimaryKey(),'enabled']);

                if(!empty($list))
                {
                    $list = Utils::rekey('id',$list);
                    foreach ($result['category'] as $k=>&$v){
                        if(isset($list[$v['id']])){
                            $v['published'] =  $list[$v['id']]['enabled'];
                        }
                    }unset($v);
                }
            }
        }
        return $result;
    }

    /**
     * Get list of objects which can be linked
     */
    protected function getRelatedObjectsInfo()
    {
        $object = Request::post('object', 'string', false);

        $data = parent::getRelatedObjectsInfo();

        if(!empty($data['data']) && $object == 'dvelum_shop_category')
        {
            $model = Model::factory('dvelum_shop_category');
            $filters = [
                $model->getPrimaryKey() => Utils::fetchCol('id', $data['data'])
            ];
            $list = $model->getList(false,$filters,['id'=>$model->getPrimaryKey(),'enabled']);

            if(!empty($list))
            {
                $list = Utils::rekey('id',$list);
                foreach ($data['data'] as $k=>&$v){
                    if(isset($list[$v['id']])){
                        $v['published'] =  $list[$v['id']]['enabled'];
                    }
                }unset($v);
            }
        }
        return $data;
    }

    /**
     * Get list of product properties
     */
    public function getProductPropertiesAction()
    {
        $id = Request::post('id', 'integer', false);

        if(empty($id))
            Response::jsonError($this->_lang->get('WRONG_REQUEST'));

        try{
            $productConfig = Dvelum_Shop_Product_Config::factory($id);
            $list = array_values($productConfig->getFieldsConfig());
            // hide system fields
            foreach ($list as $k=>$v){
                if($v['system']){
                    unset($list[$k]);
                }
            }
            Response::jsonSuccess($list);
        }catch (Exception $e){
            Response::jsonError($this->_lang->get('CANT_EXEC'));
        }
    }

    public function getPostedData($objectName)
    {
        // convert fields data before save
        $fields = Request::post('fields','array',[]);
        if(!empty($fields)){
            foreach ($fields as & $field){
                $field = json_decode($field, true);
                unset($field['id']);
            }
        }unset($field);
        $fields = json_encode($fields);
        Request::updatePost('fields', $fields);

        return parent::getPostedData($objectName);
    }
}