<?php
class Dvelum_Backend_Shop_Catalog_Property_Group_Controller extends Backend_Controller_Crud
{
    protected $_listFields = ['id','title'];

    public function getModule()
    {
        return 'Dvelum_Shop_Property';
    }

    public function getObjectName()
    {
        return 'dvelum_shop_property_group';
    }
}