<?php
namespace Dvelum\Social\Auth\Adapter;

use Dvelum\Social\Auth\Adapter;

class Odnoklassniki extends Adapter
{
    protected function requestInfo()
    {

    }

    protected function processInfo($responseInfo)
    {
        $info = parent::processInfo($responseInfo);

        if(isset($info['uid'])){
            $info['page'] =  'http://www.odnoklassniki.ru/profile/' . $info['uid'];
        }
        return $info;
    }
}
