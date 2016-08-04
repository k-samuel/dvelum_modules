<?php
namespace Dvelum\Social\Auth\Adapter;

use Dvelum\Social\Auth\Adapter;

class Facebook extends Adapter
{

    protected function requestInfo()
    {

    }

    protected function processInfo($responseInfo)
    {
        $info = parent::processInfo($responseInfo);

        // Add avatar
        if(isset($info['username'])){
            $info['avatar'] =  'http://graph.facebook.com/' . $info['username'] . '/picture?type=large';
        }

        return $info;
    }
}
