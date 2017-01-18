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

    /**
     * Get ORM object data
     * Sends a JSON reply in the result and
     * closes the application
     */
    public function loaddataAction()
    {
        $result = $this->_getData();

        if(empty($result)){
            Response::jsonError($this->_lang->get('CANT_EXEC'));
        } else{
            $result['fields'] = json_decode($result['fields'], true);
            Response::jsonSuccess($result);
        }
    }
}