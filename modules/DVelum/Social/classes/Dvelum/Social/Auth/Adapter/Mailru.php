<?php
namespace Dvelum\Social\Auth\Adapter;

use Dvelum\Social\Auth\Adapter;

class Mailru extends Adapter
{
    protected function requestInfo()
    {

    }

    protected function processInfo($responseInfo)
    {
        $info = parent::processInfo($responseInfo);

        if(isset($info['sex'])) {
            $info['sex'] = ($this->userInfo['sex'] == 1) ? 'female' : 'male';
        }

        return $info;
    }
}
