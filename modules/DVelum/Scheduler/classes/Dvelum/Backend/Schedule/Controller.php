<?php 
class Dvelum_Backend_Schedule_Controller extends Backend_Controller_Crud
{
    protected $_listFields = ["title","type","enabled","last_launch","starts","errors","id"];
    protected $_listLinks = [];
    protected $_canViewObjects = [""];

    public function getModule()
    {
        return 'Dvelum_Schedule';
    }

    public function getObjectName()
    {
        return 'Dvelum_Schedule';
    }

} 