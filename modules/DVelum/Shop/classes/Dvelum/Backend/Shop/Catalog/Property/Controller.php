<?php

class Dvelum_Backend_Shop_Catalog_Property_Controller extends Backend_Controller_Crud
{
    protected $_listFields = ['id','title','code','type'];
    protected $_listLinks = ['group'=>'group_id'];

    protected $_canViewObjects = ['dvelum_shop_property_group'];


    public function getModule()
    {
        return 'Dvelum_Shop_Property';
    }

    public function getObjectName()
    {
        return 'dvelum_shop_property';
    }

    /**
     * Route to group controller
     */
    public function groupAction()
    {
        $this->_router->runController('Dvelum_Backend_Shop_Catalog_Property_Group_Controller', Request::getInstance()->getPart(3));
    }
}