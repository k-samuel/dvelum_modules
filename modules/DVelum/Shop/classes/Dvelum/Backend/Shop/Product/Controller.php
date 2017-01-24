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

    /**
     * Get shop localization dictionary
     * @return Lang
     */
    protected function getLang()
    {
        $config = Config::storage()->get('dvelum_shop.php')->get('product_config');
        Lang::addDictionaryLoader($config['lang'], $this->_configMain->get('language').'/'. $config['lang'].'.php', Config::File_Array);
        return Lang::lang($config['lang']);
    }

    protected function _getData()
    {
        $result = parent::_getData();

        if(!empty($result))
        {
            $productConfig = Dvelum_Shop_Product_Config::factory($result['id']);
            $groups = $productConfig->getGroupsConfig();
            $result['fields'] = array_values($productConfig->getFieldsConfig());
            $result['groups'] = array_values($groups);

            foreach ($result['fields'] as &$field)
            {
                if(isset($field['group']) && !empty($field['group']) && isset($groups[$field['group']])){
                    $field['group_title'] = $groups[$field['group']]['title'];
                }else{
                    $field['group'] = '';
                    $field['group_title']  = $this->getLang()->get('noGroup');
                }

               if(isset($field['list']) && !empty($field['list'])){
                    $listData = [];
                    foreach ($field['list'] as $v){
                        $listData[] = ['value'=>$v];
                    }
                    $field['list'] = $listData;
               }

            }unset($field);

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
            $groups = $productConfig->getGroupsConfig();
            $list = array_values($productConfig->getFieldsConfig());
            // hide system fields
            foreach ($list as $k=>&$field)
            {
                if($field['system']){
                    unset($list[$k]);
                    continue;
                }
                if(isset($field['group']) && !empty($field['group']) && isset($groups[$field['group']])){
                    $field['group_title'] = $groups[$field['group']]['title'];
                }else{
                    $field['group'] = '';
                    $field['group_title']  = $this->getLang()->get('noGroup');
                }
            }unset($field);
            Response::jsonSuccess(array_values($list));
        }catch (Exception $e){
            Response::jsonError($this->_lang->get('CANT_EXEC'));
        }
    }

    public function getPostedData($objectName)
    {
        // convert fields data before save
        $fields = Request::post('fields','array',[]);
        if(!empty($fields)){
            foreach ($fields as $k=>&$field)
            {
                $field = json_decode($field, true);
                if(isset($field['system']) && $field['system']){
                    unset($fields[$k]);
                }
                if($field['type'] == 'list')
                {
                    if(!empty($field['list']))
                    {
                        if(is_array($field['list'])){
                            $field['list'] = Utils::fetchCol('value',$field['list']);
                        }else{
                            $field['list'] = [];
                        }
                    }else{
                        $field['list'] = [];
                    }
                }else{
                    unset($field['list']);
                }
                unset($field['id']);
                unset($field['group_title']);
            }unset($field);
        }else{
            $fields =[];
        }
        $fields = json_encode($fields);
        Request::updatePost('fields', $fields);

        // convert groups data before save
        $groups = Request::post('groups','array',[]);
        if(!empty($groups)){
            foreach ($groups as $k=>&$group){
                $group = json_decode($group, true);
                unset($group['id']);
                if(isset($group['system']) && $group['system']){
                    unset($groups[$k]);
                }
            }unset($group);
        }else{
            $groups = [];
        }
        $groups = json_encode($groups);
        Request::updatePost('groups', $groups);

        return parent::getPostedData($objectName);
    }
}