<?php
class Dvelum_Backend_Shop_Category_Controller extends Backend_Controller_Crud
{
    protected $_listFields = ["parent_id","title","code","id","enabled"];
    protected $_listLinks = ["parent_id"];
    protected $_canViewObjects = ["dvelum_shop_category"];

    public function getModule()
    {
        return 'Dvelum_Shop_Category';
    }

    public function  getObjectName()
    {
        return 'Dvelum_Shop_Category';
    }

    /**
     * Get catalog tree
     */
    public function treeListAction()
    {
        /**
         * @var Model_Dvelum_Shop_Category $categoryModel
         */
        $categoryModel = Model::factory('Dvelum_Shop_Category');
        Response::jsonArray($categoryModel->getTreeList(['enabled','code','title']));
    }

    /**
     * Update sorting order for category item
     */
    public function sortingAction()
    {
        $this->_checkCanEdit();
        /**
         * @var Model_Dvelum_Shop_Category $categoryModel
         */
        $categoryModel = Model::factory('Dvelum_Shop_Category');

        $id = Request::post('id','integer',false);
        $newParent = Request::post('newparent','integer',false);
        $order = Request::post('order', 'array' , []);

        if(!$id || !strlen($newParent) || empty($order))
            Response::jsonError($this->_lang->get('WRONG_REQUEST'));

        try{
            $pObject = Db_Object::factory('Dvelum_Shop_Category' , $id);
            $pObject->set('parent_id', $newParent);
            $pObject->save();
            $categoryModel->updateSortingOrder($order);
            Response::jsonSuccess();
        } catch (Exception $e){
            Response::jsonError($this->_lang->get('CANT_EXEC'));
        }
    }
}